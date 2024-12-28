<div class="modal fade text-start" id="updateGuestModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="index.php?act=updateGuest&id=<?php echo $id?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Cập nhật khách ở</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?php if (isset($guest)&& is_array($user) && count($user) > 0) { ?>
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var updateGuestModal = new bootstrap.Modal(document.getElementById(
                        'updateGuestModal'));
                    updateGuestModal.show();
                });
                </script>
                <?php } 
                    foreach($guest as $g){
                    ?>

                <div class="modal-body">
                    <input class="form-control" type="hidden" name="id_inp"
                        value="<?php echo $g['booking_rooms_id'];?>">
                    <div data-mdb-input-init class="form-outline">
                        <label class="form-label" for="fullnameguest_inp">Họ và tên</label>
                        <input class="form-control" type="text" name="fullnameguest_inp"
                            value="<?php echo $g['guest_name'];?>">
                    </div>
                    <div data-mdb-input-init class="form-outline">
                        <label class="form-label" for="phoneguest_inp">Số điện thoại</label>
                        <input class="form-control" type="text" name="phoneguest_inp"
                            value="<?php echo $g['guest_phone'];?>">
                    </div>
                    <div data-mdb-input-init class="form-outline">
                        <label class="form-label" for="emailguest_inp">Email</label>
                        <input class="form-control" type="text" name="emailguest_inp"
                            value="<?php echo $g['guest_email'];?>">
                    </div>
                    <div data-mdb-input-init class="form-outline">
                        <label class="form-label" for="idguest_inp">CCCD</label>
                        <input class="form-control" type="text" name="idguest_inp"
                            value="<?php echo $g['guest_id_number'];?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" name="btn_smt_updateGuest" class="btn btn-primary">Lưu</button>
                </div>
                <?php }?>
            </div>

        </form>
    </div>
