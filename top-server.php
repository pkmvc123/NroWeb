<?php
require_once 'core/connect.php';
require_once 'core/set.php';
require_once 'core/cauhinh.php';
include_once 'core/head.php';
include_once 'core/gioi-thieu.php';
?>

<style>
.table {
    border-collapse: collapse;
    width: 100%;
}
.table th, .table td {
    border: 1px solid black; 
    padding: 8px;
}
.table th {
    background-color: #f2f2f2; 
}
</style>

<div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
    <div class="page-layout-body">
        <!-- load view -->
        <div class="row"></div>
        <div class="ant-col ant-col-24 home_page_bodyTitleList__UdhN_">
            <small>Cập nhật lúc:
                <?php echo date('H:i - d/m/Y'); ?>
            </small>
        </div>
        <div class="ant-col ant-col-24">
            <div class="home_page_listItem__GD_iE" style="display:flex">
                <div class="container color-forum pt-2">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-center">BXH TOP Sức Mạnh</h6>
                            <table class="table table-borderless text-center">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Nhân Vật</th>
                                        <th>Sức Mạnh</th>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <?php
                                    $query = "SELECT player.name, SUBSTRING_INDEX(SUBSTRING_INDEX(player.data_point, ',', 2), ',', -1) AS sucmanh FROM player ORDER BY sucmanh DESC LIMIT 10";
                                    $stmt = $conn->query($query);
                                    $stt = 1;
                                    if (!$stmt) {
                                        echo 'Lỗi truy vấn SQL: ' . $conn->error;
                                    } else if ($stmt->rowCount() > 0) {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo '
                                    <tr>
                                    <td>' . $stt . '</td>
                                    <td>' . $row['name'] . '</td>
                                    <td>' . number_format($row['sucmanh'], 0, ',') . '</td>
                                    </tr>
                                    ';
                                            $stt++;
                                        }
                                    } else {
                                        echo '<div class="alert alert-success">Máy Chủ 1 chưa có thống kê bảng xếp hạng!</div>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ant-col ant-col-24">
            <div class="home_page_listItem__GD_iE" style="display:flex">
                <div class="container color-forum pt-2">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-center">BXH TOP Nhiệm Vụ</h6>
                            <table class="table table-borderless text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nhân Vật</th>
                                        <th>Nhiệm Vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT player.name, CAST(JSON_EXTRACT(player.data_task, '$[0]') AS UNSIGNED) AS task_count FROM player WHERE JSON_VALID(player.data_task) ORDER BY task_count DESC, player.id ASC LIMIT 10";
                                    $stmt = $conn->query($query);
                                    $stt = 1;
                                    if (!$stmt) {
                                        echo 'Lỗi truy vấn SQL: ' . $conn->error;
                                    } else if ($stmt->rowCount() > 0) {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo '
                                            <tr>
                                                <td>' . $stt . '</td>
                                                <td>' . htmlspecialchars($row['name']) . '</td>
                                                <td>' . number_format($row['task_count'], 0, ',', '.') . '</td>
                                            </tr>
                                            ';
                                            $stt++;
                                        }
                                    } else {
                                        echo '<tr><td colspan="3"><div class="alert alert-success">Máy Chủ 1 chưa có thống kê bảng xếp hạng!</div></td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ant-col ant-col-24">
            <div class="home_page_listItem__GD_iE" style="display:flex">
                <div class="container color-forum pt-2">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-center">BXH ĐUA TOP Nạp</h6>
                            <table class="table table-borderless text-center">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Nhân Vật</th>
                                        <th>Tổng Nạp</th>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <?php
                                    $query = "SELECT player.name, SUM(account.tongnap) AS tongnap FROM account JOIN player ON account.id = player.account_id GROUP BY player.name ORDER BY tongnap DESC LIMIT 10";
                                    $stmt = $conn->query($query);
                                    $stt = 1;
                                    if (!$stmt) {
                                        echo 'Lỗi truy vấn SQL: ' . $conn->error;
                                    } else if ($stmt->rowCount() > 0) {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo '
                                    <tr>
                                    <td>' . $stt . '</td>
                                    <td>' . $row['name'] . '</td>
                                    <td>' . number_format($row['tongnap'], 0, ',') . 'đ</td>
                                    </tr>
                                    ';
                                            $stt++;
                                        }
                                    } else {
                                        echo '<div class="alert alert-success">Máy Chủ 1 chưa có thống kê bảng xếp hạng!</div>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ant-col ant-col-24 home_page_bodyTitleList__UdhN_">
            <small>
                <?php
                $query = "SELECT COUNT(*) AS total_player FROM player";
                $stmt = $conn->query($query);
                if ($stmt) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo 'Tổng số tài khoản: ' . $row['total_player'];
                } else {
                    echo 'Không thể lấy thông tin tài khoản.';
                }
                // Đóng kết nối
                $conn = null;
                ?>
            </small>
        </div>
        <?php echo gioiThieuGame(); ?>
    </div>
</div>                  
<?php include_once 'core/footer.php'; ?>