var doctorsTable = $('#doctors-table').DataTable({
    ajax: {
        url: "../../assets/php/patient_registration_form/get_referring_doctor_table.php",
        dataSrc: ''
    },
    columns: [
        { data: 'full_name' },
        { data: 'mobile_no' },
        { data: 'license_no' },
        { data: 'status' },
        {
            data: null,
            render: function (data, type, row) {
                return `
                    <button class="btn btn-danger btn-sm delete-doctor" data-id="${row.id}">
                        Delete
                    </button>
                `;
            }
        }
    ],
    columnDefs: [
        { width: "40%", targets: 0 }, // Full Name wider
        { width: "15%", targets: 1 }, // Mobile No
        { width: "15%", targets: 2 }, // License No
        { width: "15%", targets: 3 }, // Status
        { width: "10%", targets: 4 }  // Action smaller
    ],
    autoWidth: false   // important to respect your custom widths
});



// After adding a doctor via your AJAX insert, refresh the table
function refreshDoctorsTable() {
    doctorsTable.ajax.reload(null, false);
}

$(document).ready(function () {
   
    refreshDoctorsTable()

    // Submit doctor form
    $("#add-referring-doctor-form").on("submit", function (e) {
        e.preventDefault();

        let doctorData = {
            last_name: $("#doctor-last-name").val(),
            first_name: $("#doctor-first-name").val(),
            middle_name: $("#doctor-middle-name").val(),
            license_no: $("#doctor-license-no").val(),
            mobile_no: $("#doctor-mobile-no").val(),
            specialization: $("#doctor-specialization").val()
        };

        // console.table(doctorData)

        $.ajax({
            url: "../../assets/php/patient_registration_form/add_referring_doctor.php",
            type: "POST",
            data: doctorData,
            datatype: "json",
            success: function (res) {
                // let res = JSON.parse(response);
                // console.table(res)
                if (res.status === "success") {
                    refreshDoctorsTable()
                } else {
                    alert("Error: " + res.message);
                }
            }
        });
    });
});
