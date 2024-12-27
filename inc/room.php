<?php 
    $checkin = $_SESSION['checkin'] ?? '';
    $checkout = $_SESSION['checkout'] ?? '';
    $adults = $_SESSION['adults'] ?? '';
    $children = $_SESSION['children'] ?? '';
    
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedRoomId'])) {
    $selectedRoomId = intval($_POST['selectedRoomId']);
    $roomQuantity = intval($_POST['roomQuantity'] ?? 1);
    

    $roomData = array_filter($kq1, fn($room) => $room['id'] === $selectedRoomId);
    $roomData = reset($roomData);
    if($_POST['roomQuantity']==0){
        echo "<script>const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                background: '#FF3131',
                                color: 'white',
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                                })

                            Toast.fire({
                            icon: 'error',
                            title: 'Vui lòng chọn số lượng!'})</script>";
    }
    if ($roomData) {
        $availableQuantity = $roomData['available_quantity'];
        $selectedCount = array_count_values($_SESSION['selectedRooms'] ?? [])[$selectedRoomId] ?? 0;

        if ($selectedCount + $roomQuantity > $availableQuantity) {
            echo "<script>const Toast = Swal.mixin({
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
                                })

                            Toast.fire({
                            icon: 'error',
                            title: 'Không đủ phòng trống để đặt số lượng yêu cầu, vui lòng chọn lại!'})</script>";
        } else {
            for ($i = 0; $i < $roomQuantity; $i++) {
                $_SESSION['selectedRooms'][] = $selectedRoomId;
            }
        }
    }
}
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['roomTypeId'])) {
            $roomTypeId = $_POST['roomTypeId'];
            if (isset($_POST['decreaseRoom'])) {
                $key = array_search($roomTypeId, $_SESSION['selectedRooms']);
                if ($key !== false) {
                    unset($_SESSION['selectedRooms'][$key]);
                    $_SESSION['selectedRooms'] = array_values($_SESSION['selectedRooms']);
                }
            }
        }
    }
    $selectedRooms = $_SESSION['selectedRooms'] ?? [];
    $errors = checkRoomAvailability($checkin,$checkout,$selectedRooms);

?>

<script></script>

