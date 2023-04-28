<?php require APPROOT . '/views/inc/header.php'; ?>
<section class="hero__area hero__area--3 bg_img" data-overlay="dark" data-opacity="4" data-background="assets/images/hero/hero-img-3-1.jpg">
    <div class="container-fluid custom-width custom-width__2">
        <div class="row">
            <div class="col-xl-6 col-lg-7 col-md-8 align-self-center">
                <div class="hero__content hero__content--3 position-relative">
                    <h1 class="title mb-20"><?php echo $data['title'] ?></h1>
                    <p>The coffee is brewed by first roasting the green coffee beans over hot <br> coals in a brazier. given an opportunity to sample.</p>
                    <div class="btns mt-45 d-flex align-items-center justify-content-start">
                        <a href="about.html" class="site-btn">testy Coffee</a>
                        <a href="contact.html" class="site-btn site-btn__borderd site-btn__borderd--double">Read More</a>
                    </div>
                    <div class="social-links mt-60 d-flex justify-content-start align-items-center">
                        <a href="#0"><i class="fab fa-facebook"></i> <span>Facebook</span></a>
                        <a href="#0"><i class="fab fa-twitter"></i> <span>Twitter</span></a>
                        <a href="#0"><i class="fab fa-youtube"></i> <span>youtube</span></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-5 col-md-4">
                <div class="vide-wrapper">
                    <a href="http://www.youtube.com/embed/4xe72U7mXNg?rel=0&amp;controls=0&amp;showinfo=0" data-rel="lightcase:myCollection" data-animation="fadeInLeft" class="video-btn video-btn__2 video-btn__2--white d-flex align-items-center"><i class="fas fa-play"></i><span class="border-effect">play video</span></a>
                </div>
            </div>
        </div>
    </div>
</section>

<h1></h1>
<?php require APPROOT . '/views/inc/footer.php'; ?>