<?php
require_once '../core/set.php';
require_once '../core/connect.php';
require_once '../core/head.php';
if ($_login === null) {
    echo '<script>window.location.href = "../dang-nhap.php";</script>';
}

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
                                            <h4>Thêm Gift Code - Máy Chủ 1</h4><br>
                                            <?php if ($_admin != 1) { ?>
                                                <p>Bạn không phải là admin! Không thể sài được chứ năng này</p>
                                            <?php } else { ?>
                                                <b class="text text-danger">Lưu Ý: </b><br>
                                                - Nếu nhập thời gian hết hạn trước ngày hiện tại thì <br>
                                                thời gian hết hạn sẽ được tính là ngày nhập của năm sau!
                                                <br>
                                                <br>
                                                <?php
                                                $_alert = '';

                                                // Xử lý khi form được submit
                                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                    // Lấy dữ liệu từ form
                                                    $code = $_POST["code"];
                                                    $count_left = intval($_POST["count_left"]);
                                                    $items = intval($_POST["items"]);
                                                    $quantity = intval($_POST["quantity"]);
                                                    $expired_input = $_POST["expired"];
                                                    $id_option = $_POST["id_option"];
                                                    $id_param = $_POST["id_param"];

                                                    // Xử lý ngày hết hạn
                                                    $date_parts = explode('/', $expired_input);
                                                    $day = intval($date_parts[0]);
                                                    $month = intval($date_parts[1]);

                                                    // Xử lý JSON cho itemoption
                                                    $item_option_data = [];
                                                    $id_option = explode('-', $_POST["id_option"]);
                                                    $quantities = explode('-', $_POST["id_param"]);

                                                    foreach ($id_option as $key => $option_id) {
                                                        $parm_option = $quantities[$key];
                                                        $item_option_data[] = ["id" => intval($option_id), "param" => intval($parm_option)];
                                                    }

                                                    // Lấy năm hiện tại và tháng hiện tại
                                                    $current_year = date('Y');
                                                    $current_month = date('n'); // 'n' trả về tháng không có số 0 ở đầu

                                                    // Nếu tháng nhập vào nhỏ hơn tháng hiện tại, chuyển sang năm sau
                                                    if ($month < $current_month || ($month == $current_month && $day < date('j'))) {
                                                        $expired_year = $current_year + 1;
                                                    } else {
                                                        $expired_year = $current_year;
                                                    }

                                                    // Tạo JSON cho cột
                                                    $detail = json_encode([["id" => intval($items), "quantity" => intval($quantity)]]);
                                                    $expired_date = sprintf("%d-%02d-%02d 23:59:00", $expired_year, $month, $day);
                                                    $item_option = json_encode([["id" => $id_option, "param" => $id_param]]);
                                                    $item_option_json = json_encode($item_option_data);

                                                    // Kiểm tra xem mã code đã tồn tại trong cơ sở dữ liệu hay chưa
                                                    $sql_check = "SELECT COUNT(*) FROM giftcode WHERE code = :code";
                                                    $statement_check = $conn->prepare($sql_check);
                                                    $statement_check->bindParam(':code', $code, PDO::PARAM_STR);
                                                    $statement_check->execute();
                                                    $code_exists = $statement_check->fetchColumn();


                                                    if ($code_exists) {
                                                        $_alert = '<div class="alert alert-danger">Mã code đã tồn tại!</div>';
                                                    } else {
                                                        // Sử dụng placeholders trong câu lệnh SQL
                                                        $sql_insert = "INSERT INTO giftcode (code, count_left, detail, expired, itemoption)
                                                            VALUES (:code, :count_left, :detail, :expired, :item_option)";
                                                        $statement_insert = $conn->prepare($sql_insert);

                                                        // Ràng buộc các biến với placeholders
                                                        $statement_insert->bindParam(':code', $code, PDO::PARAM_STR);
                                                        $statement_insert->bindParam(':count_left', $count_left, PDO::PARAM_INT);
                                                        $statement_insert->bindParam(':detail', $detail, PDO::PARAM_STR);
                                                        $statement_insert->bindParam(':expired', $expired_date, PDO::PARAM_STR);
                                                        $statement_insert->bindParam(':item_option', $item_option_json, PDO::PARAM_STR);

                                                        if ($statement_insert->execute()) {
                                                            $_alert = '<div class="alert alert-success">Thêm Gift Code thành công!</div>';
                                                        } else {
                                                            $_alert = '<div class="alert alert-warning">Lỗi: Kết nối đến máy chủ</div>';
                                                        }
                                                    }
                                                }


                                                // Đóng kết nối
                                                $conn = null;
                                                ?>
                                                <!-- Hiển thị biến $_alert -->
                                                <div id="alertContainer">
                                                    <?php echo $_alert; ?>
                                                </div>
                                                <form method="POST">
                                                    <div class="mb-3">
                                                        <label>Nhập Code Mới:</label>
                                                        <input type="code" class="form-control" name="code" id="code"
                                                            placeholder="Nhập Code" required autocomplete="code">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Số Lượng Code:</label>
                                                        <input type="count_left" class="form-control" name="count_left" id="count_left"
                                                            placeholder="Nhập số lượng" required autocomplete="count_left">
                                                        <div id="quantity-error-count-code" class="text-danger" style="display:none;margin-top: 5px;">Số lượng quá ít!</div>
                                                        <div id="quantity-numeric-error-count-code" class="text-danger" style="display:none;margin-top: 5px;">Vui lòng nhập các ký tự là số!</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>ID item:</label>
                                                        <input type="items" class="form-control" name="items" id="items"
                                                            placeholder="Nhập ID Item" required autocomplete="items">
                                                        <div id="quantity-error-id-item" class="text-danger" style="display:none;margin-top: 5px;">ID item không phù hợp!</div>    
                                                        <div id="quantity-numeric-error-id-item" class="text-danger" style="display:none;margin-top: 5px;">Vui lòng nhập các ký tự là số!</div>    
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Số Lượng:</label>
                                                        <input type="quantity" class="form-control" name="quantity" id="quantity"
                                                            placeholder="Nhập số lượng" required autocomplete="quantity">
                                                        <div id="quantity-error" class="text-danger" style="display:none;margin-top: 5px;">Số lượng quá ít!</div>
                                                        <div id="quantity-numeric-error" class="text-danger" style="display:none;margin-top: 5px;">Vui lòng nhập các ký tự là số!</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Ngày Hết Hạn:</label>
                                                        <input type="expired" class="form-control" name="expired" id="expired"
                                                            placeholder="Ví Dụ: 29/2" required autocomplete="expired">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>ID Option:</label>
                                                        <input type="id_option" class="form-control" name="id_option" id="id_option"
                                                            placeholder="Ví Dụ: 0-1" required autocomplete="id_option">
                                                        <div id="numeric-error-id-option" class="text-danger" style="display:none;margin-top: 5px;">Sai định dạng nhập!</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>ID Param:</label>
                                                        <input type="id_param" class="form-control" name="id_param" id="id_param"
                                                            placeholder="Ví Dụ: 10-20" required autocomplete="id_param">
                                                    </div>
                                                     <div class="d-flex justify-content-between">
                                                        <button class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-49" type="submit">Thêm Code</button>
                                                        <button class="ant-btn ant-btn-default header-menu-item header-menu-item-active w-50" type="button" onclick="location.href='history_giftcode.php';">Lịch Sử Nhập</button>
                                                    </div>
                                                </form>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="paging" class="d-flex justify-content-end align-items-center flex-wrap"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>                            
