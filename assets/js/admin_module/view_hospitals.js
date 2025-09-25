$(document).ready(function () {
    // ===============================
    // 📌 FETCH & RENDER HOSPITALS
    // ===============================
    var fetch_hospitals = () => {
        $.ajax({
            url: '../../assets/php/admin_module/view_hospitals/get_hospitals.php',
            method: "GET",
            dataType: "json",
            success: function (response) {
                let hospitals = response || [];

                // Destroy old instance
                if ($.fn.DataTable.isDataTable('#hospitals-table')) {
                    $('#hospitals-table').DataTable().destroy();
                    $('#hospitals-table tbody').empty();
                }

                // Initialize DataTable
                let table = $('#hospitals-table').DataTable({
                    destroy: true,
                    data: hospitals,
                    columns: [
                        { data: "hospital_name", title: "Hospital Name", width: "15%" },
                        { data: "hospital_code", title: "Hospital Code", width: "10%" },
                        {
                            data: "hospital_isVerified",
                            title: "Verified",
                            width: "6%",
                            render: (data) => data == 1
                                ? `<span class="badge bg-success">Yes</span>`
                                : `<span class="badge bg-secondary">No</span>`
                        },
                        {
                            data: null,
                            title: "No. of Users",
                            width: "8%",
                            className: "dt-control",
                            orderable: false,
                            render: (data, type, row) => `
                                <button class="btn btn-sm btn-primary">
                                    ${row.user_count} Users
                                </button>
                            `
                        },
                        {
                            data: null,
                            title: "Contact Information",
                            width: "15%",
                            render: (row) => `
                                <div>
                                    <strong>Email:</strong> ${row.hospital_email || 'N/A'}<br>
                                    <strong>Landline:</strong> ${row.hospital_landline || 'N/A'}<br>
                                    <strong>Mobile:</strong> ${row.hospital_mobile || 'N/A'}
                                </div>
                            `
                        },
                        { data: "hospital_director", title: "Hospital Director", width: "12%" },
                        { data: "hospital_director_mobile", title: "Director Mobile", width: "10%" },
                        { data: "hospital_point_person", title: "Point Person", width: "12%" },
                        { data: "hospital_point_person_mobile", title: "Point Person Mobile", width: "10%" },
                        {
                            data: null,
                            title: "Action",
                            width: "8%",
                            render: (row) => `
                                <button class="btn btn-sm btn-dark send-cipher-key-btn" data-id="${row.hospital_ID}">
                                    <i class="fa fa-key"></i> Send Cipher Key
                                </button>
                            `
                        }
                    ],
                    pageLength: 6,
                    responsive: true,
                    autoWidth: false,
                    stripeClasses: [],
                    ordering: false,
                    searching: true,
                    info: false
                });

                // 🔹 Build user table for expansion
                function formatUsersRow(users, hospital_ID) {
                    if (!users || users.length === 0) {
                        return `<div class="p-2"><em>No users found</em></div>`;
                    }

                    let html = `
                        <div class="p-2">
                            <table class="table table-sm table-bordered m-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Middle Name</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                    users.forEach(user => {
                        html += `
                            <tr>
                                <td>${user.user_firstname || ''}</td>
                                <td>${user.user_lastname || ''}</td>
                                <td>${user.user_middlename || ''}</td>
                                <td>${user.username || ''}</td>
                                <td>${user.password || ''}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-user-btn" 
                                        data-id="${user.user_ID}" 
                                        data-hospital="${hospital_ID}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });

                    html += `
                                </tbody>
                            </table>
                        </div>
                    `;
                    return html;
                }

                // 🔹 Handle expand/collapse
                $('#hospitals-table tbody').on('click', 'td.dt-control button', function () {
                    let tr = $(this).closest('tr');
                    let row = table.row(tr);

                    if (row.child.isShown()) {
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        row.child(formatUsersRow(row.data().users, row.data().hospital_ID)).show();
                        tr.addClass('shown');
                    }
                });
                
            },
            error: function (xhr, status, error) {
                console.error("Hospitals AJAX failed:", error);
            }
        });
    };


    // Initial fetch
    fetch_hospitals();

    // Inline edit for accordion users
    $('#hospitals-table').on('click', '.edit-user-btn', function () {
    const $btn = $(this);
    const $row = $btn.closest('tr');

    // Columns to edit
    const cols = ['firstname', 'lastname', 'middlename', 'username', 'password'];

    if ($btn.hasClass('editing')) {
        // ----- Save mode -----
        const userId = $btn.data('id');
        const hospitalId = $btn.data('hospital');

        // Gather updated values
        const updatedUser = {};
        cols.forEach((col, index) => {
            updatedUser[col] = $row.find(`td:eq(${index}) input`).val();
        });
        updatedUser.id = userId;
        updatedUser.hospital_id = hospitalId;

        console.table(updatedUser);

        $.ajax({
            url: '../../assets/php/admin_module/view_hospitals/update_user.php',
            method: 'POST',
            data: updatedUser,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Replace inputs with text
                    cols.forEach((col, index) => {
                        $row.find(`td:eq(${index})`).text(updatedUser[col]);
                    });

                    $btn.removeClass('editing btn-success').addClass('btn-primary')
                        .html('<i class="fa fa-edit"></i>');
                } else {
                    alert("Update failed: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Update error:", error, xhr.responseText);
            }
        });

    } else {
        // ----- Edit mode -----
        cols.forEach((col, index) => {
            const currentVal = $row.find(`td:eq(${index})`).text();
            $row.find(`td:eq(${index})`).html(`<input type="text" class="form-control form-control-sm" value="${currentVal}">`);
        });

        $btn.addClass('editing btn-success').removeClass('btn-primary')
            .html('<i class="fa fa-save"></i>');
    }
});


});
