$(document).ready(function () {
    // ===============================
    // 📌 FETCH & RENDER HOSPITALS
    // ===============================
    var fetch_hospitals = () => {
        $.ajax({
            url: '../../assets/php/admin_module/view_hospitals/get_hospitals.php', // <-- create this PHP file
            method: "GET",
            dataType: "json",
            success: function (response) {
                console.table(response)
                let hospitals = response || [];
                let dataSet = [];

                for (let i = 0; i < hospitals.length; i++) {
                    let item = hospitals[i];

                    // ---------------- Verified Badge ----------------
                    let verifiedBadge = item.verified == 1
                        ? `<span class="badge bg-success">Yes</span>`
                        : `<span class="badge bg-secondary">No</span>`;

                    // ---------------- Contact Information ----------------
                    let contactInfo = `
                        <div>
                            <strong>Email:</strong> ${item.hospital_email || 'N/A'}<br>
                            <strong>Landline:</strong> ${item.hospital_landline || 'N/A'}<br>
                            <strong>Mobile:</strong> ${item.hospital_mobile || 'N/A'}
                        </div>
                    `;

                    // ---------------- Action Buttons ----------------
                    let actionButtons = `
                        <button class="btn btn-sm btn-dark send-cipher-key-btn" data-id="${item.hospital_ID}">
                            <i class="fa fa-key"></i> Send Cipher Key
                        </button>
                    `;

                    // ---------------- Push Row ----------------
                    dataSet.push([
                        item.hospital_name || 'N/A',
                        item.hospital_code || 'N/A',
                        verifiedBadge,
                        item.user_count || 0,
                        contactInfo,
                        item.hospital_director || 'N/A',
                        item.hospital_director_mobile || 'N/A',
                        item.hospital_point_person || 'N/A',
                        item.hospital_point_person_mobile || 'N/A',
                        actionButtons
                    ]);
                }

                // ---------------- Init DataTable ----------------
                if ($.fn.DataTable.isDataTable('#hospitals-table')) {
                    $('#hospitals-table').DataTable().destroy();
                    $('#hospitals-table tbody').empty();
                }

                $('#hospitals-table').DataTable({
                    destroy: true,
                    data: dataSet,
                    columns: [
                        { title: "Hospital Name", width: "15%" },
                        { title: "Hospital Code", width: "10%" },
                        { title: "Verified", width: "6%" },
                        { title: "No. of Users", width: "8%" },
                        { title: "Contact Information", width: "15%" },
                        { title: "Hospital Director", width: "12%" },
                        { title: "Director Mobile", width: "10%" },
                        { title: "Point Person", width: "12%" },
                        { title: "Point Person Mobile", width: "10%" },
                        { title: "Action", width: "8%" }
                    ],
                    pageLength: 6,
                    responsive: true,
                    autoWidth: false,
                    stripeClasses: [],
                    ordering: false,
                    searching: true,
                    info: false
                });
            },
            error: function (xhr, status, error) {
                console.error("Hospitals AJAX failed:", error);
            }
        });
    };

    // Initial fetch
    fetch_hospitals();

});
