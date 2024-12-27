<div class="rooms-management">
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title ">
                <div class="row">
                    <div class="col-lg-6 text-end">
                        <!-- Add room Modal -->
                        <div class="modal fade text-start" id="addRoomModal" data-bs-backdrop="static" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="index.php?act=addRoom" method="post" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Thêm phòng</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <?php
                                            if(isset($txt_err)){
                                                echo '<div class="alert alert-danger" role="alert">'.$txt_err.'</div>';?>
                                        <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var addRoomModal = new bootstrap.Modal(document.getElementById(
                                                'addRoomModal'));
                                            addRoomModal.show();
                                        });
                                        </script>
                                        <?php 
                                        }
                                        ?>
                                        <div class="modal-body">
                                            <div class="form-outline">
                                                <label class="form-label" for="number-room_inp">Số phòng</label>
                                                <input class="form-control" type="text" name="number-room_inp"
                                                    value="<?php echo isset($_POST['number-room_inp'])?$_POST['number-room_inp']: "";?>"
                                                    required>
                                            </div>

                                            <div class="form-outline">
                                                <label class="form-label" for="type_room">Loại phòng</label>
                                                <select name="type_room" class="form-select">
                                                    <option value="" selected disabled>Chọn loại phòng</option>
                                                    <?php
                                                        foreach($roomtype as $row){   
                                                            echo '<option value="'.$row['id'].'">'.$row['type_name'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-outline">
                                                <label class="form-label" for="status">Trạng thái</label>
                                                <select name="status" class="form-select">
                                                    <option value="available" selected>Đang có phòng</option>
                                                    <option value="booked">Đã đặt phòng</option>
                                                </select>
                                            </div>
                                            <div class=" mt-3 ">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="description_room"
                                                        style="height: 100px"></textarea>
                                                    <label>Mô tả</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" name="btn_smt_addRoom"
                                                class="btn btn-primary">Thêm</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- update -->
                        <div class="modal fade text-start" id="updateRoomModal" data-bs-backdrop="static" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="index.php?act=updateRoom" method="post" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Cập nhật phòng</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <?php if (isset($room)) { ?>
                                        <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var updateRoomModal = new bootstrap.Modal(document
                                                .getElementById(
                                                    'updateRoomModal'));
                                            updateRoomModal.show();
                                        });
                                        </script>
                                        <?php } 
                                            ?>
                                        <?php 
                                        foreach($room as $room){
                                        ?>
                                        <div class="modal-body">
                                            <input type="hidden" value="<?php echo $room['id']?>" name="id_inp">
                                            <div class="form-outline">
                                                <label class="form-label" for="number-room_inp">Số phòng</label>
                                                <input class="form-control" type="text" name="number-room_inp"
                                                    value="<?php echo $room['room_number']?>">
                                            </div>
                                            <div class="form-outline">
                                                <label class="form-label" for="type_room">Loại phòng</label>
                                                <select name="type_room" class="form-select">
                                                    <?php
                                                        foreach($roomtype as $row){   
                                                            if($room['room_type_id']==$row['id'])
                                                                echo '<option value="'.$row['id'].'" selected>'.$row['type_name'].'</option>';
                                                            else
                                                                echo '<option value="'.$row['id'].'">'.$row['type_name'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-outline">
                                                <label class="form-label" for="status">Trạng thái</label>
                                                <select name="status" class="form-select">
                                                    <?php 
                                                        if($room['status']=='available'){
                                                            echo '<option value="available" selected>Đang có phòng</option>';
                                                            echo '<option value="booked">Đã đặt phòng</option>';
                                                        }else{
                                                            echo '<option value="booked" selected>Đã đặt phòng</option>';
                                                            echo '<option value="available" >Đang có phòng</option>';
                                                        }
                                                    ?>

                                                </select>
                                            </div>

                                            <div class=" mt-3 ">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="description_room"
                                                        style="height: 100px"><?php echo $room['description']?></textarea>
                                                    <label>Mô tả</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" name="btn_smt_updateRoom"
                                                class="btn btn-primary">Lưu</button>
                                        </div>
                                        <?php } ?>
                                    </div>

                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <form method="get" action="index.php">
                <input type="hidden" name="act" value="room">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Tìm kiếm..."
                        value="<?php echo $_GET['search'] ?? ''; ?>">
                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                </div>
            </form>
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Số phòng</th>
                        <th>Kiểu phòng</th>
                        <th>Trạng thái</th>
                        <th>Mô tả</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <?php
                    foreach($kq as $rooms){
                        ?>
                <tr>
                    <td class="align-middle "><?php echo $rooms['room_number']; ?></td>
                    <td class="align-middle "><?php echo $rooms['type_name']; ?></td>
                    <td>
                        <?php
                    if($rooms['status']=="available"){
                        echo '<span class="badge bg-success py-2 ">Đang có phòng</span>';
                    } else
                    {
                        echo '<span class="badge bg-danger py-2 px-3">Đã đặt</span>';
                    }
                    ?>
                    </td>
                    <td class="align-middle "><?php echo $rooms['description']; ?></td>
                    <td class="align-middle "><a href="index.php?act=updateRoom&id=<?php echo $rooms['id'];?>"
                            class=" btn btn-primary">Sửa</a>
                        <a href="#" onclick="confirmDeleteroom(<?php echo $rooms['id']; ?>)"
                            class=" btn btn-danger">Xóa</a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </table>
            <div class="pagination">
                <ul class="pagination">
                    <!-- Trang trước -->
                    <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?act=room&page=<?php echo $page - 1; ?>">Trang
                            trước</a>
                    </li>
                    <?php endif; ?>

                    <!-- Hiển thị các trang -->
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?act=room&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>

                    <!-- Trang sau -->
                    <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?act=room&page=<?php echo $page + 1; ?>">Trang
                            sau</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div>
                <?php if (!empty($txt_success)){ ?>
                <script>
                Swal.fire({
                    icon: "success",
                    text: "<?php echo $txt_success; ?>",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "index.php?act=room";
                    }
                });
                </script>
                <?php }elseif(!empty($txt_errr)){ ?>
                <script>
                Swal.fire({
                    icon: "error",
                    text: "<?php echo $txt_errr; ?>",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "index.php?act=room";
                    }
                });
                </script>
                <?php }?>
            </div>
        </div>
    </div>

</div>
<script>
function confirmDeleteroom(roomId) {
    const encodedRoomId = btoa(roomId);
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success ms-3",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    });

    swalWithBootstrapButtons
        .fire({
            title: "Xóa",
            text: "Bạn chắc chắn muốn xóa phòng này!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Có",
            cancelButtonText: "Không",
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?act=delRoom&id=" + encodedRoomId;
            }
        });
}
</script>