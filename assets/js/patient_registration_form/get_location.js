$(document).ready(function () {
    $.ajax({
        url: '../../assets/php/patient_registration_form/get_region.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // console.log(data)
            // Loop through regions
            data.forEach(function(region) {
                let option = `<option value="${region.region_code}">${region.region_description}</option>`;
                $('#region-select-pa').append(option);
                $('#region-select-ca').append(option);
                $('#region-select-cwa').append(option);
            });
            
        },
        error: function(xhr, status, error) {
            console.error("Error loading regions: " + error);
        }
    });

    function loadProvinces(regionSelect, provinceSelect, citySelect, barangaySelect) {
        $(regionSelect).on("change", function () {
            let regionCode = $(this).val();
            if (regionCode) {
                $.getJSON("../../assets/php/patient_registration_form/get_provinces.php", { region_code: regionCode }, function (data) {
                    let options = "<option value=''>Select Province</option>";
                    $.each(data, function (i, item) {
                        options += `<option value="${item.province_code}">${item.province_description}</option>`;
                    });
                    $(provinceSelect).html(options);
                    $(citySelect).html("<option value=''>Select City</option>");
                    $(barangaySelect).html("<option value=''>Select Barangay</option>");
                });
            }
        });
    }

    function loadCities(provinceSelect, citySelect, barangaySelect) {
        $(provinceSelect).on("change", function () {
            let provinceCode = $(this).val();
            if (provinceCode) {
                $.getJSON("../../assets/php/patient_registration_form/get_cities.php", { province_code: provinceCode }, function (data) {
                    let options = "<option value=''>Select City</option>";
                    $.each(data, function (i, item) {
                        options += `<option value="${item.municipality_code}">${item.municipality_description}</option>`;
                    });
                    $(citySelect).html(options);
                    $(barangaySelect).html("<option value=''>Select Barangay</option>");
                });
            }
        });
    }

    function loadBarangays(citySelect, barangaySelect) {
        $(citySelect).on("change", function () {
            let cityCode = $(this).val();
            if (cityCode) {
                $.getJSON("../../assets/php/patient_registration_form/get_barangays.php", { municipality_code: cityCode }, function (data) {
                    let options = "<option value=''>Select Barangay</option>";
                    $.each(data, function (i, item) {
                        options += `<option value="${item.barangay_code}">${item.barangay_description}</option>`;
                    });
                    $(barangaySelect).html(options);
                });
            }
        });
    }

    // --- Attach for all sets ---
    loadProvinces("#region-select-pa", "#province-select-pa", "#city-select-pa", "#barangay-select-pa");
    loadCities("#province-select-pa", "#city-select-pa", "#barangay-select-pa");
    loadBarangays("#city-select-pa", "#barangay-select-pa");

    loadProvinces("#region-select-ca", "#province-select-ca", "#city-select-ca", "#barangay-select-ca");
    loadCities("#province-select-ca", "#city-select-ca", "#barangay-select-ca");
    loadBarangays("#city-select-ca", "#barangay-select-ca");

    loadProvinces("#region-select-cwa", "#province-select-cwa", "#city-select-cwa", "#barangay-select-cwa");
    loadCities("#province-select-cwa", "#city-select-cwa", "#barangay-select-cwa");
    loadBarangays("#city-select-cwa", "#barangay-select-cwa");

});
