<?php
    require_once("header.php");
?>

    <table cellpadding="10" cellspacing="10" border="0" style="border-collapse: collapse; margin: auto">
        <tr class="header">
            <td>Image</td>
            <td>Name</td>
            <td>Price</td>
            <td>Description</td>
            <td>Action</td>
        </tr>
    </table>


    <!-- Delete Confirm Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <?php
        if (isset($_SESSION['user'])) {
            $name = $_SESSION['name'];
            ?>
                <div class="modal-header">
                    <hp class="modal-title">Đặt hàng</hp>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc rằng muốn xóa <strong></strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id = "delete-product" class="btn btn-danger">Xóa</button>
                </div>
                <?php
        }
        else {
            ?>
                <div class="modal-header">
                    <hp class="modal-title">Bạn cần phải đăng nhập để đặt hàng</hp>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
    <?php
        }
    ?>

            </div>

        </div>
    </div>

    <script src="databasehandle.js"></script>
    <link href="style.css" rel="stylesheet">
</body>
</html>