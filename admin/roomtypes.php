<div class="users-management">
    <div class="container-fluid px-0">
        <div class="table-wrapper">
            <div class="table-title pb-3">
                <div class="row">
                    <div class="col-lg-6 text-end">
                        <!-- Add room_types Modal -->
                        <div class="modal fade text-start" id="addRoomtypesModal" data-bs-backdrop="static"
                            tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="index.php?act=addRoomtypes" method="post" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Thêm loại phòng</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <?php
                                            if(isset($txt_err)){
                                                echo '<div class="alert alert-danger" role="alert">'.$txt_err.'</div>';?>
                                        <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var addRoomtypesModal = new bootstrap.Modal(document.getElementById(
                                                'addRoomtypesModal'));
                                            addRoomtypesModal.show();
                                        });
                                        </script>
                                        <?php 
                                        }
                                        ?>
                                        <div class="modal-body">
                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="nameroomtypes_inp">Tên loại
                                                    phòng</label>
                                                <input class="form-control" type="text" name="nameroomtypes_inp">
                                            </div>
                                            <div class="form-outline">
                                                <label class="form-label" for="adult_inp">Người lớn</label>
                                                <input class="form-control" min="1" type="number" name="adult_inp">
                                            </div>
                                            <div class="form-outline">
                                                <label class="form-label" for="chilt_inp">Trẻ em</label>
                                                <input class="form-control" min="0" type="number" name="child_inp">
                                            </div>
                                            <div class="mb-3form-outline">
                                                <label class="form-label" for="price_inp">Giá </label>
                                                <input class="form-control" min="1" type="number" name="price_inp">
                                            </div>
                                            <div class="mb-3 mt-3">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="description_roomtypes"
                                                        style="height: 100px"></textarea>
                                                    <label>Mô tả</label>
                                                </div>
                                            </div>
                                            <div class="form-outline mt-2">
                                                <label class="form-label" for="upload">Hình ảnh</label>
                                                <input type="file" name="upload" id="">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" name="btn_smt_addRoomtypes"
                                                class="btn btn-primary">Thêm</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Update -->

                        <div class="modal fade text-start" id="updateRoomtypesModal" data-bs-backdrop="static"
                            tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="index.php?act=updateRoomtypes" method="post"
                                    enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Cập nhật loại phòng</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <?php if (isset($typesroom)) { ?>
                                        <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var updateRoomtypesModal = new bootstrap.Modal(document
                                                .getElementById(
                                                    'updateRoomtypesModal'));
                                            updateRoomtypesModal.show();
                                        });
                                        </script>
                                        <?php } 
                                        foreach($typesroom as $typesroom){
                                        ?>
                                        <div class="modal-body">
                                            <input type="hidden" name="id_inp" id=""
                                                value="<?php echo $typesroom['id'];?>">
                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="nameroomtypes_inp">Tên loại
                                                    phòng</label>
                                                <input class="form-control" type="text" name="nameroomtypes_inp"
                                                    value="<?php echo $typesroom['type_name'];?>">
                                            </div>
                                            <div class="form-outline">
                                                <label class="form-label" for="adult_inp">Người lớn</label>
                                                <input class="form-control" min="1" type="number" name="adult_inp"
                                                    value="<?php echo $typesroom['adult'];?>">
                                            </div>
                                            <div class="form-outline">
                                                <label class="form-label" for="chilt_inp">Trẻ em</label>
                                                <input class="form-control" min="0" type="number" name="child_inp"
                                                    value="<?php echo $typesroom['child'];?>">
                                            </div>
                                            <div class="form-outline">

                                                <input class="form-control" min="0" type="hidden" name="quantity"
                                                    value="<?php echo $typesroom['quantity'];?>">
                                            </div>
                                            <div class="mb-3form-outline">
                                                <label class="form-label" for="price_inp">Giá</label>
                                                <input class="form-control" min="1" type="number" name="price_inp"
                                                    value="<?php echo $typesroom['price'];?>">
                                            </div>
                                            <div class=" mb-3 mt-3">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="description_roomtypes"
                                                        style="height: 100px"><?php echo $typesroom['description'];?></textarea>
                                                    <label>Mô tả</label>
                                                </div>
                                            </div>
                                            <div class="form-outline mt-2">
                                                <label class="form-label" for="upload">Hình ảnh</label>
                                                <input type="file" name="upload" id="upload">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" name="btn_smt_updateRoomtypes"
                                                class="btn btn-primary">lưu</button>
                                        </div>
                                        <?php }?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-lg-6">
                <form method="get" action="index.php">
                    <input type="hidden" name="act" value="roomtypes">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Tìm kiếm..."
                            value="<?php echo $_GET['search'] ?? ''; ?>">
                        <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>

                    <th>Hình ảnh</th>
                    <th>Tên loại phòng</th>
                    <th>Số người lớn</th>
                    <th>Số trẻ em</th>
                    <th>giá</th>
                    <th>Số lượng phòng</th>
                    <th>Số phòng còn trống</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php        
                    foreach($kq as $roomtypes){
                ?>
                <tr>
                    <td>
                        <?php
                            if ($err !="")
                            echo $err;
                            else
                            {
                        ?>
                        <img src=" ../images/<?php echo $roomtypes['image_url']?>" width="100px" height="80px"
                            alt=" ...">
                        <?php	
                            }
                        ?>
                    </td>
                    <td><?php echo $roomtypes['type_name']; ?></td>
                    <td><?php echo $roomtypes['adult']; ?></td>
                    <td><?php echo $roomtypes['child']; ?></td>
                    <td><?php echo number_format($roomtypes['price']); ?> VNĐ</td>
                    <td><?php echo $roomtypes['quantity']; ?></td>
                    <td><?php echo $roomtypes['available_quantity']; ?></td>
                    <td class="" style="max-width: 600px;"><?php echo $roomtypes['description']; ?></td>
                    <td><a href="index.php?act=updateRoomtypes&id=<?php echo $roomtypes['id'];?>"
                            class="btn btn-primary">Sửa</a>
                        <a href="#" onclick="confirmDeleteroomtype(<?php echo $roomtypes['id'];?>)"
                            class="btn btn-danger ">Xóa</a>
                    </td>
                </tr>
                <?php
                        }
                    ?>
            </tbody>
        </table>
        <div class="pagination">
            <ul class="pagination">
                <!-- Trang trước -->
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?act=roomtypes&page=<?php echo $page - 1; ?>">Trang
                        trước</a>
                </li>
                <?php endif; ?>

                <!-- Hiển thị các trang -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="index.php?act=roomtypes&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>

                <!-- Trang sau -->
                <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?act=roomtypes&page=<?php echo $page + 1; ?>">Trang
                        sau</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
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
                window.location.href = "index.php?act=roomtypes";
            }
        });
        </script>
        <?php }elseif(!empty($txt_error)){ ?>
        <script>
        Swal.fire({
            icon: "error",
            text: "<?php echo $txt_error; ?>",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?act=roomtypes";
            }
        });
        </script>
        <?php }?>
    </div>
</div>
</div>
<script>
function confirmDeleteroomtype(roomtypeId) {
    const encoded = btoa(roomtypeId);
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
            text: "Bạn chắc chắn muốn xóa loại phòng này!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Có",
            cancelButtonText: "Không",
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?act=delRoomtypes&id=" + encoded;
            }
        });
}
</script>