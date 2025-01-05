<?php
require_once '../core/set.php';
require_once '../core/connect.php';
require_once '../core/head.php';
if ($_login === null) {
    echo '<script>window.location.href = "../dang-nhap.php";</script>';
}

// chỉ cho phép tài khoản có admin = 1 truy cập
if ($_admin != 1) {
    echo '<script>window.location.href="/"</script>';
    exit;
}
?>

<div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
    <div class="page-layout-body">
        <div class="ant-row">
            <div class="row">
                <div class="col">
                    <a href="/admincp" style="color: black" class="ant-col ant-col-24 home_page_bodyTitleList__UdhN_">Quay lại Cpanel</a>
                </div>
            </div>
        </div>
        <div class="ant-col ant-col-24">
            <div class="ant-list ant-list-split">
                <div class="ant-spin-nested-loading">
                    <div class="ant-spin-container">
                        <ul class="ant-list-items">
                            <div id="data_news">
                                <div class="container pt-5 pb-5">
                                    <div class="row">
                                        <div class="col-lg-6 offset-lg-3">
                                            <?php if ($_admin != 1) { ?>
                                                <p>Bạn không phải là admin! Không thể sử dụng chức năng này</p>
                                            <?php } else { ?>
                                                <b class="text text-danger">Tra cứu người chơi: </b><br>
                                                <b><br>
                                                    <?php
                                                    echo '<form method="post" onsubmit="return validateForm()">';
                                                    echo '<label for="player_name">Tên nhân vật:</label>';
                                                    echo '<input class="form-control" type="text" name="player_name" id="player_name" required autocomplete="off">';
                                                    echo '<br>';
                                                    echo '<button type="submit" name="search_player" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-50">Search Player</button>';
                                                    echo '</form>';
                                                    ?>
                                                <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (isset($_POST['search_player'])) {
                                    $player_name = $_POST['player_name'];

                                    // Corrected query to fetch player information including members from the clan_sv1 table
                                    $query = "SELECT p.name, p.gender, p.data_point, p.data_task, a.username, a.active, a.password_level_2, a.create_time,
                                                     a.vnd, a.tongnap, a.gmail, a.gioithieu, a.tichdiem, a.thoi_vang, p.clan_id_sv1,
                                                     c.name AS clan_name, c.members
                                            FROM player p 
                                            LEFT JOIN account a ON p.account_id = a.id 
                                            LEFT JOIN clan_sv1 c ON p.clan_id_sv1 = c.id 
                                            WHERE p.name = ?";

                                    $statement = $conn->prepare($query);
                                    $statement->execute([$player_name]);
                                    $player = $statement->fetch(PDO::FETCH_ASSOC);

                                    if ($player) {
                                        // Check if 'clan_id_sv1' exists in the result array before using it
                                        $clan_id_sv1 = isset($player['clan_id_sv1']) ? $player['clan_id_sv1'] : null;
                                        if($clan_id_sv1 != -1){
                                            // Decode JSON
                                            $membersArray = json_decode($player['members'], true);
                                            // Check for JSON decode errors (first level)
                                            if (json_last_error() === JSON_ERROR_NONE) {
                                                // Check if membersArray is an array
                                                if (is_array($membersArray)) {
                                                    // Initialize role description
                                                    $roleDescription = 'Không xác định';
                                                    $found = false;
                                                    // Iterate through each member object
                                                    foreach ($membersArray as $memberJson) {
                                                        // Decode the JSON string within the array (second level)
                                                        $member = json_decode($memberJson, true);
                                                        // Check for JSON decode errors (second level)
                                                        if (json_last_error() === JSON_ERROR_NONE) {
                                                            // Check if member is an array and has 'name' and 'role'
                                                            if (is_array($member) && isset($member['name']) && isset($member['role'])) {
                                                                // Check if the name matches
                                                                if ($member['name'] === $player_name) {
                                                                    $found = true;
                                                                    // Assign role based on 'role' value
                                                                    switch ($member['role']) {
                                                                        case 0:
                                                                            $roleDescription = 'Bang chủ';
                                                                            break;
                                                                        case 1:
                                                                            $roleDescription = 'Phó bang';
                                                                            break;
                                                                        case 2:
                                                                            $roleDescription = 'Thành viên';
                                                                            break;
                                                                        default:
                                                                            $roleDescription = 'Chức vụ không xác định';
                                                                    }
                                                                    // Break loop if found
                                                                    break;
                                                                }
                                                            } else {
                                                                echo "<p>Data in 'members' column is not an array or missing 'name' or 'role'.</p>";
                                                            }
                                                        } else {
                                                            echo "<p>Error decoding inner JSON data: " . json_last_error_msg() . "</p>";
                                                            break;
                                                        }
                                                    }
                                                } else {
                                                    echo "<p>'members' column does not contain a valid array.</p>";
                                                }
                                            } else {
                                                echo "<p>Error decoding outer JSON data: " . json_last_error_msg() . "</p>";
                                            }
                                        }

                                        // Display player information
                                        echo '<div class="container pt-5 pb-5" id="pageHeader">';
                                        echo '<div class="row pb-2 pt-2">';
                                        echo '<div class="col-lg-6">';
                                        echo "<h8>TÀI KHOẢN:</h8><br>";
                                        echo "<span>- Tài khoản: " . htmlspecialchars($player['username']) . "</span><br>";

                                        // Check if clan_id_sv1 is in the result array
                                        if ($clan_id_sv1 == -1) {
                                            echo "<span>- Clan: Chưa có bang</span><br>";
                                        } else {
                                            echo "<span>- Clan: " . htmlspecialchars($player['clan_name']) . "<span style='margin-left: 10px;'>|<span style='margin-left: 10px;'>Chức vụ: $roleDescription</span><br>"; // tên clan
                                        }

                                        echo "<span>- Thành Viên: " . ($player['active'] == 0 ? "Chưa mở" : "Đã mở") . "</span><br><br>";
                                        echo "<span>- Số dư: " . number_format($player['vnd']) . " VNĐ</span><br>";
                                        echo "<span>- Tổng nạp: " . htmlspecialchars($player['tongnap']) . " VNĐ</span><br>";
                                        echo "<span>- Số thỏi vàng: " . htmlspecialchars($player['thoi_vang']) . "</span><br><br>";
                                        echo "<span>- Tích điểm: " . htmlspecialchars($player['tichdiem']) . "</span><br>";

                                        // Xử lý hiển thị gmail
                                        if (isset($player['gmail']) && is_string($player['gmail'])) {
                                            $emailLength = strlen($player['gmail']);
                                            if ($emailLength > 2) {
                                                $visiblePart = substr($player['gmail'], 0, 2);
                                                $hiddenPart = str_repeat("*", max(0, $emailLength - 2));
                                                $emailMasked = $visiblePart . $hiddenPart . "@gmail.com";
                                            } else {
                                                $emailMasked = str_repeat("*", $emailLength) . "@gmail.com";
                                            }
                                        } else {
                                            $emailMasked = "Chưa cập nhật";
                                        }
                                        echo "<span>- Gmail: " . $emailMasked . "</span><br>";
                                        echo "<span>- Mã bảo vệ: " . ($player['password_level_2'] != null ? "Đã cập nhật" : "Chưa có") . "</span><br>";
                                        $create_time = $player['create_time'];
                                        // Tạo đối tượng DateTime từ chuỗi thời gian
                                        $date = new DateTime($create_time);
                                        // Định dạng lại chuỗi thời gian theo định dạng mong muốn
                                        // $formatted_date = $date->format('Y.m.d | H : i : s');
                                        $formatted_date = $date->format('d.m.Y | H : i : s');
                                        echo "<span>- Ngày tạo Account: " . $formatted_date . "</span><br><br>";
                                        echo "</div>";

                                        // Thông tin nhân vật
                                        echo '<div class="col-lg-6">';
                                        echo '<h8>NHÂN VẬT:</h8><br>';
                                        echo "<span>- Tên: " . $player['name'] . "</span><br>"; // tên nhân vật
                                        echo "<span>- Hành Tinh: " . ($player['gender'] == '0' ? 'Trái Đất' : ($player['gender'] == '1' ? 'Namếc' : ($player['gender'] == '2' ? 'Xayda' : 'Không xác định'))) . "</span><br>"; // hiện thị hành tinh nhân vật

                                        $nhiemVuQuery = "SELECT name FROM task_main_template WHERE id = ?";
                                        $nhiemVuStatement = $conn->prepare($nhiemVuQuery);
                                        $chuoiNhiemVu = json_decode($player['data_task'], true);
                                        $nhiemVuID = $chuoiNhiemVu[0];
                                        $nhiemVuStatement->bindParam(1, $nhiemVuID, PDO::PARAM_INT);
                                        $nhiemVuStatement->execute();

                                        $nhiemVuResult = $nhiemVuStatement->fetch(PDO::FETCH_ASSOC);

                                        $tenNhiemVu = $nhiemVuResult ? $nhiemVuResult['name'] : '';

                                        echo "<span>- Nhiệm Vụ: $tenNhiemVu</span><br><br>"; // hiển thị tên nhiệm vụ
                                        echo '<h8>CHỈ SỐ:</h8><br>'; // hiển thị chỉ số

                                        // Chuyển đổi JSON thành mảng
                                        $chiSo = json_decode($player['data_point'], true);

                                        // Lấy danh sách các chỉ số cần lấy
                                        $chiSoCanLay = array_intersect_key($chiSo, array_flip(['1', '2', '5', '6', '7', '8', '9']));

                                        // Hiển thị các chỉ số sư phụ nếu có
                                        foreach ($chiSoCanLay as $key => $value) {
                                            switch ($key) {
                                                case '1':
                                                    $sucManh = number_format($value);
                                                    echo "<span>- Sức Mạnh: $sucManh</span><br>";
                                                    break;
                                                case '2':
                                                    $tiemNang = number_format($value);
                                                    echo "<span>- Tiềm Năng: $tiemNang</span><br>";
                                                    break;
                                                case '5':
                                                    $mau = number_format($value);
                                                    echo "<span>- HP: $mau</span><br>";
                                                    break;
                                                case '6':
                                                    $theLuc = number_format($value);
                                                    echo "<span>- MP: $theLuc</span><br>";
                                                    break;
                                                case '7':
                                                    $sucDanh = number_format($value);
                                                    echo "<span>- Sức Đánh Gốc: $sucDanh</span><br>";
                                                    break;
                                                case '8':
                                                    $giapGoc = number_format($value);
                                                    echo "<span>- Giáp Gốc: $giapGoc</span><br>";
                                                    break;
                                                case '9':
                                                    $chiMangGoc = number_format($value);
                                                    echo "<span>- Chí Mạng Gốc: $chiMangGoc</span><br>";
                                                    break;
                                            }
                                        }
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    } else {
                                        echo "<p>Người chơi không tồn tại.</p>";
                                    }
                                }
                                ?>

                            </div>
                            <div id="paging" class="d-flex justify-content-end align-items-center flex-wrap"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../public/dist/js/blockweb.js"></script>
<?php include_once '../core/footer.php'; ?>
