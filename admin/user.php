<div class="users-management">
    <div class="container">

        <div class="table-wrapper">
            <div class="table-title pb-4">
                <div class="row">
                    <div class="col-lg-6 text-end">

                        <!-- Update -->

                        <div class="modal fade text-start" id="updateUserModal" data-bs-backdrop="static" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="index.php?act=updateUser" method="post">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Cập nhật người dùng</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <?php if (isset($user)) { ?>
                                        <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var updateUserModal = new bootstrap.Modal(document.getElementById(
                                                'updateUserModal'));
                                            updateUserModal.show();
                                        });
                                        </script>
                                        <?php } 
                                        foreach($user as $u){
                                        ?>

                                        <div class="modal-body">
                                            <input class="form-control" type="hidden" name="id_inp"
                                                value="<?php echo $u['id'];?>">
                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="fullname_inp">Họ và tên</label>
                                                <input class="form-control" type="text" name="fullname_inp"
                                                    value="<?php echo $u['fullname'];?>" readonly>
                                            </div>
                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="username_inp">Tên đăng
                                                    nhập</label>
                                                <input required type="text" id="username_inp" class="form-control"
                                                    name="username_inp" value="<?php echo $u['username'];?>" readonly>

                                            </div>
                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="email_inp">Địa chỉ
                                                    Email</label>
                                                <input required type="email" id="email_inp" class="form-control"
                                                    name="email_inp" value="<?php echo $u['email'];?>" readonly />

                                            </div>
                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="phone_inp">Số điện thoại</label>
                                                <input required type="text" id="phone_inp" class="form-control"
                                                    name="phone_inp" value="<?php echo $u['numphone'];?>" readonly />
                                            </div>
                                            <div data-mdb-input-init class="form-outline">

                                                <input required type="hidden" id="pw_inp" class="form-control"
                                                    name="pw_inp" value="<?php echo $u['password'];?>" readonly />
                                            </div>
                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="role_select">Vai trò</label>
                                                <select required id="role_select" class="form-select"
                                                    name="role_select">
                                                    <?php
                                                        if($u['role']=='admin'){?>
                                                    <option value="admin" selected>Quản trị viên</option>
                                                    <option value="customer">Người dùng</option>
                                                    <?php }else{ ?>
                                                    <option value="customer" selected>Người dùng</option>
                                                    <option value="admin">Quản trị viên</option>
                                                    <?php } ?>


                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" name="btn_smt_updateUser"
                                                class="btn btn-primary">Lưu</button>
                                        </div>
                                        <?php }?>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <form method="get" action="index.php">
                    <input type="hidden" name="act" value="user">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Tìm kiếm..."
                            value="<?php echo $_GET['search'] ?? ''; ?>">
                        <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                    </div>
                </form>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Họ và tên</th>
                        <th>Tên đăng nhập</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kq)){ ?>
                    <tr>
                        <td colspan="6" class="text-center text-danger">Không tìm thấy kết quả nào.</td>
                    </tr>
                    <?php }else{ 
                        foreach($kq as $user){
                            ?>
                    <tr>
                        <td><?php echo $user['fullname']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['numphone']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td><a href="index.php?act=updateUser&id=<?php echo $user['id'];?>"
                                class="btn btn-primary">Sửa</a>
                            <a href="#" class="btn btn-danger "
                                onclick="confirmDelete(<?php echo $user['id']; ?>)">Xóa</a>
                        </td>
                    </tr>
                    <?php
                        }if (empty($kq)){ ?>
                    <tr>
                        <td colspan="6" class="text-center text-danger">Không tìm thấy kết quả nào.</td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <div class="pagination">
                <ul class="pagination">
                    <!-- Trang trước -->
                    <?php
                    if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?act=user&page=<?php echo $page - 1; ?>">Trang
                            trước</a>
                    </li>
                    <?php endif; ?>

                    <!-- Hiển thị các trang -->
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?act=user&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>

                    <!-- Trang sau -->
                    <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?act=user&page=<?php echo $page + 1; ?>">Trang
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
                        window.location.href = "index.php?act=user";
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
                        window.location.href = "index.php?act=user";
                    }
                });
                </script>
                <?php }?>
            </div>

        </div>
    </div>
</div>
<script>
function confirmDelete(userId) {
    const encodedUserId = btoa(userId);
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
            text: "Bạn chắc chắn muốn xóa người dùng này?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Có",
            cancelButtonText: "Không",
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?act=delUser&id=" + encodedUserId;
            }
        });
}
</script>