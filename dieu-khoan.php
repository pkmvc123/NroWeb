<?php
require_once 'core/connect.php';
require_once 'core/set.php';
require_once 'core/cauhinh.php';
include_once 'core/gioi-thieu.php';
include_once 'core/head.php';
?>

<div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24">
    <div class="page-layout-body">
        <!-- load view -->
         <div class="row">
        <div class="col">
            <a href="./dang-ky.php" style="color: #e65039;display: inline;top: 5px;" class="ant-col ant-col-24 home_page_bodyTitleList__UdhN_">Quay lại trang đăng ký</a>
        </div>
    </div>
<div class="ant-col ant-col-24 home_page_bodyTitleList__UdhN_">Điều Khoản Sử Dụng</div>
<div class="ant-col ant-col-24">
    <div class="home_page_listItem__GD_iE" style="display:flex">
        1. Chấp Nhận Điều Khoản
        <br />
        - Bằng cách truy cập và sử dụng trò chơi của chúng tôi, bạn đồng ý tuân thủ các điều khoản và điều kiện sau đây.
        <br>
        - Nếu bạn không đồng ý với bất kỳ phần nào của các điều khoản này, vui lòng không truy cập hoặc sử dụng trò chơi.
        <br />
        2. Tài Khoản Người Dùng
        <br />
        * Đăng Ký: Người chơi phải đăng ký một tài khoản để truy cập và sử dụng các dịch vụ của chúng tôi.
        <br>
        - Bạn đồng ý cung cấp thông tin chính xác và cập nhật khi đăng ký.
        <br />
        * Bảo Mật: Bạn chịu trách nhiệm bảo mật tài khoản và mật khẩu của mình.
        <br>
        - Chúng tôi không chịu trách nhiệm cho bất kỳ tổn thất hoặc thiệt hại nào phát sinh từ việc bạn không bảo mật tài khoản của mình.
        <br />
        * Hủy Bỏ: Chúng tôi có quyền hủy bỏ hoặc ban tài khoản của bạn bất kỳ lúc nào nếu phát hiện vi phạm các điều khoản sử dụng này.
        <br>
        - Đặc Biệt: Admin không bao giờ hỏi mật khẩu của bạn!
        <br />
        3. Sử Dụng Dịch Vụ
        <br />
        * Hành Vi Cấm:
        <br>
        - Bạn đồng ý không sử dụng trò chơi cho bất kỳ mục đích nào vi phạm pháp luật, lừa đảo, hoặc xâm phạm quyền lợi của người khác.
        <br>
        - Các hành vi cấm sử dụng trong trò chơi:
        <br>&emsp;+ Sử dụng bot hoặc phần mềm bên thứ ba để tự động hóa trò chơi.
        <br>&emsp;+ Xâm nhập hoặc cố gắng xâm nhập vào hệ thống của chúng tôi.
        <br>&emsp;+ Phát tán thông tin sai lệch hoặc phần mềm độc hại.
        <br>&emsp;+ Lợi dụng bug thực hiện vào những hành vi xấu.
        <br>
        4. Trách Nhiệm và Bồi Thường
        <br>
        * Trách Nhiệm Hạn Chế: Chúng tôi không chịu trách nhiệm cho bất kỳ thiệt hại nào phát sinh từ việc sử dụng 
        hoặc không thể sử dụng<br>trò chơi, bao gồm nhưng không giới hạn ở mất dữ liệu, lợi nhuận, hoặc các thiệt hại khác.
        <br>
        * Bồi Thường: Bạn đồng ý bồi thường và giữ cho chúng tôi và các đối tác của chúng tôi không bị thiệt hại từ bất kỳ
        <br>khiếu nại, yêu cầu, hoặc thiệt hại nào phát sinh từ việc bạn vi phạm các điều khoản sử dụng này.
        <br>
        5. Thay Đổi Điều Khoản
        <br>
        * Chúng tôi có quyền thay đổi các điều khoản sử dụng này bất kỳ lúc nào. 
        <br>
        * Bất kỳ thay đổi nào sẽ có hiệu lực ngay khi được đăng tải trên trang web của chúng tôi. 
        <br>
        - Bạn nên thường xuyên kiểm tra điều khoản này để đảm bảo bạn nắm rõ các thay đổi.
        <br>
        6. Luật Áp Dụng
        <br>
        * Các điều khoản sử dụng này được điều chỉnh bởi luật pháp của nước sở tại. 
        <br>
        * Bất kỳ tranh chấp nào phát sinh từ hoặc liên quan đến các điều khoản này sẽ được giải quyết tại tòa án có thẩm quyền của nước sở tại.
    </div>
</div>
<?php echo gioiThieuGame(); ?>
</div>
    <!-- end load view -->
        </div>
            </div>                   
<?php include_once 'core/footer.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>
</body>
</html>