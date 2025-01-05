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

<style>
    th,
    td {
        white-space: nowrap;
        padding: 5px 4px !important;
        font-size: 11px;
    }
    .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f3e8d5;
            padding: 10px;
        }
        .header a {
            color: black;
        }
        .left{
            font-size: 1.2rem;
            font-weight: 600;
        }
        .right {
            font-size: 1.2rem;
            font-weight: 600;
            margin-top: 10px;
        }
</style>

<div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
    <div class="page-layout-body">
        <div class="header">
            <a href="../admincp/giffcode.php" class="left">Quay lại trang GiftCode</a>
            <small class="right">Cập nhật lúc:
                <?php echo date('H:i - d/m/Y'); ?>
            </small>
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
                                                <b class="text text-danger">Tra cứu người chơi: </b><br><br>
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
                                                     c.name AS clan_name, c.members, g.id_giftcode, g.id_player, g.name AS gift_name, g.entry_time
                                            FROM player p 
                                            LEFT JOIN account a ON p.account_id = a.id
                                            LEFT JOIN clan_sv1 c ON p.clan_id_sv1 = c.id
                                            LEFT JOIN history_giftcode g ON p.id = g.id_player
                                            WHERE p.name = ?
                                            ORDER BY g.entry_time DESC";

                                    $statement = $conn->prepare($query);
                                    $statement->execute([$player_name]);
                                    $players = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    if ($players) {
                                        $hasGiftCodes = false;
                                        foreach ($players as $row) {
                                            if (!empty($row['id_giftcode'])) {
                                                $hasGiftCodes = true;
                                                break;
                                            }
                                        }

                                        if ($hasGiftCodes) {
                                            echo '<h6 class="text-center">LỊCH SỬ NHẬP GIFTCODE PLAYER</h6>';
                                            echo '<table class="table table-borderless text-center">';
                                                echo '<thead>';
                                                    echo '<tr>';
                                                        echo '<th>STT</th>';
                                                        echo '<th>TÀI KHOẢN</th>';
                                                        echo '<th>NAME PLAYER</th>';
                                                        echo '<th>ID GIFTCODE</th>';
                                                        echo '<th>THỜI GIAN NHẬP</th>';
                                                    echo '</tr>';
                                                echo '</thead>';
                                                echo '<tbody>';
                                                    $count = 1;
                                                    foreach ($players as $row) {
                                                        if (!empty($row['id_giftcode'])) {
                                                            echo '<tr>
                                                                <td>' . $count . '</td>
                                                                <td>' . $row['username'] . '</td>
                                                                <td>' . $row['name'] . '</td>
                                                                <td>' . $row['id_giftcode'] . '</td>
                                                                <td>' . $row['entry_time'] . '</td>
                                                            </tr>';
                                                            $count++;
                                                        }
                                                    }
                                                echo '</tbody>';
                                            echo '</table>';
                                        } else {
                                            echo "<p>Người chơi: [ " . $row['name'] . " ] chưa nhập GiftCode nào.</p>";
                                        }
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