</div>
<div class="container ">
    <?php foreach($user as $u) { ?>
    <div class="d-flex justify-content-center">
        <div class="card shadow-lg mb-4 border-primary" style="max-width: 400px;">
            <div class="card-body bg-light">
                <p class="card-text text-dark"><strong>Mã đơn:</strong> <?= $u['seri_num'] ?></p>
                <p class="card-text text-dark"><strong>Ngày đặt:</strong>
                    <?= (new DateTime($u['booking_date']))->format('d-m-Y H:i:s') ?></p>
                <p class="card-text text-dark"><strong>Người đặt:</strong> <?= $u['fullname'] ?></p>
                <p class="card-text text-dark"><strong>Số điện thoại:</strong> <?= $u['numphone'] ?></p>
            </div>
        </div>
    </div>
    <?php break; } ?>
    <?php if (!empty($data)) { ?>
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
        <?php foreach ($data as $row) { ?>
        <div class="col">
            <div class="card shadow-lg border-primary ">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Phòng <?= $row['room_number'] ?> - <?= $row['type_name'] ?></h5>
                </div>
                <?php if($row['rcid']!=null){
                    foreach ($room as $r){
                        if ($row['new_room_id']==$r['id']) {
                    ?>
                <div class="alert alert-danger mb-0" role="alert" style="text-align: center;">
                    Đã thay đổi thành: Phòng <?= $r['room_number'] ?> - <?= $r['type_name'] ?>
                    <p class="mb-0">Ngày đổi:
                        <?= (new DateTime($row['change_date']))->format('d-m-Y') ?></p>
                </div>
                <?php }}}?>
                <div class="card-body bg-light">
                    <p class="card-text text-dark"><strong>Ngày nhận phòng:</strong>
                        <?= (new DateTime($row['check_in_date']))->format('d-m-Y') ?></p>
                    <p class="card-text text-dark"><strong>Ngày trả phòng:</strong>
                        <?= (new DateTime($row['check_out_date']))->format('d-m-Y') ?></p>
                    <?php if($row['early_checkout']){?>
                    <p class="card-text text-dark"><strong>Ngày trả phòng sớm:</strong>
                        <?= (new DateTime($row['early_checkout']))->format('d-m-Y') ?></p>
                    <?php    
                    }?>

                    <p class="card-text text-dark"><strong>Khách Ở:</strong> <?= $row['guest_name'] ?></p>
                    <p class="card-text text-dark"><strong>SĐT Khách:</strong> <?= $row['guest_phone'] ?></p>
                    <p class="card-text text-dark"><strong>Email Khách:</strong> <?= $row['guest_email'] ?></p>
                    <p class="card-text text-dark"><strong>CMND/CCCD:</strong> <?= $row['guest_id_number'] ?></p>
                    <p class="card-text text-dark mb-1"><strong>Dịch vụ đã chọn:</strong></p>
                    <?php 
                        $res = getReservationById($row['id']);
                        if (!empty($res)) {
                            echo '<ul class="list-group list-group-flush">';
                            foreach ($res as $service) {
                                echo '<li class="list-group-item py-0 ">';
                                echo '<i class="bi bi-check-circle"></i> ' . $service['service_name']. '</li>';
                            }
                            echo '</ul>';
                        } else {
                            echo '<p class="text-muted fst-italic">Không có dịch vụ nào được chọn.</p>';
                        }
                    ?>
                    <p class="card-text text-dark mb-1 text-end"><strong>Tổng giá phòng:</strong>
                        <?php echo number_format($row['amount']); ?>
                    </p>
                    <div class="d-flex justify-content-between mt-3">
                        <?php 
                        $currentDate = date('Y-m-d');
                        foreach ($bookingid as $booking) {
                            if ($booking['status'] == 'pending' || $booking['status'] == 'cancelled') {
                                echo "<p class='bg-warning p-2 text-center rounded w-100'><strong>Trạng thái:</strong> Đang chờ xử lý / Đã hủy</p>";
                            } elseif ($booking['status'] == 'confirmed'||$booking['status'] == 'checkin'||$booking['status'] == 'checkout') {
                                if($row['early_checkout']===null){
                            if($currentDate<$row['check_out_date']){
                                    if ($booking['status'] == 'checkin'&&$row['status']=='available') { ?>
                        <a href="index.php?act=checkin&id=<?= $row['booking_id'] ?>&idroom=<?= $row['id_room'] ?>"
                            class="btn btn-success">Nhận
                            Phòng</a>
                        <a href="index.php?act=updateGuest&id=<?= $row['booking_id'] ?>&idbook=<?= $row['id'] ?>"
                            class="btn btn-warning">Cập Nhật Người
                            Ở</a>
                        <?php } elseif($booking['status'] == 'checkin'&&$row['status']=='booked') { ?>
                        <a href="index.php?act=checkout&id=<?= $row['booking_id'] ?>&idroom=<?= $row['id'] ?>"
                            class="btn btn-danger">Trả Phòng</a>
                        <a href="index.php?act=updateGuest&id=<?= $row['booking_id'] ?>&idbook=<?= $row['id'] ?>"
                            class="btn btn-warning">Cập Nhật Người
                            Ở</a>
                        <?php }else{echo "<p class='bg-warning p-2 text-center rounded w-100'><strong>Trạng thái:</strong> khách hàng chưa nhận phòng</p>";}
                        }else{
                        echo "<p class='bg-warning p-2 text-center rounded w-100'><strong>Trạng thái:</strong> đã quá hạn/đã trả phòng</p>";
                        }}elseif($currentDate<=$row['early_checkout']||$currentDate>=$row['early_checkout']){
                        echo "<p class='bg-warning p-2 text-center rounded w-100'><strong>Trạng thái:</strong> đã quá hạn/đã trả phòng</p>";
                        }
                    }} 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } else { ?>
    <p class="text-center text-danger fw-bold">Không có thông tin đặt phòng nào.</p>
    <?php } ?>
</div>