</div>
<script>
    function validateQuantityInput(inputId, errorElementId, numericErrorElementId, type) {
        var quantity = document.getElementById(inputId).value;
        var errorElement = document.getElementById(errorElementId);
        var numericErrorElement = document.getElementById(numericErrorElementId);
        // Kiểm tra xem giá trị nhập vào có phải là số hay không
        if (isNaN(quantity)) {
            numericErrorElement.style.display = 'block';
            errorElement.style.display = 'none';
        } else {
            numericErrorElement.style.display = 'none';
            // Kiểm tra số lượng
            if (type === 1 && (quantity === "" || quantity > 0)) {
                errorElement.style.display = 'none';
            } else if(type === 2 && (quantity === "" || quantity >= 0)){
                errorElement.style.display = 'none';
            } else {
                errorElement.style.display = 'block';
            }
        }
    }
    document.getElementById('quantity').addEventListener('input', function() {
        validateQuantityInput('quantity', 'quantity-error', 'quantity-numeric-error', 1);
    });
    document.getElementById('count_left').addEventListener('input', function() {
        validateQuantityInput('count_left', 'quantity-error-count-code', 'quantity-numeric-error-count-code', 1);
    });
    document.getElementById('items').addEventListener('input', function() {
        validateQuantityInput('items', 'quantity-error-id-item', 'quantity-numeric-error-id-item', 2);
    });
    
</script>
<?php include_once '../core/footer.php'; ?>