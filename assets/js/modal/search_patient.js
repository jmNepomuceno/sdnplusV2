$(document).ready(function () {
    const RESULTS_PER_PAGE = 10;

    function loadClassifications() {
        $.ajax({
            url: "../../assets/php/patient_registration_form/get_classifications.php",
            method: "GET",
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    let select = $("#classification-select");
                    select.empty().append('<option value="">-- Select Classification --</option>');
                    response.data.forEach(function(item) {
                        select.append('<option value="' + item.class_code + '">' + item.classifications + '</option>');
                    });
                    select.removeClass("d-none"); // show dropdown
                } else {
                    alert("Failed to load classifications: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert("Error fetching classifications.");
            }
        });
    }

    // Call this after patient is chosen and form is auto-filled
    function onPatientChosen() {
        loadClassifications();
    }

    // Handle form submit
    $("#search-patient-form").on("submit", function (e) {
        e.preventDefault();

        // Get input values
        let lastName = $("#last-name-search").val().trim();
        let firstName = $("#first-name-search").val().trim();
        let middleName = $("#middle-name-search").val().trim();

        // Clear old results + loading
        $("#search-results").empty().append(`
            <div class="text-center my-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);

        // AJAX request to backend
        $.ajax({
            url: "../../assets/php/patient_registration_form/get_search_patient.php",
            type: "POST",
            dataType: "json",
            data: {
                lastName: lastName,
                firstName: firstName,
                middleName: middleName
            },
            success: function (response) {
                console.log(response)
                $("#search-results").empty();

                if (response.length === 0) {
                    $("#search-results").append(`
                        <div class="alert alert-warning">No patients found.</div>
                    `);
                    return;
                }

                // Render paginated results
                renderResults(response, 1);

                // Render pagination controls
                renderPagination(response);
            },
            error: function (xhr, status, error) {
                $("#search-results").html(`
                    <div class="alert alert-danger">
                        An error occurred while searching. Please try again.<br>
                        <small>${error}</small>
                    </div>
                `);
            }
        });

    });

    // Function: render results with pagination
    function renderResults(data, page) {
        $("#search-results").empty();

        let start = (page - 1) * RESULTS_PER_PAGE;
        let end = start + RESULTS_PER_PAGE;
        let pageData = data.slice(start, end);

        pageData.forEach(p => {
            let statusText = p.status ? p.status : "Registered";
            let badgeClass = (p.status && p.status.includes("Approved")) 
                ? "bg-success" 
                : "bg-warning";

            let card = `
                <div class="card shadow-sm mb-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1"><strong>Patient ID:</strong> ${p.hpercode}</h6>
                            <p class="mb-0 text-muted">
                                <strong>Name:</strong> ${p.fullName} <br>
                                <strong>Registered at:</strong> ${p.registeredAt}
                            </p>
                            <span class="badge ${badgeClass} mt-2">Status: ${statusText}</span>
                        </div>
                        <div class="text-end">
                            <span class="fw-bold text-dark">${p.birthday}</span><br>
                            <button class="btn btn-primary btn-sm mt-2 use-details-btn" data-id="${p.hpercode}">
                                Choose Patient
                            </button>
                            <button class="btn btn-secondary btn-sm mt-2 view-referral-btn" data-id="${p.hpercode}">
                                View Referral History
                            </button>
                        </div>
                    </div>
                </div>
            `;

            $("#search-results").append(card);
        });

        // Apply scroll if more than 10 results
        if (data.length > RESULTS_PER_PAGE) {
            $("#search-results").css({
                "max-height": "500px",
                "overflow-y": "auto",
                "padding-right": "5px"
            });
        } else {
            $("#search-results").css({
                "max-height": "none",
                "overflow-y": "visible"
            });
        }
    }

    // Function: render pagination controls
    function renderPagination(data) {
        let totalPages = Math.ceil(data.length / RESULTS_PER_PAGE);
        if (totalPages <= 1) return; // No pagination needed

        let pagination = `<nav><ul class="pagination justify-content-center mt-3">`;

        for (let i = 1; i <= totalPages; i++) {
            pagination += `
                <li class="page-item">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `;
        }

        pagination += `</ul></nav>`;

        $("#search-results").after(pagination);

        // Pagination click handler
        $(".page-link").on("click", function (e) {
            e.preventDefault();
            let page = $(this).data("page");
            renderResults(data, page);

            $(".pagination .page-item").removeClass("active");
            $(this).parent().addClass("active");
        });

        // Mark first page active
        $(".pagination .page-item:first").addClass("active");
    }

    // Handle dynamic "View Details" button
    $(document).on("click", ".view-details-btn", function () {
        let patientID = $(this).data("id");
        alert("Clicked View Details for " + patientID);
        // TODO: call another AJAX to fetch more details or open modal
    });

    // Handle View Referral History
    $(document).on("click", ".view-referral-btn", function () {
        let patientID = $(this).data("id");
        alert("View referral history for: " + patientID);
        // TODO: Open modal or call AJAX to load referral history
    });


    // Handle Choose Patient
    $(document).on("click", ".use-details-btn", function () {
        let patientID = $(this).data("id");
        $.ajax({
            url: "../../assets/php/patient_registration_form/get_search_patient_details.php",
            method: "GET",
            data: { hpercode: patientID },
            dataType: "json",
            success: function (res) {
                console.log(patientID);
                $('#referral-hpercode-hidden-input').val(patientID); // Set hidden input in referral form
                if (!res.success) {
                    alert("⚠️ No patient details found.");
                    return;
                }

                let p = res.data;
                // console.table(p);

                // --- Helper for dropdowns ---
                function setDropdown(selector, value, text) {
                    if (!value) return; // skip if null/empty
                    if ($(selector + " option[value='" + value + "']").length === 0) {
                        $(selector).append($("<option>", { value: value, text: text || value }));
                    }
                    $(selector).val(value);
                }

                // ===================== Personal Info =====================
                $("#last-name-txt").val(p.patlast);
                $("#first-name-txt").val(p.patfirst);
                $("#middle-name-txt").val(p.patmiddle);
                $("#extension-name-select").val(p.patsuffix !== "N/A" ? p.patsuffix : "");
                $("#birthday-txt").val(p.patbdate);
                $("#age-txt").val(p.pat_age);
                $("#gender-select").val(p.patsex);
                $("#civil-status-select").val(p.patcstat);
                $("#religion-txt").val(p.relcode);
                $("#occupation-txt").val(p.pat_occupation);
                $("#nationality-txt").val(p.natcode);
                $("#passport-no-txt").val(p.pat_passport_no);
                $("#hospital-no-txt").val(p.hpatcode);
                $("#phic-txt").val(p.phicnum);

                // ===================== Permanent Address =====================
                $("#house-no-txt-pa").val(p.pat_bldg);
                $("#street-txt-pa").val(p.pat_street_block);
                $("#region-select-pa").val(p.pat_region);
                setDropdown("#province-select-pa", p.pat_province, p.pat_province);
                setDropdown("#city-select-pa", p.pat_municipality, p.pat_municipality);
                setDropdown("#barangay-select-pa", p.pat_barangay, p.pat_barangay);
                $("#phone-no-txt-pa").val(p.pat_homephone_no);
                $("#mobile-no-txt-pa").val(p.pat_mobile_no);
                $("#email-txt-pa").val(p.pat_email);

                // ===================== Current Address =====================
                $("#house-no-txt-ca").val(p.pat_curr_bldg);
                $("#street-txt-ca").val(p.pat_curr_street);
                $("#region-select-ca").val(p.pat_curr_region);
                setDropdown("#province-select-ca", p.pat_curr_province, p.pat_curr_province);
                setDropdown("#city-select-ca", p.pat_curr_municipality, p.pat_curr_municipality);
                setDropdown("#barangay-select-ca", p.pat_curr_barangay, p.pat_curr_barangay);
                $("#phone-no-txt-ca").val(p.pat_curr_homephone_no);
                $("#mobile-no-txt-ca").val(p.pat_curr_mobile_no);
                $("#email-txt-ca").val(p.pat_email_ca);

                // ===================== Workplace Address =====================
                $("#house-no-txt-cwa").val(p.pat_work_bldg);
                $("#street-txt-cwa").val(p.pat_work_street);
                setDropdown("#region-select-cwa", p.pat_work_region, p.pat_work_region);
                setDropdown("#province-select-cwa", p.pat_work_province, p.pat_work_province);
                setDropdown("#city-select-cwa", p.pat_work_municipality, p.pat_work_municipality);
                setDropdown("#barangay-select-cwa", p.pat_work_barangay, p.pat_work_barangay);
                $("#workplace-txt-cwa").val(p.pat_namework_place);
                $("#mobile-no-txt-cwa").val(p.pat_work_landline_no);
                $("#email-txt-cwa").val(p.pat_work_email_add);

                // ===================== OFW Address =====================
                $("#employers-name-txt-ofw").val(p.ofw_employers_name);
                $("#occupation-txt-ofw").val(p.ofw_occupation);
                $("#place-work-txt-ofw").val(p.ofw_place_of_work);
                $("#house-no-txt-ofw").val(p.ofw_bldg);
                $("#street-txt-ofw").val(p.ofw_street);
                $("#region-txt-ofw").val(p.ofw_region);
                $("#province-txt-ofw").val(p.ofw_province);
                $("#city-txt-ofw").val(p.ofw_municipality);
                $("#country-txt-ofw").val(p.ofw_country);
                $("#office-mobile-txt-ofw").val(p.ofw_office_phone_no);
                $("#mobile-no-txt-ofw").val(p.ofw_mobile_phone_no);

                alert("✅ Patient details loaded into the form!");

                onPatientChosen()
            },
            error: function (xhr, status, error) {
                console.error("Error fetching patient details:", error);
                alert("An error occurred while fetching patient details.");
            }
        });
    });

    $("#classification-select").on("change", function() {
        if ($(this).val() !== "") {
            $("#add-patient-btn").text("Refer");
        } else {
            $("#add-patient-btn").text("Add");
        }
    });


});
