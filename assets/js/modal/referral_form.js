$(document).ready(function() {

    $.ajax({
        url: "../../assets/php/patient_registration_form/get_hospitals.php",
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.table(data)
            let hospitalSelect = $("#rhu-select");
            hospitalSelect.empty();

            // Put BGHMC first
            hospitalSelect.append('<option value="BGHMC" selected>Bataan General Hospital and Medical Center</option>');

            // Then append the rest
            data.forEach(hospital => {
                if (hospital.hospital_name !== "Bataan General Hospital and Medical Center") {
                    hospitalSelect.append(`<option value="${hospital.hospital_code}">${hospital.hospital_name}</option>`);
                }
            });
        }
    });



    // Load referring doctors (based on session hospital_code)
    $.ajax({
        url: "../../assets/php/patient_registration_form/get_referring_doctors.php",
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.table(data)
            // let doctorSelect = $("#doctor_id");
            // doctorSelect.empty().append('<option value="">Select Doctor...</option>');
            // data.forEach(doc => {
            //     let fullName = `${doc.last_name}, ${doc.first_name} ${doc.middle_name ?? ""}`;
            //     doctorSelect.append(`<option value="${doc.doctor_id}">${fullName}</option>`);
            // });
        }
    });

    function searchICD(query, type) {
        // if(query.length < 2) {
        //     $("#icdSuggestions").hide();
        //     return;
        // }

        console.log('Searching ICD for:', query, 'of type:', type);

        $.ajax({
            url: "../../assets/php/patient_registration_form/get_search_icd.php",  // your backend ICD search
            method: "GET",
            data: { q: query, type: type }, 
            datatype: "json",
            success: function(data) {
                console.log(data)
                let results = data
                let suggestionBox = $("#icdSuggestions");
                suggestionBox.empty();
                
                if(results.length > 0) {
                    results.forEach(item => {
                    suggestionBox.append(
                        `<button type="button" class="list-group-item list-group-item-action icd-option" data-code="${item.code}" data-title="${item.title}">
                        ${item.code} - ${item.title}
                        </button>`
                    );
                    });
                    suggestionBox.show();
                } else {
                    suggestionBox.hide();
                }
            }
        });
    }

    // Trigger search on typing
    $("#icdCode").on("keyup", function() {
        console.log('here')
        searchICD($(this).val(), "code");
    });

    $("#icdTitle").on("keyup", function() {
        searchICD($(this).val(), "title");
    });

    // Selecting a result
    $(document).on("click", ".icd-option", function() {
        $("#icdCode").val($(this).data("code"));
        $("#icdTitle").val($(this).data("title"));
        $("#icdSuggestions").hide();
    });


    $("#referral-form").on("submit", function (e) {
        e.preventDefault(); // stop normal form submit

        let formData = $(this).serialize(); // gather all inputs
        console.table('here')
        // $.ajax({
        //     url: "../../assets/php/patient_registration_form/submit_referral.php",
        //     type: "POST",
        //     data: formData,
        //     dataType: "json",
        //     success: function (response) {
        //         if (response.status === "success") {
        //             Swal.fire({
        //                 icon: "success",
        //                 title: "Referral Submitted",
        //                 text: response.message,
        //                 timer: 2000,
        //                 showConfirmButton: false
        //             }).then(() => {
        //                 $("#referralForm")[0].reset(); // reset form
        //             });
        //         } else {
        //             Swal.fire({
        //                 icon: "error",
        //                 title: "Submission Failed",
        //                 text: response.message
        //             });
        //         }
        //     },
        //     error: function (xhr, status, error) {
        //         console.error(error);
        //         Swal.fire({
        //             icon: "error",
        //             title: "Error",
        //             text: "Something went wrong. Please try again."
        //         });
        //     }
        // });
    });
});
