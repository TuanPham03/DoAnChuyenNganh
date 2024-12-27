<div class="container">
    <div class="row">
        <?php foreach ($kq as $booking) { ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100"
                onclick="window.location.href='index.php?act=viewBooking&id=<?php echo $booking['id']; ?>';"
                style="cursor: pointer;">
                <div class="card-body">
                    <h5 class="card-title">Mã đặt phòng: <?php echo $booking['seri_num']; ?></h5>
                    <p class="card-text">Giá: <?php echo $booking['amount']; ?> VNĐ</p>
                    <p class="card-text">
                        <?php 
                            if ($booking['status'] == 'pending') {
                                echo '<span class="badge bg-warning text-dark py-2">Chờ xác nhận</span>';
                            } 
                        ?>
                    </p>
                    <p class="card-text">Ngày đặt phòng: <?php echo $booking['booking_date']; ?></p>
                </div>
                <div class="card-footer text-end">
                    <a href="index.php?act=confirmBookingHome&id=<?php echo $booking['id']; ?>"
                        class="btn btn-success btn-sm">Xác nhận</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

</div>