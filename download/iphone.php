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
            <h4>Phiên bản iPhone</h4>
            1. Cài đặt thông qua Scarlet<br>
            - Cài đặt Scarlert từ Google <a class="text-dark font-weight-bold"
                href="https://resources.usescarlet.com/install.php">Tại đây</a><br>
            - Mở ứng dụng Scarlet và upload file IPA<br>
            <span class="text-danger">*</span> Làm theo hướng dẫn trong Scarlet và trải nghiệm<br><br>
            2. Cài đặt trực tiếp tại Website<br>
            - Link cài đặt chính: <a class="text-dark font-weight-bold" href="https://www.mediafire.com/file/ix1e50vv0uf9wva/NRO_KONG.ipa/file">Tại đây</a><br>
            <span class="text-danger">*</span> Chỉ dành cho người chơi không tải được bằng cách 1<br>
            <span class="text-danger">*</span> Cài đặt xong, anh em vào Cài đặt &gt; Cài đặt chung &gt; Quản lý VPN
            &amp; Thiết bị &gt; Tin cậy là chơi được nha<br><br>
            3. Tải File IPA<br>
            <?php
            require_once '../core/connect.php'; // Kết nối đến cơ sở dữ liệu

            // Hàm thực hiện truy vấn và lấy giá trị cột android
            function getIphoneLink()
            {
                global $conn; // Sử dụng biến kết nối từ bên ngoài

                try {
                    $query = "SELECT iphone FROM adminpanel";
                    $statement = $conn->prepare($query);
                    $statement->execute();

                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    return $result['iphone'];
                } catch (PDOException $e) {
                    // Xử lý lỗi nếu có
                    return null;
                }
            }

            // Gọi hàm và lấy giá trị cột android
            $iphoneLink = getIphoneLink();
            ?>

            <!-- Hiển thị liên kết tải phiên bản Android -->
            <?php if ($iphoneLink): ?>
                <p>Link Tải IPA: <a class="text-dark font-weight-bold"
                        href="<?php echo $iphoneLink; ?>">Tại đây</a></p>
            <?php else: ?>
                <p>Chưa có liên kết tải phiên bản Android.</p>
            <?php endif; ?>
            <span class="text-danger">*</span> Dành cho người chơi biết cài đặt file IPA thông qua Scarlet...
            <h5 class="mt-3">Danh sách lệnh chat hỗ trợ</h5>
            - <span class="font-weight-bold">sak</span>: tự động đánh<br>
            - <span class="font-weight-bold">scd</span>: tự động cho đệ đậu thần khi đệ kêu<br>
            - <span class="font-weight-bold">snhat</span>: tự động nhặt vật phẩm khi được đánh rơi từ quái, boss<br>
            - <span class="font-weight-bold">stbb</span>: hiển thị thông báo Boss ra màn hình<br>
            - <span class="font-weight-bold">sinfo</span>: hiển thị thông tin ngươi chơi ra màn hình<br>
            - <span class="font-weight-bold">sspl</span>: hiển thị thông tin số sao pha lê<br>
            - <span class="font-weight-bold">sk x</span>: đổi nhanh khu vực sang khu <span
                class="font-weight-bold">x</span><br>
            (vd: đổi nhanh sang khu vực 5, chat <span class="font-weight-bold">sk 5</span>)<br>
            - <span class="font-weight-bold">stocdo x</span>: tăng tốc độ game lên <span
                class="font-weight-bold">x</span><br>
            (vd: tăng tốc độ game lên 2, chat <span class="font-weight-bold">stocdo 2</span>)<br>
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