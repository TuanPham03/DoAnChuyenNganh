<div class="container mt-5" style="width: 50%; background-color: #EAEBEC;">
    <h2>Kiểm tra thông tin Đặt Phòng</h2>

    <?php 

    if (!empty($Data)) { ?>
    <div class="row">
        <?php foreach ($Data as $index => $data) { 
            $days = calculateDay($data['checkin'], $data['checkout']);
            $service_price = [];
            $total_room_price = ($data['roomprice'] * $days);

            if (!empty($data['services'])) {
                foreach ($data['services'] as $serviceId) {
                    $service = getServicesbyId($serviceId);
                    foreach ($service as $service) {
                        $service_price[] = $service['price'] ?? 0;
                        $total_room_price += $service['price'];
                    }
                }
            }
            $Data[$index]['total_room_price'] = $total_room_price;

            $total_price += $total_room_price;
        ?>

        <div class="col-12 mb-3">
            <div class="room-info border border-2">
                <div class="mb-4">
                    <h5>Thông tin phòng <?php echo $index + 1; ?></h5>
                </div>

                <div class="room-details">
                    <div class="left border-end border-3">
                        <p><strong>Loại phòng:</strong> <?php echo $data['type_room']; ?></p>
                        <p><strong>Số phòng:</strong> <?php echo $data['room']; ?></p>
                        <p><strong>Họ và tên:</strong> <?php echo $data['fullname']; ?></p>
                        <p><strong>Email:</strong> <?php echo $data['email']; ?></p>
                        <p><strong>Số điện thoại:</strong> <?php echo $data['numphone']; ?></p>
                    </div>
                    <div class="detai-txt-check">
                        <p><strong>Ngày nhận phòng:</strong> <?php echo $data['checkin']; ?></p>
                        <p><strong>Ngày trả phòng:</strong> <?php echo $data['checkout']; ?></p>
                        <p><strong>Số ngày ở:</strong> <?php echo $days; ?></p>
                        <?php if (!empty($data['services'])) { ?>
                        <p class="service-title mb-1">Dịch vụ đã chọn:</p>
                        <ul>
                            <?php foreach ($data['services'] as $serviceId) { 
                                $service = getServicesbyId($serviceId);
                                foreach ($service as $service) {
                            ?>
                            <li>- <?php echo $service['service_name']; ?></li>
                            <?php }} ?>
                        </ul>
                        <?php } else { ?>
                        <p>Không có dịch vụ nào được chọn.</p>
                        <?php } ?>
                    </div>
                </div>
                <hr>
                <div class="total-price text-end">
                    <h5>Tổng tiền phòng: <?php echo number_format($total_room_price); ?> VND</h5>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <div class="text-end mt-1 txt-total-price-detail">
        <h4><strong>Tổng tiền tất cả các phòng: <?php echo number_format($total_price); ?> VND</strong></h4>
    </div>

    <?php } else { ?>
    <p class="text-danger">Không có thông tin đặt phòng nào được gửi.</p>
    <?php } ?>

    <!-- Thêm nút quay lại -->
    <div class="text-center mt-5">
        <form action="index.php?act=detailbooking" method="post">
            <input type="hidden" name="total_amount" value="<?php echo $total_price; ?>">
            <button type="submit" class="btn btn-primary">Xác nhận đặt phòng</button>
        </form>
    </div>

</div>