<?php 
    $title = "Đặt hàng";
    require_once './partials/header.php';
    require_once './functions/invoices.php';
    require_once './functions/customers.php';
?>
<?php
    if (!isset($_SESSION['cart'])) {
        header('Location: trang-chu');
        exit;
    }

    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['province']) 
    && isset($_POST['district']) && isset($_POST['ward']) && isset($_POST['address'])
    && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['province']) 
    && !empty($_POST['district']) && !empty($_POST['ward']) && !empty($_POST['address'] 
    && isset($_SESSION['token']['order']) && isset($_POST['token']))
    ) {
        if ($_SESSION['token']['order'] !== $_POST['token']) {
            return;
        }
        
        if (isset($_SESSION['customer']['id']))
            $customer_id = $_SESSION['customer']['id'];
        else
            $customer_id = 0;

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $provinceId = $_POST['province'];
        $districtId = $_POST['district'];
        $wardId = $_POST['ward'];
        $address = $_POST['address'];
        $cart = $_SESSION['cart'];
        $status = 0;

        $payment = $_POST['payment'];

        insert_invoice($conn, $customer_id, $name, $email, $phone, $provinceId, $districtId, $wardId, $address, $status, $cart, $payment);
    }
    
    if ($isLogged) {
        $customer = get_customer_by_id($conn, $_SESSION['customer']['id']);
        $customer = mysqli_fetch_array($customer);
    }
    
