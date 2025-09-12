$(document).ready(function() {
    // Populate Case Type
    $.getJSON("../../assets/php/patient_registration_form/get_classifications.php", function (response) {
        if (response.success) {
            response.data.forEach(item => {
                $("#case_type").append(
                    `<option value="${item.class_code}">${item.classifications}</option>`
                );
            });
        }
    });

    // Populate Agency
    $.getJSON("../../assets/php/patient_registration_form/get_hospitals.php", function (response) {
        if (Array.isArray(response)) {
            response.forEach(item => {
                $("#agency").append(
                    `<option value="${item.hospital_code}">${item.hospital_name}</option>`
                );
            });
        }
    });

    $("#referral-search-form").on("submit", function (e) {
        e.preventDefault(); // prevent form submit reload

        let formData = {
            referral_no: $("#referral_no").val().trim(),
            last_name: $("#last_name").val().trim(),
            first_name: $("#first_name").val().trim(),
            middle_name: $("#middle_name").val().trim(),
            case_type: $("#case_type").val(),
            agency: $("#agency").val().trim(),
            start_date: $("#start_date").val(),
            end_date: $("#end_date").val(),
            tat_filter: $("#tat_filter").val().trim(),
            sensitive_case: $("#sensitive_case").val(),
            status: $("#status").val()
        };

        console.table(formData)
        fetch_incomingReferrals("../../assets/php/incoming_referral/search_referrals.php", formData);
    });
})