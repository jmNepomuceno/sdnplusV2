$(document).ready(function () {
    // Submit doctor form
    $("#add-referring-doctor-form").on("submit", function (e) {
        e.preventDefault();

        let doctorData = {
            last_name: $("#doctor-last-name").val(),
            first_name: $("#doctor-first-name").val(),
            middle_name: $("#doctor-middle-name").val(),
            license_no: $("#doctor-license-no").val(),
            mobile_no: $("#doctor-mobile-no").val(),
            specialization: $("#doctor-specialization").val()
        };

        // console.table(doctorData)

        $.ajax({
            url: "../../assets/php/patient_registration_form/add_referring_doctor.php",
            type: "POST",
            data: doctorData,
            datatype: "json",
            success: function (res) {
                // let res = JSON.parse(response);
                // console.table(res)
                if (res.status === "success") {
                    
                } else {
                    alert("Error: " + res.message);
                }
            }
        });
    });
});