?>
    <div class="content">
        <div class="main">
            <div class="order-1">
                <div class="grid wide">
                    <div class="row">
                        <div class="col l-7 m-7 c-12 left">
                            <div class="order-1-info">
                                <h4>Vui lòng chọn địa chỉ giao hàng</h4>
                                <form method="POST" id="form">
                                    <input type="hidden" name="token" value="<?php echo $token ?>">
                                    <?php 
                                        $_SESSION['token']['order'] = $token;
                                    ?>
                                    <?php 
                                        if (!$isLogged) {
                                    ?>
                                    <div class="order-1-info-way">
                                        <a href="./dang-nhap">
                                            <i class="fas fa-sign-in-alt"></i>
                                            Đăng nhập (Nếu bạn đã có tài khoản của Laptop Computer)
                                        </a>
                                        <br>
                                        <a href="./dang-ky">
                                            <i class="fas fa-sign-in-alt"></i>
                                            Đăng ký (Tạo tài khoản tại Laptop Computer)
                                        </a>
                                        <br>
                                        <label for="user-register">
                                            <input checked type="radio" class="buy-type" name="buy-type" id="user-register">
                                            <span>Khách lẻ</span> (Nếu bạn không muốn lưu lại thông tin)
                                        </label>
                                    </div>
                                    <?php }?>
        
                                    <div class="pay-info sign signup">
                                        <div class="row">
                                            <div class="col l-6 m-6 c-12">
                                                <div class="form-group">
                                                    <label for="signup-fullname">
                                                        Họ tên:<span class="highlight">*</span>
                                                    </label>
                                                    <br>
                                                    <input type="text" name="name" id="signup-fullname" 
                                                        placeholder="Họ tên..."
                                                        autocomplete="username"
                                                        value="<?php if($isLogged) echo $customer['name'] ?>"
                                                    >
                                                    <br>
                                                    <span class="form-message"></span>
                                                </div>
                                            </div>
                                            <div class="col l-6 m-6 c-12">
                                                <div class="form-group">
                                                    <label for="signup-email">
                                                        Email:<span class="highlight">*</span>
                                                    </label>
                                                    <br>
                                                    <input type="email" name="email" id="signup-email" 
                                                        placeholder="Email..."
                                                        autocomplete="email"
                                                        value="<?php if($isLogged) echo $customer['email'] ?>"
                                                    >
                                                    <br>
                                                    <span class="form-message"></span>
                                                </div>
                                            </div>
                                            <div class="col l-6 m-6 c-12">
                                                <div class="form-group">
                                                    <label for="signup-phone">
                                                        Điện thoại:<span class="highlight">*</span>
                                                    </label>
                                                    <br>
                                                    <input type="text" name="phone" id="signup-phone" 
                                                        placeholder="Điện thoại..."
                                                        autocomplete="phone"
                                                        value="<?php if($isLogged) echo $customer['phone'] ?>"
                                                    >
                                                    <br>
                                                    <span class="form-message"></span>
                                                </div>
                                            </div>
                                            <div class="col l-6 m-6 c-12">
                                                <div class="form-group">
                                                    <label for="signup-province">
                                                        Tỉnh/TP:<span class="highlight">*</span>
                                                    </label>
                                                    <br>
                                                    <select name="province" id="signup-province">
                                                    </select>
                                                    <br>
                                                    <span class="form-message"></span>
                                                </div>
                                            </div>
                                            <div class="col l-6 m-6 c-12">
                                                <div class="form-group">
                                                    <label for="signup-district">
                                                        Quận/Huyện:<span class="highlight">*</span>
                                                    </label>
                                                    <br>
                                                    <select name="district" id="signup-district">
                                                        <option>Chọn Quận/Huyện</option>
                                                    </select>
                                                    <br>
                                                    <span class="form-message"></span>
                                                </div>
                                            </div>
                                            <div class="col l-6 m-6 c-12">
                                                <div class="form-group">
                                                    <label for="signup-ward">
                                                        Phường/Xã:<span class="highlight">*</span>
                                                    </label>
                                                    <br>
                                                    <select name="ward" id="signup-ward">
                                                        <option>Chọn Xã/Phường</option>
                                                    </select>
                                                    <br>
                                                    <span class="form-message"></span>
                                                </div>
                                            </div>
                                            <div class="col l-12 m-12 c-12">
                                                <div class="form-group">
                                                    <label for="signup-address">
                                                        Địa chỉ:<span class="highlight">*</span>
                                                    </label>
                                                    <br>
                                                    <textarea name="address" id="signup-address" rows="5" 
                                                        placeholder="Vui lòng điền chính xác thông tin địa chỉ: số nhà, đường, tổ/ấp"
                                                        autocomplete="address"
                                                    ><?php if($isLogged) echo $customer['address'] ?></textarea>
                                                    <br>
                                                    <span class="form-message"></span>
                                                </div>
                                                
                                            </div>
                                            <input type="hidden" value="<?php echo $customer['province'] ?>" name="hiddenProvinceId">
                                            <input type="hidden" value="<?php echo $customer['district'] ?>" name="hiddenDistrictId">
                                            <input type="hidden" value="<?php echo $customer['ward'] ?>" name="hiddenWardId">
                                        </div>
                                    </div>

                                    <div class="pay-way">
                                        <h4>Phương thức thanh toán</h4>
                                        <p>
                                            <input type="radio" name="payment" value="cash" id="cash" checked>
                                            <label for="cash">Thanh toán khi giao hàng</label>
                                        </p>
                                        <p>
                                            <input type="radio" name="payment" value="vnpay" id="vnpay">
                                            <img src="./assets/img/vnpay.png" alt="vnpay" height="20">
                                            <label for="vnpay">&nbsp;Thanh toán bằng VNPay</label>
                                        </p>
                                        <p>
                                            <input type="radio" name="payment" value="momo" id="momo">
                                            <img src="./assets/img/momo.png" alt="momo" height="20">
                                            <label for="momo">&nbsp;Thanh toán bằng QR Momo</label>
                                        </p>
                                        <p>
                                            <input type="radio" name="payment" value="ATM momo" id="ATMmomo">
                                            <img src="./assets/img/momo.png" alt="momo" height="20">
                                            <label for="ATMmomo">&nbsp;Thanh toán bằng ATM Momo</label>
                                        </p>
                                    </div>
        
                                    <p>
                                        <button class="pay" type="submit" value="submit" name="submit">
                                            Thanh toán
                                        </button>
                                    </p>

                                </form>
                            </div>
                        </div>
        
                        <div class="col l-5 m-5 c-12 right">
                            <div class="order-1-money">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Tên sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php 
                                            $total = 0;
                                            foreach($_SESSION['cart'] as $each) {
                                                $total += $each['quantity'] * $each['new_price'];
                                        ?>
                                        <tr>
                                            <td>
                                                <p><?php echo $each['name'] ?></p>
                                            </td>
                                            <td><?php echo $each['quantity'] ?></td>
                                            <td><?php echo $each['quantity'] * $each['new_price'] ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td>Tổng</td>
                                            <td></td>
                                            <td><?php echo $total; ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        var provinces = [];
        var districts = [];
        var wards = [];

        fetch('https://raw.githubusercontent.com/daohoangson/dvhcvn/master/data/dvhcvn.json')
            .then(function(response) {
            return response.json();
            })
            .then(function(datas) {
            var data1 = datas.data;

            data1.forEach(element => {
                element.name = element.name.replace('Tỉnh ', '').replace('Thành phố ', '');
            })

            data1.sort(function(a, b) {
                const nameA = a.name;
                const nameB = b.name;
                if (nameA < nameB) {
                    return -1;
                }

                if (nameA > nameB) {
                    return 1;
                }
            })

            data1.forEach(element1 => {
                provinces.push({
                    id: element1.level1_id,
                    name: element1.name,
                });
                
                data2 = element1.level2s;
                data2.forEach(element2 => {
                    districts.push({
                        id: element2.level2_id,
                        name: element2.name,
                        provinceId: element1.level1_id,
                    })

                    data3 = element2.level3s;
                    data3.forEach(element3 => {
                        wards.push({
                            id: element3.level3_id,
                            name: element3.name,
                            provinceId: element1.level1_id,
                            districtId: element2.level2_id,
                        });
                    })
                });
            });

            const selectProvince = $('#signup-province');
            const selectDistrict = $('#signup-district');
            const selectWard = $('#signup-ward');

            let provinceId;
            let districtId;

            let hiddenProvinceId = '<?php if ($isLogged) echo $customer['province'] ?>';
            let hiddenDistrictId = '<?php if ($isLogged) echo $customer['district'] ?>';
            let hiddenWardId = '<?php if ($isLogged) echo $customer['ward'] ?>';

            var provinceString = '<option selected disabled value="">Chọn Tỉnh/TP</option>'
            provinces.forEach((province) => {
                if (hiddenProvinceId && province.id === hiddenProvinceId) {
                    provinceString += `<option selected value="${province.id}">${province.name}</option>`;
                } else {
                    provinceString += `<option value="${province.id}">${province.name}</option>`;
                }
            })
            selectProvince.html(provinceString);

            if (hiddenDistrictId) {
                let arrDistrict = districts.filter(district => {
                    return district.provinceId == hiddenProvinceId;
                })

                let districtString = '';
                arrDistrict.forEach(district => {
                    if (district.id === hiddenDistrictId) {
                        districtString += `<option selected value="${district.id}">${district.name}</option>`;
                    } else {
                        districtString += `<option value="${district.id}">${district.name}</option>`;
                    }
                })

                selectDistrict.html(districtString);
            }

            if (hiddenWardId) {
                let arrWard = wards.filter((ward) => {
                    return ward.districtId === hiddenDistrictId;
                })

                let wardString = '';
                arrWard.forEach(ward => {
                    if (ward.id === hiddenWardId) {
                        wardString += `<option selected value="${ward.id}">${ward.name}</option>`;
                    } else {
                        wardString += `<option value="${ward.id}">${ward.name}</option>`;
                    }
                })

                selectWard.html(wardString);
            }



            selectProvince.change(function() {
                let districtString ='<option selected disabled value="">Chọn Huyện/Thị xã</option>';
                provinceId = selectProvince.val();

                let arrDistrict = districts.filter((district) => {
                    return district.provinceId === provinceId;
                })

                arrDistrict.forEach((district) => {
                    districtString += `<option value="${district.id}">${district.name}</option>`;
                })
                selectDistrict.html(districtString);
            })

            selectDistrict.change(function() {
                let wardString = '';
                districtId = selectDistrict.val();

                let arrWard = wards.filter((ward) => {
                    return ward.districtId === districtId;
                })

                arrWard.forEach((ward) => {
                    wardString += `<option value="${ward.id}">${ward.name}</option>`;
                })
                selectWard.html(wardString);
            })
        });
    </script>

    <script src="./assets/js/validator.js"></script>
    <script>
        Validator({
        form: '#form',
        formGroupSelector: '.form-group',
        errorElement: '.form-message',
        rules: [
            Validator.isRequired('#signup-fullname', 'Vui lòng nhập đầy đủ họ tên'),
            Validator.isFullName('#signup-fullname', 'Vui lòng nhập đúng họ tên'),
            Validator.isRequired('#signup-email', 'Vui lòng nhập đầy đủ email'),
            Validator.isEmail('#signup-email', 'Vui lòng nhập đúng email'),
            Validator.isRequired('#signup-phone', 'Vui lòng nhập số điện thoại'),
            Validator.isPhone('#signup-phone', 'Vui lòng nhập đúng số điện thoại'),
            Validator.isRequired('#signup-phone', 'Vui lòng nhập địa chỉ'),
            Validator.isRequired('#signup-province', 'Chọn tỉnh/thành'),
            Validator.isRequired('#signup-district', 'Chọn quận/huyện'),
            Validator.isRequired('#signup-address', "Vui lòng nhập địa chỉ"),
        ],
        // onSubmit: function(data) {
        //     // call API
        //     console.log(data);
        // }
    })
    </script>


<?php
    include "./partials/footer.php";
?>