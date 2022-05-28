

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

        var provinceString = '<option selected disabled value="">Chọn Tỉnh/TP</option>'
        provinces.forEach((province) => {
            provinceString += `<option value="${province.id}">${province.name}</option>`;
        })
        selectProvince.html(provinceString);

        selectProvince.change(function() {
            var districtString ='<option selected disabled value="">Chọn Huyện/Thị xã</option>';
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
            var wardString = '';
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
