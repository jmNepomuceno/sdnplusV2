$(document).ready(function() {

    socket.onmessage = function(event) {
        let data = JSON.parse(event.data);
        console.log("Received from WebSocket:", data); // Debugging

        // Call fetchNotifValue() on every process update
        switch (data.action) {
            case "sentIncomingReferral":
                console.log(468)
                // fetchNotifValue()
                // dataTable_incoming_request();  
                break;
            default:
                console.log("Unknown action:", data.action);
        }
    };

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

                        for (let i = 0; i < referrals.length; i++) {
                            let item = referrals[i];

                            dataSet.push([
                                `<span class="ref-no-span">${item.reference_num}</span>`,

                                `<div class="patient-info-div">
                                    <div class="fw-bold">${item.patient_name}</div>
                                    <div class="small text-muted">
                                        Address: ${item.full_address || 'N/A'}<br>
                                        Age: ${item.age || 'N/A'}
                                    </div>
                                </div>`,

                                // just text/div, no background here
                                `<div class="type-info-div">${item.type}</div>`,

                                `<div class="agency-info-div">
                                    <span class="small"><b>Referred by:</b> ${item.referred_by || 'N/A'}</span><br>
                                    <span class="small"><b>Landline:</b> ${item.landline_no || 'N/A'}</span><br>
                                    <span class="small"><b>Mobile:</b> ${item.mobile_no || 'N/A'}</span>
                                </div>`,

                                `<div class="datetime-info-div small">
                                    <span><b>Referred:</b> ${item.date_time || '-'}</span><br>
                                    <span><b>Reception:</b> ${item.reception_time || '-'}</span><br>
                                    <span class="text-success"><b>Processed:</b> ${item.processed_time || '-'}</span>
                                </div>`,

                                `<span class="response-time badge bg-warning text-dark">Processing: 00:00:00</span>`,

                                `<span class="status-badge badge bg-secondary">${item.status}</span>`,

                                `<div class="action-buttons">
                                    <button class="btn btn-sm btn-outline-primary start-process" data-ref="${item.reference_num}">
                                        <i class="fa fa-pencil"></i> Process
                                    </button>
                                    <button class="btn btn-sm btn-outline-info view-details" data-ref="${item.reference_num}">
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
                                        // get the type text from the rowData
                                        let typeText = $(td).text().trim();
                                        // lookup color
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


    // Call the function on page load
    fetch_incomingReferrals();

    // Example event handler for process button
    $(document).on("click", ".start-process", function() {
        let refNo = $(this).data("ref");
        alert("Start processing referral: " + refNo);
        // TODO: AJAX update to set status = "Processing"
    });
});

//