<div id="hotelCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/hinh1.jpg" class="d-block w-100" alt="Hotel Image 1">
        </div>
        <div class="carousel-item">
            <img src="images/hinh2.jpg" class="d-block w-100" alt="Hotel Image 2">
        </div>
        <div class="carousel-item">
            <img src="images/hinh3.jpg" class="d-block w-100" alt="Hotel Image 3">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#hotelCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#hotelCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="booking-container  mt-2">
    <div class="booking-form border border-2">
        <h3 class="text-center mb-4">Tìm kiếm phòng</h3>
        <form action="" method="post">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="checkin" class="form-label">Check-in</label>
                    <input type="date" name="checkin" class="form-control" id="checkin" placeholder="dd-mm-yyyy"
                        value="<?php echo date('Y-m-d');?>" min="<?php echo date('Y-m-d');?>" required
                        oninvalid="this.setCustomValidity('Vui lòng chọn ngày nhận phòng.')"
                        oninput="this.setCustomValidity('')">
                </div>
                <div class="col-md-3">
                    <label for="checkout" class="form-label">Check-out</label>
                    <input type="date" name="checkout" class="form-control" id="checkout" placeholder="dd-mm-yyyy"
                        required oninvalid="this.setCustomValidity('Vui lòng chọn ngày trả phòng.')"
                        oninput="this.setCustomValidity('')" min="<?php echo date('Y-m-d');?>">
                </div>
                <div class="col-md-2">
                    <label for="adults" class="form-label">Người lớn</label>
                    <select class="form-select" id="adults" name="adults">
                        <?php for ($i=1; $i <=10 ; $i++) { 
                            if($i==1){
                        ?>
                        <option value="<?php echo $i?>" selected><?php echo $i?></option>
                        <?php }else{
                            ?>
                        <option value="<?php echo $i?>"><?php echo $i?></option>
                        <?php
                        }}?>

                    </select>
                </div>
                <div class="col-md-2">
                    <label for="children" class="form-label">Trẻ em</label>
                    <select class="form-select" id="children" name="children">
                        <?php for ($i=0; $i <=10 ; $i++) { 
                            if($i==0){
                        ?>
                        <option value="<?php echo $i?>" selected><?php echo $i?></option>
                        <?php }else{
                            ?>
                        <option value="<?php echo $i?>"><?php echo $i?></option>
                        <?php
                        }}?>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" name="submit" class="btn btn-primary w-100">Tìm phòng</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Room List -->
<section class="container my-5">
    <h2 class="text-center mb-4">Phòng của chúng tôi</h2>
    <div class="row">
        <div class="col-12">
            <!-- Container cho Owl Carousel -->
            <div class="owl-carousel owl-theme" id="cardContainer">
                <?php foreach($roomtypes as $rt){ ?>
                <div class="item">
                    <div class="card h-100 me-3">
                        <img src="images/<?= $rt['image_url']?>" class="card-img-top" alt="Room">
                        <div class="card-body">
                            <h5 class="card-title"><?= $rt['type_name']?></h5>
                            <p class="card-text text-truncate"
                                style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                <?= $rt['description']?>
                            </p>
                            <p class="card-text">Số lượng phòng: <?= $rt['quantity']?></p>
                            <p><strong>Giá:</strong> <?= number_format($rt['price']) ?> VND/đêm</p>
                        </div>

                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.theme.default.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>

<script>
$(document).ready(function() {
    $('#cardContainer').owlCarousel({
        center: true,
        items: 1,
        loop: true,
        margin: 10,
        responsive: {
            600: {
                items: 1
            },
            800: {
                items: 3
            },
            1000: {
                items: 3
            }
        }
    });
});
</script>