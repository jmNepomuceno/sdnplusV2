$(document).ready(function () {
    // 🔹 Fetch and render Patient Classifications
    var fetch_patientClassifications = () => {
        $.ajax({
            url: '../../assets/php/admin_module/patient_classification/get_patient_classifications.php',
            method: "GET",
            dataType: "json",
            success: function (response) {
                let classifications = response || [];
                let dataSet = [];

                for (let i = 0; i < classifications.length; i++) {
                    let item = classifications[i];

                    // ---------------- Color Badge ----------------
                    let colorBadge = `
                        <span class="badge" style="background-color:${item.color || '#6c757d'}">
                            ${item.color || 'N/A'}
                        </span>
                    `;

                    // ---------------- Action Buttons ----------------
                    let actionButtons = `
                        <button class="btn btn-sm btn-primary edit-classification-btn" data-id="${item.id}">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger delete-classification-btn" data-id="${item.id}">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    `;

                    // ---------------- Push Row ----------------
                    dataSet.push([
                        item.id,
                        `<strong>${item.classifications || 'N/A'}</strong> <br><small class="text-muted">${item.class_code || ''}</small>`,
                        colorBadge,
                        actionButtons
                    ]);
                }

                // ---------------- Init DataTable ----------------
                if ($.fn.DataTable.isDataTable('#patient-classification-table')) {
                    $('#patient-classification-table').DataTable().destroy();
                    $('#patient-classification-table tbody').empty();
                }

                $('#patient-classification-table').DataTable({
                    destroy: true,
                    data: dataSet,
                    columns: [
                        { title: "ID", width: "10%" },
                        { title: "Classification", width: "50%" },
                        { title: "Color", width: "20%" },
                        { title: "Action", width: "20%" }
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
                console.error("Patient Classification AJAX failed:", error);
            }
        });
    };

    fetch_patientClassifications();

    // 🟢 Add Classification
    $(document).on("submit", "#patient-classification-form", function (e) {
        e.preventDefault();

        let classification = $("#pc-classification").val().trim();
        let code = $("#pc-code").val().trim();
        let color = $("#pc-color").val().trim();

        if (!classification || !code) {
            alert("Please fill out Classification Name and Code.");
            return;
        }

        $.ajax({
            url: '../../assets/php/admin_module/patient_classification/add_patient_classification.php',
            method: 'POST',
            data: {
                classification: classification,
                class_code: code,
                color: color
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $("#patient-classification-form")[0].reset();
                    $("#pc-color").val("#0d6efd"); // reset color picker
                    fetch_patientClassifications(); // 🔄 Refresh DataTable
                } else {
                    alert("⚠️ " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Add Classification AJAX failed:", error);
            }
        });
    });

    // 🗑️ Delete Classification
    $(document).on("click", ".delete-classification-btn", function () {
        let id = $(this).data("id");

        if (!id) return;
        if (!confirm("Are you sure you want to delete this classification?")) return;

        $.ajax({
            url: '../../assets/php/admin_module/patient_classification/delete_patient_classification.php',
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    fetch_patientClassifications(); // 🔄 Refresh DataTable
                } else {
                    alert("⚠️ " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Delete Classification AJAX failed:", error);
            }
        });
    });


});
