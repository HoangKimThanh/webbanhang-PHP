<?php
    $title = "Liên hệ";
    require_once './partials/header.php';
?>
        <!---------------------------------------- Content ---------------------------------------->
        <div class="content">
            <!---------------------------------------- Contact ---------------------------------------->
            <div class="main">
                <div class="contact">
                    <div class="grid wide">
                        <h3 class="contact__heading">LIÊN HỆ</h3>
                        <div class="row">
                            <div class="col l-6 m-6 c-12">
                                <div class="contact__info">
                                    <h4 class="contact__info-heading">
                                        <i class="fa fa-phone-alt"></i>
                                        Liên hệ
                                    </h4>
                                    <ul class="contact__info-list">
                                        <li class="contact__info-item">
                                            <p><b>Địa chỉ:</b> Sed est orci, consequat eu ante vel, consectetur sodales diam.</p>
                                        </li>
                                        <li class="contact__info-item">
                                            <p><b>Email:</b> Sed est orci, consequat eu ante vel, consectetur sodales diam.</p>
                                        </li>
                                        <li class="contact__info-item">
                                            <p><b>Hotline:</b> Sed est orci, consequat eu ante vel, consectetur sodales diam.</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="contact__form">
                                    <h4 class="contact__info-heading">
                                        <i class="fa fa-envelope"></i>
                                        Email
                                    </h4>
                                    <div class="contact__form-content">
                                        <form method="post">
                                            <div class="row">
                                                <div class="col l-6 m-6 c-12">
                                                    <label for="lastname">
                                                        <b>Họ tên:<span class="highlight">*</span> </b> <br>
                                                        <input required type="text" id="lastname" placeholder="Họ tên...">
                                                    </label>
                                                </div>
                                                <div class="col l-6 m-6 c-12">
                                                    <label for="email">
                                                        <b>Email:<span class="highlight">*</span> </b> <br>
                                                        <input required type="email" name="email" id="email" placeholder="Email...">
                                                    </label>
                                                </div>
                                                <div class="col l-6 m-6 c-12">
                                                    <label for="phone">
                                                        <b>Điện thoại:<span class="highlight">*</span> </b> <br>
                                                        <input required type="text" name="phone" id="phone" placeholder="Điện thoại...">
                                                    </label>
                                                </div>
                                                <div class="col l-6 m-6 c-12">
                                                    <label for="title">
                                                        <b>Chủ đề:<span class="highlight">*</span> </b> <br>
                                                        <input required type="text" name="title" id="title" placeholder="Chủ đề...">
                                                    </label>
                                                </div>
                                                <div class="col l-12 m-12 c-12">
                                                    <label for="address">
                                                        <b>Lời nhắn:<span class="highlight">*</span> </b> <br>
                                                        <textarea required name="address" id="address" rows="7" placeholder="Lời nhắn..."></textarea>
                                                    </label>
                                                </div>
                                                <div class="col l-12 m-12 c-12">
                                                    <button class="btn">Gửi</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col l-6 m-6 c-12">
                                <div class="contact__map">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.2311711961765!2d106.80086541376906!3d10.870014160434073!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317527587e9ad5bf%3A0xafa66f9c8be3c91!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2jhu4cgVGjDtG5nIHRpbiDEkEhRRyBUUC5IQ00!5e0!3m2!1svi!2s!4v1639578299374!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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