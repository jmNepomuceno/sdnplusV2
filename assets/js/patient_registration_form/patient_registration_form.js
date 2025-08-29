$(document).ready(function () {
    let search_patient = new bootstrap.Modal(document.getElementById('search-patient-modal'));
    let referral_form_modal = new bootstrap.Modal(document.getElementById('referral-form-modal'));

    referral_form_modal.show();

    function validateEmail(email) {
        // Simple but effective regex for emails
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    $("#email-txt-pa, #email-txt-ca, #email-txt-cwa").on("input", function () {
        let $this = $(this);
        if (validateEmail($this.val())) {
            $this.removeClass("invalid-email").addClass("valid-email");
        } else {
            $this.removeClass("valid-email").addClass("invalid-email");
        }
    });

    // Landline mask (###-####)
    $("#phone-no-txt-pa, #phone-no-txt-ca, #phone-no-txt-cwa, #office-mobile-txt-ofw").mask("000-0000");

    // Mobile mask (####-###-####)
    $("#mobile-no-txt-pa, #mobile-no-txt-ca, #mobile-no-txt-cwa, #mobile-no-txt-ofw").mask("0000-000-0000");

    // Automatically compute Age based on Birthday
    $("#birthday-txt").on("change", function () {
        let birthday = new Date($(this).val());
        if (!isNaN(birthday)) {
            let today = new Date();
            let age = today.getFullYear() - birthday.getFullYear();
            let monthDiff = today.getMonth() - birthday.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthday.getDate())) {
                age--;
            }
            $("#age-txt").val(age);
        }
    });

    $("#add-patient-btn").click(function (e) {
        e.preventDefault();

        // Required fields with IDs
        const requiredFields = [
            "#last-name-txt",
            "#first-name-txt",
            "#middle-name-txt",
            "#birthday-txt",
            "#gender-select",
            "#civil-status-select",
            "#religion-txt",
            "#nationality-txt",

            "#region-select-pa",
            "#province-select-pa",
            "#city-select-pa",
            "#barangay-select-pa",
            "#mobile-no-txt-pa",

            "#region-select-ca",
            "#province-select-ca",
            "#city-select-ca",
            "#barangay-select-ca",
            "#mobile-no-txt-ca"
        ];

        let isValid = true;

        // Reset borders
        requiredFields.forEach(function (field) {
            $(field).css("border", "");
        });

        // Validate required fields
        requiredFields.forEach(function (field) {
            if ($(field).val().trim() === "") {
                $(field).css("border", "2px solid red");
                isValid = false;
            }
        });

        if (!isValid) {
            alert("⚠️ Please fill out all required fields before adding.");
            return;
        }

        

        // let patient_data = {
        //     //PERSONAL INFORMATIONS
        //     patlast : "Test 0528C",
        //     patfirst : "Test 0528C",
        //     patmiddle : "Test 0528C",
        //     patsuffix : "N/A",
        //     pat_bdate : '2000-05-16',
        //     pat_age : 23,
        //     patsex : 'Male',
        //     patcstat :"Test 0528C", //accepts null = yes
        //     relcode : "Test 0528C",
            
        //     pat_occupation: "Test 0528C",
        //     natcode : "Test 0528C",
        //     pat_passport_no : "N/A",
        //     hospital_code : 1111,
        //     phicnum : 34252522535,

        //     //PERMANENT ADDRESS
        //     pat_bldg_pa : "Test 0528C",
        //     hperson_street_block_pa: "Test 0528C",
        //     pat_region_pa : '3',
        //     pat_province_pa : "308",
        //     pat_municipality_pa : '30804',
        //     pat_barangay_pa : '30804015',
        //     pat_email_pa :"N/A",
        //     pat_homephone_no_pa : 0,
        //     pat_mobile_no_pa : '09823425253',

        //     //CURRENT ADDRESS
        //     pat_bldg_ca : "Test 0528C",
        //     hperson_street_block_ca: "Test 0528C",
        //     pat_region_ca : '3',
        //     pat_province_ca : "308",
        //     pat_municipality_ca : '30804',
        //     pat_barangay_ca : '30804015',
        //     pat_email_ca :"N/A",
        //     pat_homephone_no_ca : 0,
        //     pat_mobile_no_ca : '09823425253',

        //     // CURRENT WORKPLACE ADDRESS
        //     pat_bldg_cwa : $('#house-no-txt-cwa').val() ? $('#house-no-txt-cwa').val() : "N/A",
        //     hperson_street_block_pa_cwa : $('#street-txt-cwa').val() ? $('#street-txt-cwa').val() : "N/A",
        //     pat_region_cwa : $('#region-select-cwa').val() ? $('#region-select-cwa').val() : "N/A",
        //     pat_province_cwa : $('#province-select-cwa').val() ? $('#province-select-cwa').val() : "N/A",
        //     pat_municipality_cwa : $('#city-select-cwa').val() ? $('#city-select-cwa').val() : "N/A",
        //     pat_barangay_cwa : $('#brgy-select-cwa').val() ? $('#brgy-select-cwa').val() : "N/A",
        //     pat_namework_place : $('#workplace-txt-cwa').val() ? $('#workplace-txt-cwa').val() : "N/A",
        //     pat_landline_no : $('#phone-no-txt-cwa').val() ? $('#phone-no-txt-cwa').val() : "N/A",
        //     pat_email_cwa : $('#email-txt-cwa').val() ? $('#email-txt-cwa').val() : "N/A",

        //     // FOR OFW ONLY
        //     pat_emp_name : $('#employers-name-txt-ofw').val() ? $('#employers-name-txt-ofw').val() : "N/A",
        //     pat_occupation_ofw : $('#occupation-txt-ofw').val() ? $('#occupation-txt-ofw').val() : "N/A",
        //     pat_place_work : $('#place-work-txt-ofw').val() ? $('#place-work-txt-ofw').val() : "N/A",
        //     pat_bldg_ofw : $('#house-no-txt-ofw').val() ? $('#house-no-txt-ofw').val() : "N/A",
        //     hperson_street_block_ofw : $('#street-txt-ofw').val() ? $('#street-txt-ofw').val() : "N/A",
        //     pat_region_ofw : $('#region-select-ofw').val() ? $('#region-select-ofw').val() : "N/A",
        //     pat_province_ofw : $('#province-select-ofw').val() ? $('#province-select-ofw').val() : "N/A",
        //     pat_city_ofw : $('#city-select-ofw').val() ? $('#city-select-ofw').val() : "N/A",
        //     pat_country_ofw : $('#country-select-ofw').val() ? $('#country-select-ofw').val() : "N/A",
        //     pat_office_mobile_no_ofw : $('#office-phone-no-txt-ofw').val() ? $('#office-phone-no-txt-ofw').val() : "N/A",
        //     pat_mobile_no_ofw : $('#mobile-no-txt-ofw').val() ? $('#mobile-no-txt-ofw').val() : "N/A",
        // }

        // Collect required values
        
        let patient_data = {
            // PERSONAL INFORMATION
            patlast       : $('#last-name-txt').val(),
            patfirst      : $('#first-name-txt').val(),
            patmiddle     : $('#middle-name-txt').val(),
            patsuffix     : $('#extension-name-select').val() || "N/A",
            pat_bdate     : $('#birthday-txt').val(),
            pat_age       : $('#age-txt').val(),
            patsex        : $('#gender-select').val(),
            patcstat      : $('#civil-status-select').val(),
            relcode       : $('#religion-txt').val(),
            pat_occupation: $('#occupation-txt').val() || "N/A",
            natcode       : $('#nationality-txt').val(),
            pat_passport_no: $('#passport-no-txt').val() || "N/A",
            hospital_code : $('#hospital-no-txt').val(),
            phicnum       : $('#phic-txt').val(),

            // PERMANENT ADDRESS
            pat_bldg_pa      : $('#house-no-txt-pa').val(),
            hperson_street_block_pa : $('#street-txt-pa').val(),
            pat_region_pa    : $('#region-select-pa').val(),
            pat_province_pa  : $('#province-select-pa').val(),
            pat_municipality_pa: $('#city-select-pa').val(),
            pat_barangay_pa  : $('#barangay-select-pa').val(),
            pat_homephone_no_pa: $('#phone-no-txt-pa').val() || 0,
            pat_mobile_no_pa : $('#mobile-no-txt-pa').val(),
            pat_email_pa     : $('#email-txt-pa').val() || "N/A",

            // CURRENT ADDRESS
            pat_bldg_ca      : $('#house-no-txt-ca').val(),
            hperson_street_block_ca    : $('#street-txt-ca').val(),
            pat_region_ca    : $('#region-select-ca').val(),
            pat_province_ca  : $('#province-select-ca').val(),
            pat_municipality_ca: $('#city-select-ca').val(),
            pat_barangay_ca  : $('#barangay-select-ca').val(),
            pat_email_ca: $('#phone-no-txt-ca').val() || 0,
            pat_homephone_no_ca : $('#mobile-no-txt-ca').val(),
            pat_mobile_no_ca : $('#email-txt-ca').val() || "N/A",

            // CURRENT WORKPLACE ADDRESS
            pat_bldg_cwa : $('#house-no-txt-cwa').val() ? $('#house-no-txt-cwa').val() : "N/A",
            hperson_street_block_pa_cwa : $('#street-txt-cwa').val() ? $('#street-txt-cwa').val() : "N/A",
            pat_region_cwa : $('#region-select-cwa').val() ? $('#region-select-cwa').val() : "N/A",
            pat_province_cwa : $('#province-select-cwa').val() ? $('#province-select-cwa').val() : "N/A",
            pat_municipality_cwa : $('#city-select-cwa').val() ? $('#city-select-cwa').val() : "N/A",
            pat_barangay_cwa : $('#brgy-select-cwa').val() ? $('#brgy-select-cwa').val() : "N/A",
            pat_namework_place : $('#workplace-txt-cwa').val() ? $('#workplace-txt-cwa').val() : "N/A",
            pat_landline_no : $('#phone-no-txt-cwa').val() ? $('#phone-no-txt-cwa').val() : "N/A",
            pat_email_cwa : $('#email-txt-cwa').val() ? $('#email-txt-cwa').val() : "N/A",

            // FOR OFW ONLY
            pat_emp_name : $('#employers-name-txt-ofw').val() ? $('#employers-name-txt-ofw').val() : "N/A",
            pat_occupation_ofw : $('#occupation-txt-ofw').val() ? $('#occupation-txt-ofw').val() : "N/A",
            pat_place_work : $('#place-work-txt-ofw').val() ? $('#place-work-txt-ofw').val() : "N/A",
            pat_bldg_ofw : $('#house-no-txt-ofw').val() ? $('#house-no-txt-ofw').val() : "N/A",
            hperson_street_block_ofw : $('#street-txt-ofw').val() ? $('#street-txt-ofw').val() : "N/A",
            pat_region_ofw : $('#region-select-ofw').val() ? $('#region-select-ofw').val() : "N/A",
            pat_province_ofw : $('#province-select-ofw').val() ? $('#province-select-ofw').val() : "N/A",
            pat_city_ofw : $('#city-select-ofw').val() ? $('#city-select-ofw').val() : "N/A",
            pat_country_ofw : $('#country-select-ofw').val() ? $('#country-select-ofw').val() : "N/A",
            pat_office_mobile_no_ofw : $('#office-phone-no-txt-ofw').val() ? $('#office-phone-no-txt-ofw').val() : "N/A",
            pat_mobile_no_ofw : $('#mobile-no-txt-ofw').val() ? $('#mobile-no-txt-ofw').val() : "N/A",
        };

        console.log(patient_data)

        $.ajax({
            url: "../../assets/php/patient_registration_form/add_patient.php",
            type: "POST",
            data: patient_data, 
            success: function (response) {
                console.log(response)
                if (response === "success") {
                    alert("✅ Patient successfully added!");
                    // $("#patientForm")[0].reset(); 

                    $('input[type="text"], input[type="email"], input[type="number"], input[type="date"], select').val('');
                    $('#age-txt').val(''); // specifically for age since it's readonly

                    $("input, select").css("border", "");
                } else {
                    alert("❌ Error: " + response);
                }
            },
            error: function () {
                alert("⚠️ Something went wrong. Please try again.");
            },
        });
    });

    // Live border reset when user types/selects
    $("input, select").on("input change", function () {
        if ($(this).val().trim() !== "") {
            $(this).css("border", "");
        }
    });

    // Handle "Same as Permanent Address" checkbox
    $("#same-permanent-btn").on("change", function () {
        console.log('here')
        if ($(this).is(":checked")) {
            // Copy region
            $("#region-select-ca").val($("#region-select-pa").val()).trigger("change");

            // Wait for provinces to load first
            setTimeout(function () {
                $("#province-select-ca").val($("#province-select-pa").val()).trigger("change");
            }, 300);

            // Wait for cities to load
            setTimeout(function () {
                $("#city-select-ca").val($("#city-select-pa").val()).trigger("change");
            }, 600);

            // Wait for barangays to load
            setTimeout(function () {
                $("#barangay-select-ca").val($("#barangay-select-pa").val());
            }, 900);

            // Additional permanent → current
            $("#house-no-txt-ca").val($("#house-no-txt-pa").val());
            $("#street-txt-ca").val($("#street-txt-pa").val());
            $("#phone-no-txt-ca").val($("#phone-no-txt-pa").val());
            $("#mobile-no-txt-ca").val($("#mobile-no-txt-pa").val());
            $("#email-txt-ca").val($("#email-txt-pa").val());

            // Disable fields so they can't be edited
            $("#region-select-ca, #province-select-ca, #city-select-ca, #barangay-select-ca, #address-ca, #house-no-txt-ca, #street-txt-ca, #phone-no-txt-ca, #mobile-no-txt-ca, #email-txt-ca")
                .prop("disabled", true);

        } else {
            // Clear & enable back the fields
            $("#region-select-ca, #province-select-ca, #city-select-ca, #barangay-select-ca, #address-ca, #house-no-txt-ca, #street-txt-ca, #phone-no-txt-ca, #mobile-no-txt-ca, #email-txt-ca")
                .val("")
                .prop("disabled", false);
        }
    });

    $('#clear-patient-btn').click(function() {
        // Clear all input fields
        $('input[type="text"], input[type="email"], input[type="number"], input[type="date"], select').val('');
        $('#age-txt').val(''); // specifically for age since it's readonly

        // Reset borders
        $('input, select').css('border', '');

        // Uncheck the "Same as Permanent Address" checkbox if checked
        $('#same-permanent-btn').prop('checked', false);

        // Enable current address fields if they were disabled
        $("#region-select-ca, #province-select-ca, #city-select-ca, #barangay-select-ca, #address-ca, #house-no-txt-ca, #street-txt-ca, #phone-no-txt-ca, #mobile-no-txt-ca, #email-txt-ca")
            .prop("disabled", false);
    });

    $('#search-patient-btn').on('click', function () {
        search_patient.show();
    })
});
