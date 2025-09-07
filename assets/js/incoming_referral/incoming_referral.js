$(document).ready(function() {    
    let patient_referral_modal = new bootstrap.Modal(document.getElementById('patient-referral-modal'));
    patient_referral_modal.show();
    // Load data via AJAX
    var fetch_incomingReferrals = () => {
        $.ajax({
            url: '../../assets/php/incoming_referral/get_classification_color.php',
            method: "GET",
            dataType: "json",
            success: function (classificationColors) {
                $.ajax({
                    url: '../../assets/php/incoming_referral/get_incoming_referrals.php',
                    method: "GET",
                    dataType: "json",
                    success: function (response) {
                        let referrals = response.data || [];
                        let dataSet = [];

                        console.log(referrals); // Debugging

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

                            dataSet.push([
                                `<span class="ref-no-span">${item.reference_num}</span>`,

                                `<div class="patient-info-div">
                                    <div class="fw-bold">${item.patient_name}</div>
                                    <div class="small text-muted">
                                        Address: ${item.full_address || 'N/A'}<br>
                                        Age: ${item.age || 'N/A'}
                                    </div>
                                </div>`,

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
                                    <span class="text-success"><b>Processed:</b> ${item.processed_time || '-'}</span>
                                </div>`,

                                // 🔹 Add data-referral_id for timer tracking
                                `<span class="response-time badge bg-warning text-dark" 
                                    id="response-time-${item.referral_id}" 
                                    data-reception_time="${item.reception_time || ''}" 
                                    data-approval_time="${item.approval_time || ''}" 
                                    data-deferred_time="${item.deferred_time || ''}">
                                    Processing: 00:00:00
                                </span>`,

                                `<span class="status-badge badge bg-secondary">${item.status}</span>`,

                                `<div class="action-buttons">
                                    <button class="btn btn-sm btn-outline-primary start-process" data-referral_id="${item.referral_id}">
                                        <i class="fa fa-pencil"></i> Process
                                    </button>
                                    <button class="btn btn-sm btn-outline-info view-details" data-referral_id="${item.referral_id}">
                                        <i class="fa fa-eye"></i> More Details
                                    </button>
                                </div>`
                            ]);
                        }

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
                                    createdCell: function(td, cellData, rowData, row, col) {
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
                            paging: false,
                            info: false,
                            ordering: false,
                            stripeClasses: [],
                            searching: false,
                            autoWidth: false,
                        });

                        // 🔹 After rendering table, re-init timers
                        $(".response-time").each(function () {
                            let $this = $(this);
                            let reception = $this.data("reception_time");
                            let approval = $this.data("approval_time");
                            let deferred = $this.data("deferred_time");

                            if (reception && !approval && !deferred) {
                                startTimer($this, reception); // pass jQuery object + reception_time
                            }
                        });

                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX request failed:", error);
                    }
                });

            },
            error: function (xhr, status, error) {
                console.error("AJAX request failed:", error);
            }
        });
    };

    // 🔹 Timer function (global)
    // 🔹 Timer function (only one version)
    // Global map to track running timers
    let activeTimers = {};

    function startTimer(timerCell, startTime) {
        let elementId = timerCell.attr("id");

        // 🚫 If already running, do nothing
        if (activeTimers[elementId]) {
            return;
        }

        let start = new Date(startTime).getTime();

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

            timerCell.text("Processing: " + formatted);

            // 🚨 If elapsed >= 15 minutes (900000 ms), turn text red
            if (elapsed >= 15 * 60 * 1000) {
                timerCell.removeClass("text-dark").addClass("text-danger fw-bold");
            }
        }

        update();
        activeTimers[elementId] = setInterval(update, 1000);
    }




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

        // 🚫 Prevent duplicate timers
        if (activeTimers[elementId]) {
            console.log("Timer already running for referral_id:", referralId);
            return;
        }

        $.ajax({
            url: "../../assets/php/incoming_referral/start_process.php",
            type: "POST",
            data: { referral_id: referralId },
            success: function (response) {
                if (response.success) {
                    let startTime = new Date(response.reception_time);
                    startTimer(timerCell, startTime);

                    row.find(".status-badge")
                        .removeClass("bg-secondary")
                        .addClass("bg-warning")
                        .text("In Progress");
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            },
            error: function () {
                Swal.fire("Error", "Server error starting process", "error");
            }
        });
    });


    // $(document).on("click", ".complete-process", function () {
    //     let referralId = $(this).data("refid");
    //     let row = $(this).closest("tr");

    //     $.ajax({
    //         url: "../../assets/php/referrals/complete_process.php",
    //         type: "POST",
    //         data: { referral_id: referralId, result: "Approved" },
    //         success: function (response) {
    //             if (response.success) {
    //                 row.fadeOut(500, function () {
    //                     row.remove();
    //                 });
    //             } else {
    //                 Swal.fire("Error", response.message, "error");
    //             }
    //         }
    //     });
    // });


});

//