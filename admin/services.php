<div class="users-management">
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title pb-4">
                <div class="row">
                    <div class="col-lg-6 text-end">
                        <!-- Add room_types Modal -->
                        <div class="modal fade text-start" id="addServicesModal" data-bs-backdrop="static" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="index.php?act=addServices" method="post">
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
                                            var addServicesModal = new bootstrap.Modal(document.getElementById(
                                                'addServicesModal'));
                                            addServicesModal.show();
                                        });
                                        </script>
                                        <?php 
                                        }
                                        ?>
                                        <div class="modal-body">
                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="nameroomtypes_inp1">Tên dịch vụ</label>
                                                <input class="form-control" type="text" name="nameservices_inp">
                                            </div>
                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="nameroomtypes_inp1">Giá</label>
                                                <input class="form-control" type="text" name="servicesprice_inp">
                                            </div>
                                            <div class="mb-3 mt-3">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="description_services"
                                                        style="height: 100px"></textarea>
                                                    <label>Mô tả</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" name="btn_smt_addServices"
                                                class="btn btn-primary">Thêm</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Update -->

                        <div class="modal fade text-start" id="updateServicesModal" data-bs-backdrop="static"
                            tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="index.php?act=updateServices" method="post">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Cạp nhật loại phòng</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <?php if (isset($Services)) { ?>
                                        <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var updateServicesModal = new bootstrap.Modal(document
                                                .getElementById(
                                                    'updateServicesModal'));
                                            updateServicesModal.show();
                                        });
                                        </script>
                                        <?php } 
                                        foreach($Services as $Services){
                                        ?>
                                        <div class="modal-body">
                                            <input type="hidden" name="id_inp" value="<?php echo $Services['id']; ?>">
                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="nameroomtypes_inp1">Tên dịch vụ</label>
                                                <input class="form-control" type="text" name="nameservices_inp"
                                                    value="<?php echo $Services['service_name']; ?>">
                                            </div>
                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="nameroomtypes_inp1">Giá</label>
                                                <input class="form-control" type="text" name="servicesprice_inp"
                                                    value="<?php echo $Services['price']; ?>">
                                            </div>
                                            <div class="mb-3 mt-3">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="description_services"
                                                        style="height: 100px"><?php echo $Services['description']; ?></textarea>
                                                    <label>Mô tả</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" name="btn_smt_updateServices"
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
        <form method="get" action="index.php">
            <input type="hidden" name="act" value="services">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm..."
                    value="<?php echo $_GET['search'] ?? ''; ?>">
                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên dịch vụ</th>
                    <th>Giá</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (!empty($kq)) {
                        foreach ($kq as $services) {
                            ?>
                <tr>
                    <td><?php echo $services['service_name']; ?></td>
                    <td><?php echo number_format($services['price']); ?> VNĐ</td>
                    <td><?php echo $services['description']; ?></td>
                    <td><a href="index.php?act=updateServices&id=<?php echo $services['id'];?>"
                            class="btn btn-primary">Sửa</a>
                        <a href="#" onclick="confirmDeleteservice(<?php echo $services['id'];?>)"
                            class="btn btn-danger ">Xóa</a>
                    </td>
                </tr>
                <?php
                    }}else {
                        echo '<tr><td colspan="4" class="text-center text-danger">Không tìm thấy kết quả nào</td></tr>';
                    }
                ?>
            </tbody>
        </table>
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
                window.location.href = "index.php?act=services";
            }
        });
        </script>
        <?php } ?>
    </div>
</div>
</div>
<script>
function confirmDeleteservice(serviceId) {
    const encoded = btoa(serviceId);
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
                window.location.href = "index.php?act=delServices&id=" + encoded;
            }
        });
}
</script>