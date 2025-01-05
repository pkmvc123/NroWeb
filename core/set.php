<?php
require_once 'config.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Kiểm tra và khởi động phiên làm việc nếu chưa được khởi động
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function fetchUserData($conn, $username) {
    $stmt = $conn->prepare("SELECT * FROM account WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $user_arr = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user_arr) {
        header("Location: /logout.php");
        exit();
    }
    $_username = htmlspecialchars($user_arr['username']);
    $_password = htmlspecialchars($user_arr['password']);
    $_gmail = htmlspecialchars($user_arr['gmail']);
    $_gioithieu = htmlspecialchars($user_arr['tichdiem']);
    $_admin = htmlspecialchars($user_arr['is_admin']);
    $_coin = $user_arr['vnd'];
    $_tcoin = htmlspecialchars($user_arr['tongnap']);
    $_status = $user_arr['active'];
    // Gọi hàm has_password_level_2 để kiểm tra xem người dùng đã đặt Mã bảo vệ hay chưa
    $has_password_level_2 = has_password_level_2($username);
    return [
        "_username" => $_username,
        "_password" => $_password,
        "_gmail" => $_gmail,
        "_gioithieu" => $_gioithieu,
        "_admin" => $_admin,
        "_coin" => $_coin,
        "_tcoin" => $_tcoin,
        "_status" => $_status,
        "has_password_level_2" => $has_password_level_2,
    ];
}

function getPlayerNameByUsername($conn, $username) {
    // Fetch user id from account table
    $stmt = $conn->prepare("SELECT id FROM account WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        return null;
    }
    $user_id = $user['id'];
    $stmt = $conn->prepare("SELECT name FROM player WHERE account_id = :account_id");
    $stmt->bindParam(":account_id", $user_id);
    $stmt->execute();
    $player = $stmt->fetch(PDO::FETCH_ASSOC);
    return $player ? $player['name'] : null;
}

$_login = $_login ?? null;
$_user = $_SESSION['account'] ?? null;

if ($_user !== null) {
    $_login = "on";
    $user_data = fetchUserData($conn, $_user);
    $_username = $user_data["_username"];
    $_password = $user_data["_password"];
    $_gmail = $user_data["_gmail"];
    $_gioithieu = $user_data["_gioithieu"];
    $_admin = $user_data["_admin"];
    $_coin = $user_data["_coin"];
    $_tcoin = $user_data["_tcoin"];
    $_status = $user_data["_status"];
    $has_password_level_2 = $user_data["has_password_level_2"];
    $player_name = getPlayerNameByUsername($conn, $_username);
} else {
    $_login = null;
}

if (isset($_GET['out'])) {
    if ($_login == "on") {
        // Người dùng đã đăng nhập, không thực hiện logout
        header("Location: /");
        exit();
    } else {
        // Người dùng chưa đăng nhập, thực hiện logout
        session_destroy();
        header("Location: /");
        exit();
    }
}
?>
