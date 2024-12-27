<div class="rooms-management">
    <div class="container">
        <div class="table-wrapper">
            <form method="post" action="index.php?act=booking">
                <p>Nhập mã seri</p>
                <div class="search-container">
                    <span>CT-</span>
                    <input class="form-control mb-3" id="searchInput1" type="text" name="inp_search1"
                        placeholder="123456" value="<?php echo $_POST['inp_search1'] ?? ''; ?>"
                        style="width: 120px; display: inline-block;">
                    <span>-</span>
                    <input class="form-control mb-3" id="searchInput2" type="text" name="inp_search2"
                        placeholder="123456" value="<?php echo $_POST['inp_search2'] ?? ''; ?>"
                        style="width: 120px; display: inline-block;">
                    <button type="submit" name="search" class="btn btn-primary mb-1" style="display: inline-block;">Tìm
                        kiếm</button>
                </div>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã đặt phòng</th>
                        <th>Tổng khách ở</th>
                        <th>Tổng giá</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt phòng</th>
                        <th>Quản lý đơn</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (isset($err)&&$err!="") {
                        echo "<p class='text-danger'>$err</p>";
                    } else {
                        foreach($booking as $booking){?>
                    <tr onclick="window.location.href='index.php?act=viewBooking&id=<?php echo $booking['id']; ?>';"
                        style="cursor: pointer;">
                        <td><?php echo $booking['seri_num']; ?></td>
                        <td><?php echo $booking['people']; ?></td>

                        <td><?php echo number_format($booking['amount']); ?> VNĐ</td>
                        <td>
                            <?php 
                                if ($booking['status'] == 'pending') {
                                    echo '<span class="badge bg-warning text-dark py-2">Chờ xác nhận</span>';
                                } elseif ($booking['status'] == 'confirmed') {
                                    echo '<span class="badge bg-success py-2 ">Đã xác nhận</span>';
                                } elseif($booking['status'] == 'checkin') {
                                    echo '<span class="badge bg-primary py-2 px-3">đã nhận phòng</span>';
                                }elseif($booking['status'] == 'checkout'){
                                    echo '<span class="badge bg-secondary py-2 px-3">Đã trả phòng</span>';
                                }else{
                                    echo '<span class="badge bg-danger py-2 px-3">Đã hủy</span>';
                                }
                                ?>
                        </td>
                        <td><?php echo $booking['booking_date']; ?></td>
                        <td>
                            <?php
                                if ( $booking['status'] == 'confirmed') {?>
                            <a href="index.php?act=checkinBooking&id=<?php echo $booking['id']; ?>"
                                class="px-4 btn btn-primary">Nhận phòng</a>
                            <a href="index.php?act=cancelBooking&id=<?php echo $booking['id']; ?>"
                                class="px-4 btn btn-danger">Hủy</a>

                            <?php
                                }elseif ( $booking['status'] == 'checkin') {?>
                            <a href="index.php?act=checkoutBooking&id=<?php echo $booking['id']; ?>"
                                class="px-4 btn btn-danger">Trả phòng</a>
                            <?php
                                }else if($booking['status'] == 'pending' ){
                                ?>
                            <a href="index.php?act=confirmBooking&id=<?php echo $booking['id']; ?>"
                                class="px-2 btn btn-success">Xác nhận</a>
                            <a href="index.php?act=cancelBooking&id=<?php echo $booking['id']; ?>"
                                class="px-4 btn btn-danger">Hủy</a>
                            <?php }elseif($booking['status'] == 'cancelled'){}?>
                        </td>

                    </tr>

                    <?php
                    }}
                    ?>
                </tbody>

            </table>
            <div class="pagination">
                <ul class="pagination">
                    <!-- Trang trước -->

                    <?php
                    
                    if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?act=booking&page=<?php echo $page - 1; ?>">Trang
                            trước</a>
                    </li>
                    <?php endif; ?>

                    <!-- Hiển thị các trang -->
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?act=booking&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>

                    <!-- Trang sau -->
                    <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="index.php?act=booking&page=<?php echo $page + 1; ?>">Trang
                            sau</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>
</div>