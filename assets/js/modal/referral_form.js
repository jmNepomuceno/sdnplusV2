$(document).ready(function() {
    const modalElement = document.getElementById('referral-form-modal');
    const referral_form_modal = bootstrap.Modal.getInstance(modalElement) 
        || new bootstrap.Modal(modalElement);

    $.ajax({
        url: "../../assets/php/patient_registration_form/get_hospitals.php",
        type: "GET",
        dataType: "json",
        success: function (data) {
            // console.table(data)
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
            let doctorSelect = $("#referring-doctor-referral-form-select");
            doctorSelect.empty().append('<option value="">Select Doctor...</option>');
            data.forEach(doc => {
                let fullName = `${doc.last_name}, ${doc.first_name} ${doc.middle_name ?? ""}`;
                doctorSelect.append(`<option value="${fullName}" data-mobileNo="${doc.mobile_number}">${fullName}</option>`);
            });
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

    $('#classification-select').on('change', function() {
        $('#referralLabel').text('🏥 ' + $(this).val() + ' Referral Form');
    });

    $("#submit-referral-btn").on("click", function (e) {
        e.preventDefault(); // stop normal form submit

        // Validate form first
        let form = $("#referral-form")[0]; // get DOM element of the form
        if (!form.checkValidity()) {
            form.reportValidity(); // triggers the browser's built-in validation UI
            return; // stop here if form is invalid
        }

        let formData = {
            hpercode: $("#referral-hpercode-hidden-input").val(),
            // hpercode: 'PAT002929',
            type: $("#classification-select").val(),
            status: "Pending", // default
            refer_to: $("#rhu-select option:selected").text(),
            referred_by_no: $("#referring-doctor-referral-form-select option:selected").data("mobileno"),
            icd_diagnosis: $("#icdCode").val(),
            sensitive_case: $("input[name='sensitive_case']:checked").val(),
            parent_guardian: $("#parent-guardian-input").val(),
            phic_member: $("#phic-member-select").val(),
            transport: $("#transport-input").val(),
            referring_doctor: $("#referring-doctor-referral-form-select").val(),
            chief_complaint_history: $("#chief-complaint-input").val(),
            reason: $("#reason-input").val(),
            diagnosis: $("#diagnosis-input").val(),
            remarks: $("#remarks-input").val(),
            bp: $("#bp-input").val(),
            hr: $("#hr-input").val(),
            rr: $("#rr-input").val(),
            temp: $("#temp-input").val(),
            weight: $("#weight-input").val(),
            pertinent_findings: $("#pertinent-findings-input").val()
        };

        console.table(formData)

        $.ajax({
            url: "../../assets/php/patient_registration_form/add_incoming_referral.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Referral Added",
                        text: "The referral has been successfully recorded.",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    referral_form_modal.hide()
                    clear_inputFields()
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "Notice",
                        text: response.message || "Referral was not added."
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong. Please try again."
                });
            }
        });
    });

});
