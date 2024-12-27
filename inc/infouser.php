<div class="container mt-5">
    <div class="outer-box">
        <h2 class="text-center mb-4">Đổi Thông Tin Tài Khoản</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-content">
                    <?php foreach($user as $u) {?>
                    <form id="#" method="POST">
                        <input type="hidden" name="id_inp" id="" value="<?php echo $u['id'];?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên:</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="<?php echo $u['fullname'];?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="<?php echo $u['email'];?>">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại:</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo $u['numphone'];?>"
                                class="form-control">
                        </div>

                        <div class="password-box">
                            <div class="mb-3">
                                <label for="old-password" class="form-label">Mật khẩu cũ:</label>
                                <input type="password" id="old-password" name="old-password" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="new-password" class="form-label">Mật khẩu mới:</label>
                                <input type="password" id="new-password" name="new-password" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="confirm-password" class="form-label">Nhập lại mật khẩu mới:</label>
                                <input type="password" id="confirm-password" name="confirm-password"
                                    class="form-control">
                            </div>
                        </div>

                        <button type="submit" name="save" class="btn btn-primary w-100">Lưu thay đổi</button>
                        <?php }?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>