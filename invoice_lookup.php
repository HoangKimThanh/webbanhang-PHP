<?php 
    $title = "Tra cứu hóa đơn";
    require_once './partials/header.php';
    if (isset($_GET['invoice_id'])) {
        $invoice_id = $_GET['invoice_id'];
        $invoice = get_invoice_by_id($conn, $invoice_id);
    }

?>

<div class="content">
    <!---------------------------------------- Cart ---------------------------------------->
    <div class="main">
        <div class="row">
            <div class="col l-12 m-12 c-12">
                <div class="order-find">
                    <h1>Tra cứu đơn hàng</h1>
                    <form action="" method="get">
                        <table>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th><input type="text" name="invoice_id" value="<?php if(isset($invoice_id)) echo $invoice_id?>"></th>
                                <th><button type="submit">TRA CỨU</button></th>
                            </tr>
                        </table>
                    </form>
                    <?php 
                        if (isset($invoice_id)) {
                            if (mysqli_num_rows($invoice) == 1) {
                                $invoice = mysqli_fetch_array($invoice);
                                $invoice_details = get_invoice_details_by_id($conn, $invoice_id);
                                $status;
                                switch ($invoice['status']) {
                                    case '0':
                                        $status = 'Chờ xử lý';
                                        break;
                                    
                                    case '1':
                                        $status = 'Chuẩn bị';
                                        break;
            
                                    case '2':
                                        $status = 'Đang giao';
                                        break;
            
                                    case '3':
                                        $status = 'Đã giao';
                                        break;
                                }
                    ?>
                        <div id="result" style="margin-bottom: 16px; width: 100%">
                            <h1 class="success">THÔNG TIN ĐƠN HÀNG</h1>
                            <table>
                                <tr>
                                    <td>Họ và tên</td>
                                    <td>Email</td>
                                    <td>Số điện thoại</td>
                                    <td>Thời gian đặt</td>
                                    <td>Địa chỉ giao hàng</td>
                                    <td>Hình thức thanh toán</td>
                                    <td>Tình trạng</td>
                                    
                                </tr>
                                <tr>
                                    <th><?php echo $invoice['receiver_name'] ?></th>
                                    <th><?php echo $invoice['receiver_email'] ?></th>
                                    <th><?php echo $invoice['receiver_phone'] ?></th>
                                    <td><?php echo $invoice['time'] ?></td>
                                    <th><span class="full_address"></span></th>
                                    <th><?php echo $invoice['payment'] ?></th>
                                    <th><?php echo $status ?></th>
                                </tr>
                                <input type="hidden" name="" id="receiver_province" value="<?php echo $invoice['receiver_province'] ?>">
                                <input type="hidden" name="" id="receiver_district" value="<?php echo $invoice['receiver_district'] ?>">
                                <input type="hidden" name="" id="receiver_ward" value="<?php echo $invoice['receiver_ward'] ?>">
                                <input type="hidden" name="" id="receiver_address" value="<?php echo $invoice['receiver_address'] ?>">
                            </table>
                        </div>

                        <div id="result-mobile" style="margin-bottom: 16px; text-align: center; width: 100%;">
                            <table>
                                <tr>
                                    <td>Họ và tên</td>
                                    <td><?php echo $invoice['receiver_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?php echo $invoice['receiver_email'] ?></td>
                                </tr>
                                <tr>
                                    <td>Số điện thoại</td>
                                    <td><?php echo $invoice['receiver_phone'] ?></td>
                                </tr>
                                <tr>
                                    <td>Thời gian đặt</td>
                                    <td><?php echo $invoice['time'] ?></td>
                                </tr>
                                <tr>
                                    <td>Địa chỉ giao hàng</td>
                                    <td><span class="full_address"></span></td>
                                </tr>
                                <tr>
                                    <td>Hình thức thanh toán</td>
                                    <td><?php echo $invoice['payment'] ?></td>
                                </tr>
                                <tr>
                                    <td>Tình trạng</td>
                                    <td><?php echo $status ?></td>
                                </tr>
                            </table>
                        </div>
                        
                        <h2>CHI TIẾT HÓA ĐƠN</h2>
                        <table border="1">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                        
                        <?php 
                            $total = 0;
                            foreach($invoice_details as $each) {
                                $total +=  $each['price'] * $each['quantity'];
                        ?>
                                <tr>
                                    <th><img width="100px" src="./assets/img/uploads/<?php echo $each['image'] ?>" alt=""></th>
                                    <th><?php echo $each['name'] ?></th>
                                    <th><?php echo $each['quantity'] ?></th>
                                    <th><?php echo $each['price'] ?></th>
                                    <th><?php echo $each['price'] * $each['quantity'] ?></th>
                                </tr>
                        <?php 
                            }
                        ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Tổng tiền</th>
                                    <th colspan="3"></th>
                                    <th><?php echo $total ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    <?php        
                            } else {
                                echo '<h1 class="error">ĐƠN HÀNG KHÔNG TỒN TẠI!!</h1>';
                            }
                        }
                    ?>
                       
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
    require_once './partials/footer.php';
?>
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

                    var provinceId = document.getElementById('receiver_province').value;
                    var districtId = document.getElementById('receiver_district').value;
                    var wardId = document.getElementById('receiver_ward').value;
                    var address = document.getElementById('receiver_address').value;

                    if (provinceId && districtId && wardId && address) {
                        var province = provinces.find(province => {
                            return province.id == provinceId;
                        }).name;
                        var district = districts.find(district => {
                            return district.id == districtId;
                        }).name;
                        var ward = wards.find(ward => {
                            return ward.id == wardId;
                        }).name;
                        
                        var fullAddress = '' + province + ' - ' +  district + ' - ' + ward + ' - ' + address;
                        document.querySelectorAll('.full_address').forEach(function(addressElement) {
                            addressElement.innerText = fullAddress;
                        })
                    }
        })

</script>
