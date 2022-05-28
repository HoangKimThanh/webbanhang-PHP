<?php 
    $title = 'Thông tin cá nhân';
    require_once './partials/header.php';
?>
<?php 
    if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['province']) 
    && isset($_POST['district']) && isset($_POST['ward']) && isset($_POST['address'])
    && !empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['province']) 
    && !empty($_POST['district']) && !empty($_POST['ward']) && !empty($_POST['address']
    && isset($_SESSION['token']['profile']) && isset($_POST['token']))
    ) {
        if ($_SESSION['token']['profile'] !== $_POST['token']) {
            return;
        }
        $id = $_SESSION['customer']['id'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $province = $_POST['province'];
        $district = $_POST['district'];
        $ward = $_POST['ward'];
        $address = $_POST['address'];

        update_customer($conn, $id, $name, $phone, $province, $district, $ward, $address);
    }
    if (isset($_SESSION['customer']['id'])) {
        $id = $_SESSION['customer']['id'];
        $customer = get_customer_by_id($conn, $id);
        $customer = mysqli_fetch_array($customer);
?>
    <div class="content">
        <div class="main">
            <div class="profile">
                <div class="grid wide">
                    <div class="row">
                        <div class="col l-12 m-12 c-12">
                            <div class="profile__info">
                                <h2>Thông tin cá nhân</h2>
                                <form method="post" id="form">
                                    <input type="hidden" name="token" value="<?php echo $token ?>">
                                    <?php 
                                        $_SESSION['token']['profile'] = $token;
                                    ?>
                                    <div class="form-group">
                                        <label for="name">
                                            Họ tên: 
                                        </label>
                                        <br>
                                        <input value="<?=$customer['name']?>" name="name" type="text" id="name">
                                        <span class="form-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">
                                            Số điện thoại: 
                                        </label>
                                        <br>
                                        <input value="<?=$customer['phone']?>" name="phone" type="text" id="phone">
                                        <span class="form-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="province">
                                            Tỉnh/Thành phố: 
                                        </label>
                                        <br>
                                        <select name="province" id="province"></select>
                                        <span class="form-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="district">
                                            Quận/Huyện/Thị xã: 
                                        </label>
                                        <br>
                                        <select name="district" id="district"></select>
                                        <span class="form-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="ward">
                                            Xã: 
                                        </label>
                                        <br>
                                        <select name="ward" id="ward"></select>
                                        <span class="form-message"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">
                                            Địa chỉ nhà: 
                                        </label>
                                        <br>
                                        <textarea name="address" id="address" cols="30" rows="5"><?=$customer['address']?></textarea>
                                        <span class="form-message"></span>
                                    </div>
                                    <button class="btn" type="submit" name="submit" value="submit">Cập nhật</button>
                                </form>
                            </div>

                            <div class="profile__account">
                                <h2>Thông tin tài khoản</h2>
                                <p>
                                    <label for="email">
                                        Email:
                                    </label>
                                    <span> 
                                        <?=$customer['email']?>
                                    </span>
                                    <br>
                                </p>
                                
                                <p>
                                    <a class="btn" style="margin-top: 16px; margin-bottom: 0" href="doi-email">Đổi email</a>
                                </p>

                                <p>
                                    <a class="btn" style="margin-top: 16px; margin-bottom: 0" href="doi-mat-khau">Đổi mật khẩu</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } 
    else
        header('Location: ./trang-chu');
?>
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

            const selectProvince = $('#province');
            const selectDistrict = $('#district');
            const selectWard = $('#ward');

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
                console.log(hiddenDistrictId)
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
                Validator.isRequired('#name', 'Vui lòng nhập đầy đủ họ tên'),
                Validator.isFullName('#name', 'Vui lòng nhập đúng họ tên'),
                Validator.isRequired('#phone', 'Vui lòng nhập số điện thoại'),
                Validator.isPhone('#phone', 'Vui lòng nhập đúng số điện thoại'),
                Validator.isRequired('#province', 'Chọn tỉnh/thành'),
                Validator.isRequired('#district', 'Chọn quận/huyện'),
                Validator.isRequired('#address', "Vui lòng nhập địa chỉ"),
                
            ],
            // onSubmit: function(data) {
            //     // call API
            //     console.log(data);
            // }
            })
        </script>
<?php 
    require_once './partials/footer.php';
?>