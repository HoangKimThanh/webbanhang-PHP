<?php 
    // session_start();
    // if(isset($_SESSION['cart'])) echo 'true'; else echo 'false';
    // echo json_encode($_SESSION);
    // die();
?>
<?php
    $title = "Giới thiệu";
    require_once './partials/header.php';
?>
        <!---------------------------------------- Content ---------------------------------------->
        <div class="content">
            <!---------------------------------------- Intro ---------------------------------------->
            <div class="main">
                <div class="intro">
                    <div class="grid wide">
                        <h3 class="intro__heading">GIỚI THIỆU</h3>
                        <div class="intro__item">
                            <div class="row">
                                <div class="col l-6 m-6 c-12">
                                    <img src="./assets/img/intro-1.jpg" alt="" class="intro__item-img">
                                </div>
                                <div class="col l-6 m-6 c-12">
                                    <h2 class="intro__item-title">Về chúng tôi</h2>
                                    <p class="intro__item-content">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna. Nunc viverra imperdiet enim. Fusce est.
                                        <br><br>
                                        Vivamus a tellus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pharetra nonummy pede. Mauris et orci. Aenean nec lorem.
                                        <br><br>
                                        In porttitor. Donec laoreet nonummy augue. Suspendisse dui purus, scelerisque at, vulputate vitae, pretium mattis, nunc. Mauris eget neque at sem venenatis eleifend. Ut nonummy.
                                        <br><br>
                                        Fusce aliquet pede non pede. Suspendisse dapibus lorem pellentesque magna. Integer nulla. Donec blandit feugiat ligula. Donec hendrerit, felis et imperdiet euismod, purus ipsum pretium metus, in lacinia nulla nisl eget sapien.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="intro__item">
                            <div class="row">
                                <div class="col l-6 m-6 c-12">
                                    <h2 class="intro__item-title">Tầm nhìn</h2>
                                    <p class="intro__item-content">
                                        Donec ut est in lectus consequat consequat. Etiam eget dui. Aliquam erat volutpat. Sed at lorem in nunc porta tristique. Proin nec augue.
                                        <br>
                                        <br>
                                        Quisque aliquam tempor magna. Pellentesque habitant morbi tristique senectus et netus et fames ac turpis egestas. Nunc ac magna. Maecenas odio dolor, vulputate vel, auctor ac, accumsan id, felis. Pellentesque cursus sagittis felis.
                                        <br>
                                        <br>
                                        Pellentesque porttitor, velit lacinia egestas auctor, diam eros tempus arcu, nec vulputate augue magna vel risus. Cras non magna vel ante adipiscing rhoncus. Vivamus a mi. Morbi neque. Aliquam erat volutpat.
                                    </p>
                                </div>
                                <div class="col l-6 m-6 c-12">
                                    <img src="./assets/img/intro-2.jpg" alt="" class="intro__item-img">
                                </div>
                            </div>
                        </div>
                        <div class="intro__item">
                            <div class="row">
                                <div class="col l-6 m-6 c-12">
                                    <img src="./assets/img/intro-3.jpg" alt="" class="intro__item-img">
                                </div>
                                <div class="col l-6 m-6 c-12">
                                    <h2 class="intro__item-title">Tiêu chí cốt lõi</h2>
                                    <p class="intro__item-content">
                                        Integer ultrices lobortis eros. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin semper, ante vitae sollicitudin posuere, metus quam iaculis nibh, vitae scelerisque nunc massa eget pede. Sed velit urna, interdum vel, ultricies vel, faucibus at, quam. Donec elit est, consectetuer eget, consequat quis, tempus quis, wisi.
                                        <br>
                                        <br>
                                        In in nunc. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Donec ullamcorper fringilla eros. Fusce in sapien eu purus dapibus commodo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                                        <br>
                                        <br>
                                        Cras faucibus condimentum odio. Sed ac ligula. Aliquam at eros. Etiam at ligula et tellus ullamcorper ultrices. In fermentum, lorem non cursus porttitor, diam urna accumsan lacus, sed interdum wisi nibh nec nisl.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
    require_once './partials/footer.php';
?>