<body>
    <div class="booking-container">
        <div class="booking-form border border-2 mt-4">
            <h3 class="text-center mb-4">Tìm kiếm phòng </h3>
            <form action="index.php?act=room" method="post">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="checkin" class="form-label">Check-in</label>
                        <input type="date" name="checkin" class="form-control" min="<?php echo date('Y-m-d'); ?>"
                            id="checkin" placeholder="dd-mm-yyyy"
                            value="<?php if($checkin==''){echo date('Y-m-d');}else{echo $checkin;} ?>" required
                            oninvalid="this.setCustomValidity('Vui lòng chọn ngày nhận phòng.')"
                            oninput="this.setCustomValidity('')">
                    </div>
                    <div class="col-md-3">
                        <label for="checkout" class="form-label">Check-out</label>
                        <input type="date" name="checkout" class="form-control" id="checkout" placeholder="dd-mm-yyyy"
                            value="<?php echo $checkout; ?>" required
                            oninvalid="this.setCustomValidity('Vui lòng chọn ngày trả phòng.')"
                            oninput="this.setCustomValidity('')" min="<?php echo date('Y-m-d');?>">
                    </div>
                    <div class="col-md-2">
                        <label for="adults" class="form-label">Người lớn</label>
                        <select class="form-select" id="adults" name="adults">
                            <?php for ($i = 1; $i <= 10; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php echo ($adults == $i) ? 'selected' : ''; ?>>
                                <?php echo $i; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="children" class="form-label">Trẻ em</label>
                        <select class="form-select" id="children" name="children">
                            <?php for ($i = 0; $i <= 10; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php echo ($children == $i) ? 'selected' : ''; ?>>
                                <?php echo $i; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" name="search" class="btn btn-primary w-100">Tìm phòng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row ">

            <!-- Danh sách chỗ nghỉ -->
            <div class=" col">
                <?php 
                    if(isset($kq1)&& is_array($kq1)){
                    foreach($kq1 as $roomtypes){
                    ?>
                <div class="col-md-6 mb-4" style="width:100%;">
                    <div class="hotel-card p-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <img src="./images/<?php echo $roomtypes['image_url'] ?>" class="card-img-top" alt="">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h3 class="card-title" style="color: blue;">
                                        <?php echo $roomtypes['type_name'] ?>
                                    </h3>
                                    <p class="adult-child"><?php echo $roomtypes['adult'] ?> người
                                        lớn, <?php echo $roomtypes['child'] ?> trẻ em</p>
                                    <p class="price"> <?php echo number_format($roomtypes['price']); ?> VNĐ/đêm </p>
                                    <p><small><?php echo $roomtypes['description'] ?></small></p>
                                    <div class="d-block" style="float: right;">
                                        <div class="features" style="<?php if ($roomtypes['quantity'] == 0) {
                                            echo 'color:red;';
                                        } else {
                                            echo 'color:green;';
                                        } ?>">
                                            <?php 
                                                if ($roomtypes['available_quantity'] == 0) {
                                                    echo 'Hết phòng';
                                                } else {
                                                    echo 'Còn ' . $roomtypes['available_quantity'] . ' phòng';
                                                }
                                            ?>
                                        </div>

                                        <form action="index.php?act=room" method="post">
                                            <input type="hidden" name="selectedRoomId"
                                                value="<?php echo $roomtypes['id']; ?>">
                                            <div class="d-flex align-items-center mb-2">
                                                <label for="quantity_<?php echo $roomtypes['id']; ?>" class="me-2">Chọn
                                                    số
                                                    lượng:</label>
                                                <input type="number" id="quantity_<?php echo $roomtypes['id']; ?>"
                                                    name="roomQuantity" min="0"
                                                    max="<?php echo $roomtypes['available_quantity']; ?>" value="0"
                                                    class="form-control" style="width: 50px;">
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <?php 
                                                if ($roomtypes['available_quantity'] == 0) {
                                                    echo '<button type="submit" class="btn btn-primary" disabled>Chọn phòng </button>';
                                                } else {
                                                    echo '<button type="submit" class="btn btn-primary">Chọn phòng </button>';
                                                }
                                            ?>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }}else{?>
                <div class="alert alert-danger" role="alert" style="text-align: center;">
                    Vui lòng nhập phần tìm kiếm để tìm phòng theo quí khách mong muốn!
                </div>
                <?php 
                }?>

            </div>
            <div class="frame col-md-2">
                <div class="selected-rooms">
                    <h4>Loại phòng đã chọn:</h4>
                    <?php if (!empty($_SESSION['selectedRooms'])) { ?>
                    <?php 
                        $roomCounts = array_count_values($_SESSION['selectedRooms']); 
                    ?>
                    <div class="room-list">
                        <?php foreach ($roomCounts as $roomTypeId => $count) { 
                            $roomTypebyid = getRoomtypesbyId($roomTypeId);
                            foreach ($roomTypebyid as $roomType) {
                        ?>
                        <div
                            class="room-item d-flex align-items-center justify-content-between mb-2 border border-2 p-2 rounded-4">
                            <span>
                                <h5><?php echo $roomType['type_name']; ?></h5>
                                <strong>Số lượng: x<?php echo $count; ?></strong>
                            </span>
                            <form method="POST" style="margin: 0;">
                                <input type="hidden" name="roomTypeId" value="<?php echo $roomTypeId; ?>">
                                <button type="submit" name="decreaseRoom" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </div>
                        <?php }} ?>
                        <form action="" method="POST">
                            <button type="submit" name="bookRoom" class="btn btn-primary float-end">Đặt phòng</button>
                        </form>
                    </div>
                    <?php } else { ?>
                    <p>Chưa có phòng nào được chọn.</p>
                    <?php }                   
                    ?>
                </div>
            </div>
        </div>
    </div>