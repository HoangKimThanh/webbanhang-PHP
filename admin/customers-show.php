<?php 
    require_once './partials/header.php';
    require_once './partials/sidenav.php';
    require_once '../functions/customers.php';
    
    $result = get_all_customers($conn);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows === 0) {
        echo 'Chưa có khách có tài khoản nào';
    } else {
?>
    <h1 style="text-align: center;">Danh sách khách hàng</h1>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody style="font-size: 14px">
            <?php 
                $i = 0;
                foreach ($result as $each) {
                    $i++;
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $each['id']; ?></td>
                    <td><?php echo $each['name']; ?></td>
                    <td><?php echo $each['email']; ?></td>
                    <td><?php echo $each['phone']; ?></td>
                    <td>
                        <input type="hidden" value="<?php echo $each['province'] ?>" id="province_id-<?php echo $each['id']?>">
                        <input type="hidden" value="<?php echo $each['district'] ?>" id="district_id-<?php echo $each['id']?>">
                        <input type="hidden" value="<?php echo $each['ward'] ?>" id="ward_id-<?php echo $each['id']?>">
                        <input type="hidden" value="<?php echo $each['address'] ?>" id="address-<?php echo $each['id']?>">
                        <span data-id="<?php echo $each['id']?>" class="full_address_<?php echo $each['id']?>"></span>
                    </td>
                    <td>
                            <a 
                                class="btn btn-danger" 
                                data-id="<?php echo $each['id']?>"
                                href="customers-delete.php?id=<?php echo $each['id']?>" ?
                            >
                                Xóa
                            </a>
                    </td>
                </tr>
            <?php
                };
            ?>
        </tbody>
    </table>

<script>
    var provinces = [];
    var districts = [];
    var wards = [];

    fetch('https://raw.githubusercontent.com/daohoangson/dvhcvn/master/data/dvhcvn.json')
        .then(function(response) {
            return response.json();
        })
        .then(function(datas){
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

            var arrFullAddress = document.querySelectorAll('[class^=full_address]');
            arrFullAddress.forEach(element => {
                let id = element.getAttribute('data-id');
                let provinceId = document.getElementById(`province_id-${id}`).value;
                let districtId = document.getElementById(`district_id-${id}`).value;
                let wardId = document.getElementById(`ward_id-${id}`).value;
                let address = document.getElementById(`address-${id}`).value;

                let province = provinces.find(province => {
                    return province.id == provinceId;
                }).name;
                let district = districts.find(district => {
                    return district.id == districtId;
                }).name;
                let ward = wards.find(ward => {
                    return ward.id == wardId;
                }).name;
                
                let fullAddress = '' + province + ' - ' +  district + ' - ' + ward + ' - ' + address;
                element.innerText = fullAddress;
            })
        })

        let btnDeletes = $('.btn-danger');
        btnDeletes.each(function(index, btnDelete) {
        $(btnDelete).click(function(event) {
            $isReally = confirm('Really delete this?');
            if (!$isReally) {
                event.preventDefault();
            }
        })
    })
</script>

<?php 
    } 
    require_once './partials/footer.php';
?>

