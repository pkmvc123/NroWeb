<?php
require_once 'cauhinh.php';
require_once 'set.php';
require_once 'connect.php';

try {
    // Truy vấn lấy cột logo và domain từ bảng adminpanel
    $query = "SELECT logo, domain FROM adminpanel";
    $statement = $conn->prepare($query);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $logo = $result['logo'];
    $domain = $result['domain'];
} catch (PDOException $e) {
    // Xử lý lỗi nếu có
    die("Error: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title><?php echo $_title; ?></title>
	<link rel="canonical" href="http://127.0.0.1/" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://127.0.0.1/" />
    <meta property="og:title" content="NGỌC RỒNG " />
    <meta property="og:description" content="Website chính thức của <?php echo $_tenmaychu; ?> – Game Bay Vien Ngoc Rong Mobile nhập vai trực tuyến trên máy tính và điện thoại về Game 7 Viên Ngọc Rồng hấp dẫn nhất hiện nay!" />
    <meta property="og:image" content="" />
    <link rel="shortcut icon" href="/public/images/TW.svg">
    <meta name="description" content="Website chính thức của <?php echo $_tenmaychu; ?> – Game Bay Vien Ngoc Rong Mobile nhập vai trực tuyến trên máy tính và điện thoại về Game 7 Viên Ngọc Rồng hấp dẫn nhất hiện nay!">
    <meta name="keywords" content="ngoc rong mobile, game ngoc rong, game 7 vien ngoc rong, game bay vien ngoc rong">
    <link rel="stylesheet" href="/public/dist/css/style.css">
    <link rel="stylesheet" href="/public/dist/css/main.css" />
    <link rel="stylesheet" href="/public/dist/css/main2.css" />
    <link rel="stylesheet" href="/public/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/dist/css/all.min.css" />
    <link rel="stylesheet" href="/public/dist/css/sweetalert2.min.css" />
    <link rel="stylesheet" href="/public/dist/css/notiflix-3.2.6.min.css" />
    <!-- <script src="http://127.0.0.1/public/dist/js/bootstrap.min.js"></script> -->
    <script src="/public/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/dist/js/jquery-3.6.0.min.js"></script>
    <script src="/public/dist/js/sweetalert2.min.js"></script>
    <script src="/public/dist/js/notiflix-3.2.6.min.js"></script>  
</head>
<body>
    <section class="ant-layout page-layout-color body-bg">
        <main class="ant-layout-content page-body page-layout-color">
            <div class="page-layout-content">
                <div class="ant-row ant-row-space-around">
                    <div class="ant-col page-layout-header ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
                        <div class="page-layout-header-content">
                            <a href="/">
                                <img src="<?php echo $logo; ?>" class="header-logo" style="display: block;margin-left: auto;margin-right: auto;max-height: 120px; auto;max-width: 300px;">
                            </a>
                            <div>
                   <?php
    if ($_login === null) {
        ?>
        <div class="container color-main2 pb-2">
            <div class="text-center">
                <div class="row">
                    <div class="col pr-0">
                        <a type="button" href="/dang-nhap.php" class="ant-btn ant-btn-default header-btn-login mt-3 me-2"><span>Đăng nhập ngay</span></a>
                        <a type="button" href="/dang-ky.php" class="ant-btn ant-btn-default header-btn-login mt-3"><span>Đăng ký</span></a>
                    </div>
                </div>
            </div>
    <?php } else {
        if ($_admin == 1) { // Kiểm tra quyền truy cập
            ?>
            <div class="container color-main2 pb-2">
                <div class="text-center">
                    <div class="row">
                    </div>
                </div>
            </div>
            <div class="container color-main pt-3 pb-4">
                <div class="text-center">
                    <div id="header-update" style="margin-bottom: 6px;"></div>
                    <div class="row ant-space ant-space-horizontal ant-space-align-center space-header-menu d-flex justify-content-center" style="flex-wrap:wrap;margin-bottom:-10px">
                        <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                            <div>
                                <a href="../admincp">
                                    <button type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                        <i class="fa fa-cog fa-spin fa-1x fa-fw"></i>
                                        <b>Cpanel</b>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                            <div>
                                <a href="../profile.php">
                                    <button type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                        <b>Profile</b>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                            <div>
                                <a href="../cap-nhat-thong-tin.php">
                                    <button type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                        <b>Update Profile</b>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                            <div>
                                <a href="../pass2.php">
                                    <button type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                        <b>Pass Cấp 2</b>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                            <div>
                                <a href="../logout.php">
                                    <button type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                        <b>Đăng Xuất</b>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <script>
                            function updateRemainingTime() {
                                fetch('../api/cauhinh/api-head.php')
                                    .then(response => response.text())
                                    .then(data => {
                                        document.getElementById("header-update").innerHTML = data;
                                    })
                                    .catch(error => console.error(error));
                            }
                            setInterval(updateRemainingTime, 1000); // Cập nhật mỗi giây (1000ms)
                        </script>
                    </div>
                </div>
            <?php
        } else {
            ?>
            <div class="container color-main2 pb-2">
                <div class="text-center">
                    <div class="row">
                    
                    </div>
                </div>
            </div>
            <div class="container color-main pt-3 pb-4">
                <div class="text-center">
                    <!-- Trong phần HTML-->
                    <div id="header-update"></div>
                    <script>
                        // Sử dụng JavaScript và AJAX để gửi yêu cầu đến máy chủ và cập nhật nội dung của vùng hiển thị kết quả
                        function updateRemainingTime() {
                            var xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function () {
                                if (this.readyState === 4 && this.status === 200) {
                                    // Nhận phản hồi từ máy chủ và cập nhật nội dung của vùng hiển thị kết quả
                                    document.getElementById("header-update").innerHTML = this.responseText;
                                }
                            };
                            xhttp.open("GET", "../api/cauhinh/api-head.php", true); // Thay đổi đường dẫn đến tệp PHP xử lý
                            xhttp.send();
                        }
                        // Tự động cập nhật thời gian mỗi giây
                        setInterval(updateRemainingTime, 1000);
                    </script>
                    <div class="row ant-space ant-space-horizontal ant-space-align-center space-header-menu d-flex justify-content-center" style="flex-wrap:wrap;margin-bottom:-10px">
                        <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                            <div>
                                <a href="../profile.php">
                                    <button type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                        <b>Profile</b>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                            <div>
                                <a href="../cap-nhat-thong-tin.php">
                                    <button type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                        <b>Update Profile</b>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                            <div>
                                <a href="../doi-mat-khau.php">
                                    <button type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                        <b>Đổi Mật Khẩu</b>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                            <div>
                                <a href="../pass2.php">
                                    <button type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                        <b>Pass Cấp 2</b>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                            <div>
                                <a href="../logout.php">
                                    <button type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                        <b>Đăng Xuất</b>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col text-center"></div>
                    </div>
                </div>
            <?php
        }
    }
    ?>
    </div>
                            <div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
                                <div class="ant-row ant-row-space-around ant-row-middle header-menu">
                                    <div class="ant-col ant-col-24">
                                        <div class="row ant-space ant-space-horizontal ant-space-align-center space-header-menu d-flex justify-content-center" style="flex-wrap:wrap;margin-bottom:-10px">
                                            <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                                                <div>
                                                    <a href="../mo-thanh-vien.php">
                                                        <button type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                                            <b>Mở Thành Viên</b>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>                                      
                                            <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                                                <div>
                                                    <a href="../nap-so-du.php">
                                                        <button type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                                            <b>Nạp Tiền</b>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                                                <div>
                                                    <a href="../doi-thoi-vang.php">
                                                        <button type="button" class="ant-btn ant-btn-default header-menu-item w-100 /recharge">
                                                            <b>Đổi Thỏi Vàng</b>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                                                <div>
                                                    <a href="../top-server.php">
                                                        <button type="button" class="ant-btn ant-btn-default header-menu-item w-100 /exchange">
                                                            <b>List Top</b>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                                                <div>
                                                    <a href="https://www.facebook.com/groups/1097261918117406/?ref=share&mibextid=NSMWBT">
                                                        <button type="button" class="ant-btn ant-btn-default header-menu-item w-100 /fanpage">
                                                            <b>Fanpage</b>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                                                <div>
                                                    <a href="https://zalo.me/0966376155" target="_blank">
                                                        <button type="button" class="ant-btn ant-btn-default header-menu-item w-100 /fanpage">
                                                            <b>ZALO</b>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ant-col home_page_bodyTitleList__UdhN_" style="text-align: center;">
                        <?php echo $_mienmaychu; ?>
                        <!-- <img src="/public/images/TW.svg" style="max-height: 40px; max-width: 20%" /> 
                        <img src="/public/images/bjw.png" style="max-height: 25px; max-width: 20%" /> -->
                    </div>
                    <div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
                        <div class="ant-row ant-row-space-around ant-row-middle header-menu">
                            <div class="ant-col ant-col-24">
                                <div class="row ant-space ant-space-horizontal ant-space-align-center space-header-menu d-flex justify-content-center" style="flex-wrap:wrap;margin-bottom:-10px">
                                    <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                                        <div>
                                            <a href="../download/windows.php">
                                                <button style="height:45px" type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                                    <img src="/public/images/Windows.png" style="width:97px" />
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                                        <div>
                                            <a href="../download/android.php">
                                                <button style="height:45px" type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                                    <img src="/public/images/Android.png" style="width:97px" />
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                                        <div>
                                            <a href="../download/iphone.php">
                                                <button style="height:45px" type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                                    <img src="/public/images/Iphone.png" style="width:97px" />
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ant-space-item col-6 col-md-3 col-lg-2" style="padding-bottom:10px">
                                        <div>
                                            <a href="../download/jar.php">
                                                <button style="height:45px" type="button" class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-100">
                                                    <b class="flex justify-between font-medium text-white">Tải Bản Jar</b>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>