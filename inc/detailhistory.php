<div class="container ">
    <h2 class="text-center mb-2 text-primary">Chi Tiết Đơn Đặt Phòng</h2>
    <?php foreach($user as $u) { ?>
    <div class="d-flex justify-content-center">
        <div class="card shadow-lg mb-4 border-primary" style="max-width: 400px;">
            <div class="card-body bg-light">
                <p class="card-text text-dark"><strong>Mã đơn:</strong> <?= $u['seri_num'] ?></p>
                <p class="card-text text-dark"><strong>Ngày đặt:</strong>
                    <?= (new DateTime($u['booking_date']))->format('d-m-Y H:i:s') ?></p>
            </div>
        </div>
    </div>
    <?php break; } ?>
    <?php if (!empty($data)) { ?>
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
        <?php foreach ($data as $row) { ?>
        <div class="col ">
            <div class="card shadow-lg border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Phòng <?= $row['room_number'] ?> - <?= $row['type_name'] ?></h5>
                </div>
                <?php if($row['rcid']!=null){
                    foreach ($room as $r){
                        if ($row['new_room_id']==$r['id']) {
                    ?>
                <div class="alert alert-danger mb-0" role="alert" style="text-align: center;">
                    Đã thay đổi thành phòng <?= $r['room_number'] ?> - <?= $r['type_name'] ?>
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
                    <p class="card-text text-dark"><strong>Tổng giá phòng:</strong>
                        <?= number_format($row['amount']); ?>
                    </p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <?php } else { ?>
    <p class="text-center text-danger fw-bold">Không có thông tin đặt phòng nào.</p>
    <?php } ?>
</div>