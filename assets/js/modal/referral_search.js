$(document).ready(function() {
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

        // $.ajax({
        //     url: "../../assets/php/incoming_referral/search_referrals.php",
        //     type: "POST",
        //     data: formData,
        //     dataType: "json",
        //     success: function (response) {
        //         if (response.success) {
        //             let dataSet = [];
        //             response.data.forEach(item => {
        //                 dataSet.push([
        //                     item.reference_num,
        //                     `${item.last_name}, ${item.first_name} ${item.middle_name || ''}`,
        //                     item.case_type,
        //                     item.agency,
        //                     item.status,
        //                     `<button class="btn btn-sm btn-outline-primary view-referral" data-id="${item.referral_id}">
        //                         <i class="fa fa-eye"></i> View
        //                     </button>`
        //                 ]);
        //             });

        //             if ($.fn.DataTable.isDataTable("#incomingReferralsTable")) {
        //                 $("#incomingReferralsTable").DataTable().clear().rows.add(dataSet).draw();
        //             } else {
        //                 $("#incomingReferralsTable").DataTable({
        //                     data: dataSet,
        //                     columns: [
        //                         { title: "Referral No." },
        //                         { title: "Patient Name" },
        //                         { title: "Case Type" },
        //                         { title: "Agency" },
        //                         { title: "Status" },
        //                         { title: "Action" }
        //                     ]
        //                 });
        //             }
        //         } else {
        //             Swal.fire("No Results", response.message, "info");
        //         }
        //     },
        //     error: function () {
        //         Swal.fire("Error", "Search request failed", "error");
        //     }
        // });
    });
})