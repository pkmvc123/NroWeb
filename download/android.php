<?php
require_once '../core/set.php';
require_once '../core/connect.php';
require_once '../core/head.php';
?>

                    <div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
                        <div class="page-layout-body">
                            <!-- load view -->
                            <div class="ant-row">
    <div class="row">
        <div class="col">
            <a href="/" style="color: black" class="ant-col ant-col-24 home_page_bodyTitleList__UdhN_">Quay lại diễn đàn</a>
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
        <div class="col">
            <h4>Phiên bản Android</h4>
            <?php
            require_once '../core/connect.php'; // Kết nối đến cơ sở dữ liệu

            // Hàm thực hiện truy vấn và lấy giá trị cột android
            function getAndroidLink()
            {
                global $conn; // Sử dụng biến kết nối từ bên ngoài

                try {
                    $query = "SELECT android FROM adminpanel";
                    $statement = $conn->prepare($query);
                    $statement->execute();

                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return $result['android'];
                } catch (PDOException $e) {
                    // Xử lý lỗi nếu có
                    return null;
                }
            }

            // Gọi hàm và lấy giá trị cột android
            $androidLink = getAndroidLink();
            ?>

            <!-- Hiển thị liên kết tải phiên bản Android -->
            <?php if ($androidLink): ?>
                <p>Link tải phiên bản Android: <a class="text-dark font-weight-bold"
                        href="https://www.mediafire.com/file/ygahtqjnk7n4y6l/NRO_KONG.apk/file">Tại đây</a></p>
            <?php else: ?>
                <p>Hãy tải ngay để trải nghiệm NGỌC RỒNG .</p>
                <?php endif; ?>

        </div>
    </div>
</div>
                                                    </div>
                        <div id="paging" class="d-flex justify-content-end align-items-center flex-wrap">
                        </div>
                                    </ul>
            </div>
        </div>
    </div>
</div>
</div>                            <!-- end load view -->
                        </div>
                    </div>
<?php include_once '../core/footer.php'; ?>
</body>
</html>