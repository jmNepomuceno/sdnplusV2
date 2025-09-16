var fetch_outgoingReferrals = (url = '../../assets/php/outgoing_referral/get_outgoing_referrals.php', data = {}) => {
    $.ajax({
        url: '../../assets/php/incoming_referral/get_classification_color.php',
        method: "GET",
        dataType: "json",
        success: function (classificationColors) {
            $.ajax({
                url: url,
                method: Object.keys(data).length > 0 ? "POST" : "GET",
                data: data,
                dataType: "json",
                success: function (response) {
                    let referrals = response.data || [];
                    let dataSet = [];
                    console.log(referrals)
                    for (let i = 0; i < referrals.length; i++) {
                        let item = referrals[i];

                        let referred = item.date_time ? new Date(item.date_time) : null;
                        let reception = item.reception_time ? new Date(item.reception_time) : null;

                        // ---------------- Patient Info ----------------
                        let patientInfo = "";
                        if (item.sensitive_case && item.sensitive_case.toLowerCase() === "yes") {
                            patientInfo = `
                                <div class="patient-info-div">
                                    <div class="fw-bold patient-name">[Sensitive – Locked]</div>
                                    <div class="small text-muted patient-extra">
                                        Address: [Hidden]<br>Age: [Hidden]
                                    </div>
                                    <button class="btn btn-sm btn-warning unlock-sensitive mt-1"
                                        data-referral_id="${item.referral_id}"
                                        data-name="${item.patient_name}"
                                        data-address="${item.full_address || 'N/A'}"
                                        data-age="${item.age || 'N/A'}">
                                        🔒 Unlock Info
                                    </button>
                                </div>
                            `;
                        } else {
                            patientInfo = `
                                <div class="patient-info-div">
                                    <div class="fw-bold patient-name">${item.patient_name}</div>
                                    <div class="small text-muted patient-extra">
                                        Address: ${item.full_address || 'N/A'}<br>
                                        Age: ${item.age || 'N/A'}
                                    </div>
                                </div>
                            `;
                        }

                        // ---------------- Action Buttons ----------------
                        let actionButtons = `
                            <button class="btn btn-sm btn-outline-success view-referral" 
                                data-referral_id="${item.referral_id}">
                                <i class="fa fa-file-alt"></i> View Referral
                            </button>
                            <button class="btn btn-sm btn-outline-info view-details" 
                                data-referral_id="${item.referral_id}">
                                <i class="fa fa-eye"></i> More Details
                            </button>
                        `;

                        // ---------------- Push Row ----------------
                        dataSet.push([
                            `<span class="ref-no-span">${item.reference_num}</span>`,
                            patientInfo,
                            `<div class="type-info-div">${item.type}</div>`,
                            `<div class="agency-info-div">
                                <span class="small"><b>Referred To:</b> ${item.referred_by || 'N/A'}</span><br>
                                <span class="small"><b>Landline:</b> ${item.landline_no || 'N/A'}</span><br>
                                <span class="small"><b>Mobile:</b> ${item.mobile_no || 'N/A'}</span>
                                <div class="contact-extra">
                                    <hr>
                                    <span class="small"><b>Director:</b> ${item.hospital_director || 'N/A'}</span><br>
                                    <span class="small"><b>Director No.:</b> ${item.hospital_director_mobile || 'N/A'}</span><br>
                                    <span class="small"><b>Point Person:</b> ${item.hospital_point_person || 'N/A'}</span><br>
                                    <span class="small"><b>Point Person No.:</b> ${item.hospital_point_person_mobile || 'N/A'}</span>
                                </div>
                            </div>`,
                            `<div class="datetime-info-div small">
                                <span><b>Referred:</b> ${item.date_time || '-'}</span><br>
                                <span><b>Reception:</b> ${item.reception_time || '-'}</span>
                                <div class="contact-extra">
                                    <hr>
                                    <span><b>Approval:</b> ${item.approved_time || '-'}</span><br>
                                    <span><b>Deferral:</b> ${item.deferred_time || '-'}</span><br>
                                    <span><b>Cancelled:</b> ${item.deferred_time || '-'}</span><br>
                                </div>
                            </div>`,
                            `<span class="status-badge badge bg-secondary">${item.status}</span>`,
                            `<div class="action-buttons">${actionButtons}</div>`
                        ]);
                    }

                    // ---------------- Init DataTable ----------------
                    if ($.fn.DataTable.isDataTable('#outgoingReferralsTable')) {
                        $('#outgoingReferralsTable').DataTable().destroy();
                        $('#outgoingReferralsTable tbody').empty();
                    }

                    $('#outgoingReferralsTable').DataTable({
                        destroy: true,
                        data: dataSet,
                        columns: [
                            { title: "Reference No." },
                            { title: "Patient's Name" },
                            { title: "Type" },
                            { title: "Agency" },
                            { title: "Date/Time" },
                            { title: "Status" },
                            { title: "Action" }
                        ],
                        columnDefs: [
                            { targets: 0, createdCell: function (td) { $(td).addClass('ref-no-td'); } },
                            { targets: 1, createdCell: function (td) { $(td).addClass('patient-td'); } },
                            {
                                targets: 2,
                                createdCell: function (td) {
                                    $(td).addClass('type-td');
                                    let typeText = $(td).text().trim();
                                    let bgColor = classificationColors[typeText] || "#ccc";
                                    $(td).css({
                                        "background-color": bgColor,
                                        "color": "#fff",
                                        "font-weight": "bold",
                                        "text-align": "center"
                                    });
                                }
                            },
                            { targets: 3, createdCell: function (td) { $(td).addClass('agency-td'); } },
                            { targets: 4, createdCell: function (td) { $(td).addClass('datetime-td'); } },
                            { targets: 5, createdCell: function (td) { $(td).addClass('status-td'); } },
                            { targets: 6, createdCell: function (td) { $(td).addClass('action-td'); } }
                        ],
                        pageLength: 10,
                        responsive: true,
                        info: false,
                        ordering: false,
                        stripeClasses: [],
                        searching: false,
                        autoWidth: false,
                    });
                },
                error: function (xhr, status, error) {
                    console.error("AJAX request failed:", error);
                }
            });
        },
        error: function (xhr, status, error) {
            console.error("Classification fetch failed:", error);
        }
    });
};
 // ♻️ Reusable function to fetch details
