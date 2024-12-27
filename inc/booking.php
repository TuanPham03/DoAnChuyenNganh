<?php 
    $checkin = $_SESSION['checkin'] ?? '';
    $checkout = $_SESSION['checkout'] ?? '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $_SESSION['checkin'] = $_POST['checkin'] ?? '';
        $_SESSION['checkout'] = $_POST['checkout'] ?? '';
        $_SESSION['fullname'] = $_POST['fullname'] ?? '';
        $_SESSION['email'] = $_POST['email'] ?? '';
        $_SESSION['numphone'] = $_POST['numphone'] ?? '';
        $_SESSION['services'] = $_POST['services'] ?? []; 
    }
    $formData = $_SESSION['formData'] ?? [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST'&&isset($_POST['booking'])) {
        foreach ($_POST['checkin'] as $index => $checkinDate) {
            $roomId = $selected[$index]['room_id'] ?? '';
            $checkoutDate = $_POST['checkout'][$index] ?? '';
            if (!isRoomAvailable($roomId, $checkinDate, $checkoutDate)) {
                $errorsroom[] = "Phòng {$selected[$index]['room_number']} đã được đặt trong khoảng từ $checkinDate đến $checkoutDate.";
            }
            else{
                $formData[$index] = [
                'room_id'=>$roomId,
                'type_room'=>$selected[$index]['type_name']??'',
                'room'=>$selected[$index]['room_number']??'',
                'checkin' => $checkinDate,
                'checkout' => $checkoutDate,
                'fullname' => $_POST['fullname'][$index] ?? '',
                'email' => $_POST['email'][$index] ?? '',
                'numphone' => $_POST['numphone'][$index] ?? '',
                'services' => $_POST['services'][$index] ?? [],
                'roomprice' => $selected[$index]['price'] ?? ''
                ];
            }
        }
        if (!empty($errorsroom)) {
        $errorMessages = implode("<br>", $errorsroom); 
        echo "<script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                background: '#FF3131',
                color: 'white',
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: 'error',
                title: '{$errorMessages}'
            });
        </script>";
        }else{
            $_SESSION['formData']=$formData;
        if(isset($_SESSION['fullname'])&&($_SESSION['fullname']!="")){
            unset($_SESSION['fullname']);}
        if(isset($_SESSION['email'])&&($_SESSION['email']!="")){
            unset($_SESSION['email']);}
        if(isset($_SESSION['numphone'])&&($_SESSION['numphone']!="")){
            unset($_SESSION['numphone']);}
        if(isset($_SESSION['services'])&&($_SESSION['services']!="")){
            unset($_SESSION['services']);}
        header("location: index.php?act=detailbooking");
        }
        
    }
    
    $_SESSION['formData']=$formData;
?>
<div class="container mt-5 d-flex justify-content-center">
    <div class="row w-100" style="max-width: 1000px;">
        <div class="col-12">
            <h5 class="mb-4 text-center">Nhập thông tin chi tiết của bạn</h5>
            <form action="#" method="POST">
                <?php
                foreach ($selected as $index => $room) {
                    $roomid=$room['room_id']??'';
                    $roomType = $room['type_name'] ?? 'Không xác định';
                    $roomName = $room['room_number'] ?? 'Không có tên phòng';
                    $roomPrice = $room['price'] ?? 0;
                ?>
                <div class="border border-2 rounded-3 mb-2">
                    <div class="p-3 border-end border-1">
                        <div>
                            <p class="card-title" style="color: blue;">Loại phòng: <?php echo $roomType; ?></p>
                            <p class="card-title">Tên phòng: <?php echo $roomName; ?></p>
                        </div>
                        <hr>
                        <div class="d-flex">
                            <!-- Phần bên trái: thông tin input -->
                            <div class="flex-fill pe-3 border-end border-2">
                                <div class="d-flex gap-3">
                                    <div class="flex-fill">
                                        <div class="mb-3">
                                            <label for="checkin_<?php echo $index?>" class="form-label">Ngày nhận phòng
                                                <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="checkin_<?php echo $index?>"
                                                name="checkin[]"
                                                value="<?php echo $_SESSION['checkin1'] ?? date('Y-m-d'); ?>"
                                                min="<?php echo date('Y-m-d'); ?>" required
                                                oninvalid="this.setCustomValidity('Vui lòng chọn ngày nhận phòng.')"
                                                oninput="this.setCustomValidity('')">
                                        </div>
                                    </div>
                                    <div class="flex-fill">
                                        <div class="mb-3">
                                            <label for="checkout_<?php echo $index?>" class="form-label">Ngày trả
                                                phòng</label>
                                            <input type="date" class="form-control" id="checkout_<?php echo $index?>"
                                                name="checkout[]" value="<?php echo $_SESSION['checkout1'] ?? ''; ?>"
                                                required
                                                oninvalid="this.setCustomValidity('Vui lòng chọn ngày trả phòng.')"
                                                oninput="this.setCustomValidity('')">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-3">
                                    <div class="flex-fill">
                                        <div class="mb-3">
                                            <label for="fullname_<?php echo $index?>" class="form-label">Họ và tên <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="fullname_<?php echo $index?>"
                                                name="fullname[]"
                                                value="<?php echo $_SESSION['fullname'][$index] ?? ''; ?>"
                                                placeholder="ví dụ: Nguyễn Văn A" required
                                                oninvalid="this.setCustomValidity('Vui lòng nhập họ và tên.')"
                                                oninput="this.setCustomValidity('')">
                                        </div>
                                    </div>
                                    <div class="flex-fill">
                                        <div class="mb-3">
                                            <label for="email_<?php echo $index?>" class="form-label">Địa chỉ
                                                email</label>
                                            <input type="email" class="form-control" id="email_<?php echo $index?>"
                                                name="email[]" value="<?php echo $_SESSION['email'][$index] ?? ''; ?>"
                                                placeholder="Email xác nhận đặt phòng" required
                                                oninvalid="this.setCustomValidity('Vui lòng nhập email.')"
                                                oninput="this.setCustomValidity('')">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="numphone_<?php echo $index?>" class="form-label">Số điện thoại</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="numphone[]"
                                            id="numphone_<?php echo $index?>"
                                            value="<?php echo $_SESSION['numphone'][$index] ?? ''; ?>"
                                            placeholder="Số điện thoại" required
                                            oninvalid="this.setCustomValidity('Vui lòng nhập số điện thoại.')"
                                            oninput="this.setCustomValidity('')">
                                    </div>
                                </div>
                            </div>

                            <!-- Phần bên phải: chọn dịch vụ -->
                            <div class="flex-shrink-0 ps-3">
                                <h5>Chọn dịch vụ</h5>
                                <?php
                                    foreach ($services as $service) {
                                        $checked = isset($_SESSION['services'][$index]) && in_array($service['id'], $_SESSION['services'][$index]) ? 'checked' : '';
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        id="service_<?php echo $service['id']; ?>_<?php echo $index; ?>"
                                        name="services[<?php echo $index; ?>][]" value="<?php echo $service['id']; ?>"
                                        <?php echo $checked; ?>>
                                    <label class="form-check-label"
                                        for="service_<?php echo $service['id']; ?>_<?php echo $index; ?>">
                                        <?php echo $service['service_name']; ?>
                                        (<?php echo number_format($service['price'], 0, ',', '.'); ?> VND/người/ngày)
                                    </label>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-12 text-end">
                    <button type="submit" name="booking" class="btn btn-primary">Đặt phòng</button>
                </div>
            </form>
        </div>
    </div>
</div>