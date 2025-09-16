let activeTimers = {};

var fetch_incomingReferrals = (url = '../../assets/php/incoming_referral/get_incoming_referrals.php', data = {}) => {
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

                    for (let i = 0; i < referrals.length; i++) {
                        let item = referrals[i];

                        let referred = item.date_time ? new Date(item.date_time) : null;
                        let reception = item.reception_time ? new Date(item.reception_time) : null;

                        let interval = "";
                        if (referred && reception) {
                            let diff = Math.floor((reception - referred) / 1000); // in seconds
                            let mins = String(Math.floor(diff / 60)).padStart(2, '0');
                            let secs = String(diff % 60).padStart(2, '0');
                            interval = ` <span class="interval-span">(${mins}:${secs})</span>`;
                        }

                        let isSensitive = item.sensitive_case && item.sensitive_case.toLowerCase() === "true";

                        // ---------------- ACTION BUTTONS ----------------
                        let actionButtons = "";
                        if (item.status.toLowerCase() === "pending" || item.status.toLowerCase() === "on-process") {
                            actionButtons = `
                                <button class="btn btn-sm btn-outline-primary start-process" 
                                    data-referral_id="${item.referral_id}" 
                                    ${isSensitive ? "disabled" : ""}>
                                    <i class="fa fa-pencil"></i> Process
                                </button>
                                <button class="btn btn-sm btn-outline-info view-details" 
                                    data-referral_id="${item.referral_id}">
                                    <i class="fa fa-eye"></i> More Details
                                </button>
                                ${isSensitive
                                    ? `<button class="btn btn-sm btn-warning unlock-sensitive mt-1"
                                            data-referral_id="${item.referral_id}"
                                            data-name="${item.patient_name}"
                                            data-address="${item.full_address || 'N/A'}"
                                            data-age="${item.age || 'N/A'}">
                                            🔒 Unlock Info
                                       </button>`
                                    : ""
                                }
                            `;
                        } else {
                            actionButtons = `
                                <button class="btn btn-sm btn-outline-success view-referral" 
                                    data-referral_id="${item.referral_id}">
                                    <i class="fa fa-file-alt"></i> View Referral
                                </button>
                                <button class="btn btn-sm btn-outline-info view-details" 
                                    data-referral_id="${item.referral_id}">
                                    <i class="fa fa-eye"></i> More Details
                                </button>
                            `;
                        }

                        // ---------------- PATIENT INFO ----------------
                        let patientInfo = "";
                        if (isSensitive) {
                            patientInfo = `
                                <div class="patient-info-div">
                                    <div class="fw-bold patient-name">[Confidential – Locked]</div>
                                    <div class="small text-muted patient-extra">
                                        Address: [Hidden]<br>Age: [Hidden]
                                    </div>
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

                        // ---------------- DATATABLE ROW ----------------
                        dataSet.push([
                            `<span class="ref-no-span">${item.reference_num}</span>`,
                            patientInfo,
                            `<div class="type-info-div">${item.type}</div>`,
                            `<div class="agency-info-div">
                                <span class="small"><b>Referred by:</b> ${item.referred_by || 'N/A'}</span><br>
                                <span class="small"><b>Landline:</b> ${item.landline_no || 'N/A'}</span><br>
                                <span class="small"><b>Mobile:</b> ${item.mobile_no || 'N/A'}</span>
                                <div class="contact-extra">
                                    <hr>
                                    <span class="small"><b>Director:</b> ${item.hospital_director || 'N/A'}  </span><br>
                                    <span class="small"><b>Director No.:</b> ${item.hospital_director_mobile || 'N/A'}  </span><br>
                                    <span class="small"><b>Point Person:</b> ${item.hospital_point_person || 'N/A'} </span><br>
                                    <span class="small"><b>Point Person No.:</b> ${item.hospital_point_person_mobile || 'N/A'} </span>
                                </div>
                            </div>`,
                            `<div class="datetime-info-div small">
                                <span><b>Referred:</b> ${item.date_time || '-'}</span><br>
                                <span><b>Reception:</b> ${item.reception_time || '-'}${interval}</span><br>
                                <span class="text-success"><b>Processed:</b> ${item.final_progressed_timer || '-'}</span>
                                <div class="contact-extra">
                                    <hr>
                                    <span><b>Approval:</b> ${item.approved_time || '-'}</span><br>
                                    <span><b>Deferral:</b> ${item.deferred_time || '-'}</span><br>
                                    <span><b>Cancelled:</b> ${item.deferred_time || '-'}</span><br>
                                </div>
                            </div>`,
                            `<span class="response-time badge bg-warning text-dark" 
                                id="response-time-${item.referral_id}" 
                                data-reception_time="${item.reception_time || ''}" 
                                data-approval_time="${item.approved_time || ''}" 
                                data-deferred_time="${item.deferred_time || ''}">
                                Processing: 00:00:00
                            </span>`,
                            `<span class="status-badge badge bg-secondary">${item.status}</span>`,
                            `<div class="action-buttons">${actionButtons}</div>`
                        ]);
                    }

                    // ---------------- INIT DATATABLE ----------------
                    if ($.fn.DataTable.isDataTable('#incomingReferralsTable')) {
                        $('#incomingReferralsTable').DataTable().destroy();
                        $('#incomingReferralsTable tbody').empty();
                    }

                    $('#incomingReferralsTable').DataTable({
                        destroy: true,
                        data: dataSet,
                        columns: [
                            { title: "Reference No." },
                            { title: "Patient's Name" },
                            { title: "Type" },
                            { title: "Agency" },
                            { title: "Date/Time" },
                            { title: "Response Time" },
                            { title: "Status" },
                            { title: "Action" }
                        ],
                        columnDefs: [
                            { targets: 0, createdCell: function(td) { $(td).addClass('ref-no-td'); } },
                            { targets: 1, createdCell: function(td) { $(td).addClass('patient-td'); } },
                            { 
                                targets: 2, 
                                createdCell: function(td, cellData) {
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
                            { targets: 3, createdCell: function(td) { $(td).addClass('agency-td'); } },
                            { targets: 4, createdCell: function(td) { $(td).addClass('datetime-td'); } },
                            { targets: 5, createdCell: function(td) { $(td).addClass('response-time-td'); } },
                            { targets: 6, createdCell: function(td) { $(td).addClass('status-td'); } },
                            { targets: 7, createdCell: function(td) { $(td).addClass('action-td'); } }
                        ],
                        pageLength: 10,
                        responsive: true,
                        info: false,
                        ordering: false,
                        stripeClasses: [],
                        searching: false,
                        autoWidth: false,
                    });

                    // ---------------- RE-INIT TIMERS ----------------
                    $(".response-time").each(function () {
                        let $this = $(this);
                        let referralId = $this.attr("id").replace("response-time-", "");
                        let reception = $this.data("reception_time");
                        let approval = $this.data("approval_time");
                        let deferred = $this.data("deferred_time");

                        if (reception && !approval && !deferred) {
                            startTimer(referralId, reception);
                        }
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


var startTimer = (referralId, reception_time) =>{
    // ⛔ If already running, do nothing
    if (activeTimers[referralId]) return;

    let start = new Date(reception_time).getTime();

    function update() {
        let now = new Date().getTime();
        let elapsed = now - start;

        let hours = Math.floor(elapsed / (1000 * 60 * 60));
        let minutes = Math.floor((elapsed % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((elapsed % (1000 * 60)) / 1000);

        let formatted =
            (hours < 10 ? "0" : "") + hours + ":" +
            (minutes < 10 ? "0" : "") + minutes + ":" +
            (seconds < 10 ? "0" : "") + seconds;

        // 🔄 Always find the latest span after refresh
        let $el = $(`#response-time-${referralId}`);
        if ($el.length) {
            $el.text("Processing: " + formatted);

            // 🚨 If elapsed >= 15 minutes
            if (elapsed >= 15 * 60 * 1000) {
                $el.removeClass("text-dark").addClass("text-danger fw-bold");
            }
        }
    }

    update();
    activeTimers[referralId] = setInterval(update, 1000);
}

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
    var yawa = "asdf";
    let patient_referral_modal = new bootstrap.Modal(document.getElementById('patient-referral-modal'));
    // patient_referral_modal.show();
    // Load data via AJAX
    
    // 🔹 Timer function (global)
    // 🔹 Timer function (only one version)
    // Global map to track running timers

    socket.onmessage = function(event) {
        let data = JSON.parse(event.data);
        console.log("Received from WebSocket:", data); // Debugging

        // Call fetchNotifValue() on every process update
        switch (data.action) {
            case "sentIncomingReferral":
                console.log(468)
                fetch_incomingReferrals();
                break;
            default:
                console.log("Unknown action:", data.action);
        }
    };


    // Call the function on page load
    fetch_incomingReferrals();

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


    // processing referral
    $(document).on("click", ".start-process", function () {
        let referralId = $(this).data("referral_id");
        let button = $(this);

        let row = button.closest("tr");
        let timerCell = row.find(".response-time");
        let elementId = timerCell.attr("id");

        // ✅ Update Referral Status in modal (frontend only)
        $(".value-span-form[data-field='referral_status']").text("On-Process");

        // ✅ Set Select placeholder to On-Process
        $("#select-response-status").html(`
            <option value="On-Process" selected>On-Process</option>
            <option value="Approved">Approve</option>
            <option value="Deferred">Defer</option> 
            <option value="Interdepartamental" disabled>Interdepartamental Referral</option>
        `);

        // ✅ If timer already running, just fetch details + show modal
        if (activeTimers[referralId]) {
            fetchReferralDetails(referralId);
            $("#approve-deferred-submit-btn").data("refid", referralId);
            $("#patient-referral-modal").modal("show");
            return;
        }

        // 🚀 Start process in DB + start timer
        $.ajax({
            url: "../../assets/php/incoming_referral/start_process.php",
            type: "POST",
            data: { referral_id: referralId },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    let startTime = new Date(response.reception_time);
                    startTimer(referralId, startTime);

                    row.find(".status-badge")
                        .removeClass("bg-secondary")
                        .addClass("bg-warning")
                        .text("In Progress");

                    fetchReferralDetails(referralId);
                    $("#approve-deferred-submit-btn").data("refid", referralId);
                    $("#patient-referral-modal").modal("show");
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function () {
                Swal.fire("Error", "Server error starting process", "error");
            }
        });
    });

    $(document).on("click", ".view-referral", function() {
        let referralId = $(this).data("referral_id");
        fetchReferralDetails(referralId);
        $("#patient-referral-modal").modal("show");
    });

    $(document).on("click", "#approve-deferred-submit-btn", function () {
        let referralId = $(this).data("refid");
        let result = $("#select-response-status").val(); // either Approved or Deferred
        let row = $(this).closest("tr");

        console.log(referralId, result, row)

        $.ajax({
            url: '../../assets/php/incoming_referral/complete_process.php',
            type: "POST",
            data: { 
                referral_id: referralId, 
                result: result,
                pat_class : $('#category-approval-select').val(),
                approval_details : $('#er-action').val()
             },
            dataType: "json",
            success: function (response) {
                console.log(response)
                if (response.success) {
                    if (activeTimers[referralId]) {
                        clearInterval(activeTimers[referralId]);
                        delete activeTimers[referralId];
                    }
                    row.fadeOut(500, function () {
                        row.remove();
                    });
                    Swal.fire("Success", "Referral marked as " + result, "success");
                    fetch_incomingReferrals()
                    $("#patient-referral-modal").modal("hide");
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function () {
                Swal.fire("Error", "Server error completing process", "error");
            }
        });
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