var fetchReferralDetails = (referralId) => {
    $.ajax({
        url: "../../assets/php/incoming_referral/get_referral_details.php",
        type: "POST",
        data: { referral_id: referralId },
        dataType: "json",
        success: function(response) {
            console.log(response);
            if (response.success) {
                let p = response.patient;
                let r = response.referral;

                // Fill Patient Info
                $("#hpercode-span b").text(p.hpercode);
                $("#status-span b").text(r.status);
                $("#referred-by-span").text(p.referred_by); //
                $("#pat-mobile-no-span").text(p.pat_mobile_no); //
                $("#patlast-span").text(p.patlast);
                $("#patfirst-span").text(p.patfirst);
                $("#patmiddle-span").text(p.patmiddle);
                $("#patsuffix-span").text(p.patsuffix);
                $("#pat-age-span").text(p.pat_age);
                $("#pat-gender-span").text(p.patsex);
                $("#pat-civil-status-span").text(p.patcstat);
                $("#pat-religion-span").text(p.relcode);
                $("#pat-mobile-no-span").text(p.pat_mobile_no);

                $('#select-response-status').prepend(`<option value="${r.status}" selected hidden>${r.status}</option>`);
                $('#select-response-status').css('pointer-events' , 'none') //a5d6a7
                $('#select-response-status').css('background' , '#a5d6a7') //a5d6a7
                $('#select-response-status').css('font-weight' , 'bold') //a5d6a7

                $('#referred-by-span').text(r.referring_doctor)
                $('#referred-agency-span').text(r.referred_by)
                $('#doc-mobile-no-span').text(r.referring_doctor_mobile)
                // Referral Info
                $("#ref-id-span b").text(r.referral_id);
                $("#reception-time-span").text(r.reception_time);
                $("#processed-by-span").text(r.processed_by);

                // Physical Exam
                $("#bp-span").text(r.bp);
                $("#hr-span").text(r.hr);
                $("#rr-span").text(r.rr);
                $("#temp-span").text(r.temp);
                $("#weight-span").text(r.weight);

                // Textareas
                $("#icd-diagnosis-span").val(r.icd_diagnosis);
                $("#subjective-span").val(r.chief_complaint_history);
                $("#objective-span").val(r.pertinent_findings);
                $("#assessment-span").val(r.diagnosis);
                $("#plan-span").val(r.plan);
                $("#patlast-span").val(r.remarks);
            } else {
                Swal.fire("Error", response.message, "error");
            }
        },
        error: function () {
            Swal.fire("Error", "Failed to fetch referral details", "error");
        }
    });
}




$(document).ready(function() {    
    let patient_referral_modal = new bootstrap.Modal(document.getElementById('patient-referral-modal'));

    socket.onmessage = function(event) {
        let data = JSON.parse(event.data);
        console.log("Received from WebSocket:", data); // Debugging

        // Call fetchNotifValue() on every process update
        switch (data.action.trim()) {
            case "startProcess":
                fetch_outgoingReferrals();
                break;
            default:
                console.log("Unknown action:", data.action);
        }
    };


    // Call the function on page load
    fetch_outgoingReferrals();

    // When "More Details" is clicked
    $(document).on("click", ".view-details", function () {
        let refNo = $(this).data("ref");

        // Find the .contact-extra inside the same row
        let contactExtra = $(this).closest("tr").find(".contact-extra");
        // Toggle visibility
        if (contactExtra.length) {
            contactExtra.slideToggle(); // animation
        }
    });

    $(document).on("click", ".view-referral", function() {
        let referralId = $(this).data("referral_id");
        fetchReferralDetails(referralId);
        $("#patient-referral-modal").modal("show");
    });

    $(document).on("click", ".unlock-sensitive", function() {
        let referralId = $(this).data("referral_id");
        let realName = $(this).data("name");
        let realAddress = $(this).data("address");
        let realAge = $(this).data("age");

        let row = $(this).closest("tr");

        // Prompt the doctor for password
        let password = prompt("Enter password to unlock sensitive details:");

        if (password === null) {
            // User clicked cancel
            return;
        }

        console.log(password)

        // Example hardcoded password check (replace with AJAX validation)
        if (password === "123") {
            row.find(".patient-name").text(realName);
            row.find(".patient-extra").html(`Address: ${realAddress}<br>Age: ${realAge}`);

            // Enable process button
            row.find(".start-process").prop("disabled", false);

            // Remove unlock button
            row.find(".unlock-sensitive").remove();
        } else {
            alert("Incorrect password! Access denied.");
        }
    });

});

//