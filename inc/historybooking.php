<div class="container my-5">
    <h2 class="text-center mb-4">Lịch Sử Đặt Phòng</h2>
    <div class="row">
        <?php 
        if ($history) {
            
        foreach($history as $hts){?>
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="index.php?act=viewBooking&id=<?php echo $hts['id']; ?>" class="text-decoration-none">
                <div class="card h-100 shadow-lg border-0 hover-shadow">
                    <div class="card-body ">
                        <h5 class="card-title mb-3 text-dark">Mã Đặt Phòng: <?php echo $hts['seri_num']; ?></h5>

                        <p class="card-text mb-1 text-dark"><strong>Ngày Đặt Phòng:</strong>
                            <?php echo (new DateTime($hts['booking_date']))->format('d-m-Y H:i:s'); ?>
                        </p>
                        <p class="card-text mb-1 text-dark"><strong>Giá Tiền:</strong>
                            <?php echo number_format($hts['amount']); ?> VND
                        </p>
                        <p class="card-text mb-1 text-dark"><strong>Số lượng phòng đã đặt:</strong>
                            <?php echo $hts['slphong']; ?>
                        </p>
                        <p class="card-text mb-1 text-dark"><strong>Khách Ở:</strong>
                            <?php echo $hts['people']; ?>
                        </p>

                        <p class="mb-2 text-dark">
                            <strong>Tình Trạng:</strong>
                            <?php 
                            if ($hts['status'] == 'pending') {
                                echo '<span class="badge bg-warning">Chờ xác nhận</span>';
                            } elseif ($hts['status'] == 'confirmed') {
                                echo '<span class="badge bg-success">Đã xác nhận</span>';
                            } elseif($hts['status'] == 'checkin') {
                                echo '<span class="badge bg-primary">Đã nhận phòng</span>';
                            } elseif($hts['status'] == 'checkout') {
                                echo '<span class="badge bg-secondary">Đã trả phòng</span>';
                            } else {
                                echo '<span class="badge bg-danger">Đã hủy</span>';
                            }
                            ?>
                        </p>

                        <?php if ($hts['status'] == 'pending' || $hts['status'] == 'confirmed') { ?>
                        <a href="#" onclick="confirmCancelBooking(<?php echo $hts['id']; ?>)"
                            class="btn btn-danger btn-sm w-100 mt-3">Hủy Đặt
                            Phòng</a>
                        <?php } ?>
                    </div>
                </div>
            </a>
        </div>
        <?php }
        }else{echo '<p class="text-center text-danger">Chưa có lịch sử đặt phòng nào</p>';} ?>
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
                window.location.href = "index.php?act=history";
            }
        });
        </script>
        <?php } ?>
    </div>
    <div class="pagination justify-content-end">
        <ul class="pagination">
            <!-- Trang trước -->
            <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="index.php?act=history&page=<?php echo $page - 1; ?>">Trang
                    trước</a>
            </li>
            <?php endif; ?>

            <!-- Hiển thị các trang -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="index.php?act=history&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>

            <!-- Trang sau -->
            <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="index.php?act=history&page=<?php echo $page + 1; ?>">Trang
                    sau</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<script>
function confirmCancelBooking(bookingId) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success ms-3",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    });

    swalWithBootstrapButtons
        .fire({
            title: "Hủy đặt phòng",
            text: "Bạn chắc chắn muốn hủy đơn đặt phòng này!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Có",
            cancelButtonText: "Không",
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?act=cancelbooking&id=" + bookingId;
            }
        });
}
</script>
<style>
.hover-shadow:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
    transform: translateY(-5px);
    /* Tăng chiều cao khi hover */
}
</style>