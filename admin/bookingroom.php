<div class="modal fade text-start" id="changeRoomModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="index.php?act=changeRoom" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Thay đổi phòng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php foreach($bkroom as $br){?>
                <div class="modal-body">
                    <div data-mdb-input-init class="form-outline">
                        <input class="form-control" type="hidden" name="id_inp" value="<?php echo $br['id']; ?>">
                    </div>
                    <div data-mdb-input-init class="form-outline">
                        <input class="form-control" type="hidden" name="idroom_inp"
                            value="<?php echo $br['room_id']; ?>">
                    </div>
                    <div data-mdb-input-init class="form-outline">
                        <label class="form-label" for="oldroom_inp">Phòng cũ</label>
                        <input class="form-control" type="text" name="oldroom_inp"
                            value="<?php echo $br['room_number']; ?>" readonly>
                    </div>
                    <div class="form-outline">
                        <label class="form-label" for="newroom">Phòng mới</label>
                        <select name="newroom" class="form-select">
                            <option value="" selected>Chọn phòng mới</option>
                            <?php
                            $date=date('Y-m-d');
                            $room=getAllRoomNotBKR($date,$br['check_out_date']);
                                foreach($room as $row){   
                                    
                                    echo '<option value="'.$row['id'].'">'.$row['room_number'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div data-mdb-input-init class="form-outline">
                        <label class="form-label" for="checkin_inp">Ngày nhận phòng</label>
                        <input class="form-control" type="date" name="checkin_inp" value="<?= date('Y-m-d') ?>"
                            readonly>
                    </div>
                    <div data-mdb-input-init class="form-outline">
                        <label class="form-label" for="checkout_inp">Ngày trả phòng</label>
                        <input class="form-control" type="date" name="checkout_inp" readonly
                            value="<?= isset($br['check_out_date']) ? (new DateTime($br['check_out_date']))->format('Y-m-d') : ''; ?>">
                    </div>
                    <div class="mb-3 mt-3">
                        <div class="form-floating">
                            <textarea class="form-control" name="reason" style="height: 100px"></textarea>
                            <label>Lý do chuyển phòng</label>
                        </div>
                    </div>
                </div>
                <?php }?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" name="btn_smt_changeRoom" class="btn btn-primary">Lưu</button>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="container mt-4">
    <form method="post" action="index.php?act=bookingRooms">
        <div class="input-group">
            <input class="form-control mb-3" id="searchInput" type="text" name="inp_search"
                placeholder="Tìm kiếm phòng..." value="<?php echo $_POST['inp_search']??'';?>">
            <button type="submit" name="search" class="btn btn-primary mb-3">Tìm kiếm</button>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Số phòng</th>
                <th>Khách ở</th>
                <th>Số điện thoại</th>
                <th>CCCD</th>
                <th>Ngày nhận</th>
                <th>Ngày trả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($bkrooms) {
                    foreach ($bkrooms as $bkr) {
            ?>
            <tr>
                <td><?php echo $bkr['seri_num']; ?></td>
                <td><?php echo $bkr['room_number']; ?></td>
                <td><?php echo $bkr['guest_name']; ?></td>
                <td><?php echo $bkr['guest_phone']; ?></td>
                <td><?php echo $bkr['guest_id_number']; ?></td>
                <td><?php echo $bkr['check_in_date']; ?></td>
                <td><?php echo $bkr['check_out_date']; ?></td>
                <td>
                    <a href="index.php?act=changeRoom&id=<?php echo $bkr['room_id']; ?>&bkr=<?php echo $bkr['booking_room_id']; ?>"
                        class="btn btn-warning btn-sm">Thay
                        đổi phòng</a>
                    <a href="index.php?act=checkoutroom&id=<?php echo $bkr['booking_room_id']; ?>"
                        class="btn btn-success btn-sm">Trả
                        phòng</a>
                </td>
            </tr>
            <?php
                }} else {
                    echo "<tr><td colspan='8' class='text-center text-danger'>Không có dữ liệu tìm kiếm.</td></tr>";
                }
            ?>
        </tbody>
    </table>
    <div class="pagination">
        <ul class="pagination">
            <!-- Trang trước -->
            <?php
                    if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="index.php?act=bookingRooms&page=<?php echo $page - 1; ?>">Trang
                    trước</a>
            </li>
            <?php endif; ?>

            <!-- Hiển thị các trang -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="index.php?act=bookingRooms&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>

            <!-- Trang sau -->
            <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="index.php?act=bookingRooms&page=<?php echo $page + 1; ?>">Trang
                    sau</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php if (isset($bkroom)) { ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var changeRoomModal = new bootstrap.Modal(document.getElementById(
        'changeRoomModal'));
    changeRoomModal.show();
});
</script>
<?php }?>