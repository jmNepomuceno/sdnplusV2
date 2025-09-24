$(document).ready(function () {
    document.querySelectorAll('.role-check').forEach(cb => {
        cb.addEventListener('change', function() {
            if (this.checked) {
                document.querySelectorAll('.role-check').forEach(other => {
                    if (other !== this) other.checked = false;
                });
            }
        });
    });

    // Function to generate checkboxes HTML
    function renderPermissions(perms) {
        let html = '<div class="d-flex flex-wrap gap-2">';
        Object.keys(perms).forEach(key => {
            html += `
                <div class="form-check form-check-inline">
                    <input class="form-check-input permission-checkbox" type="checkbox" 
                        id="perm-${key}" ${perms[key] ? "checked" : ""} disabled>
                    <label class="form-check-label small" for="perm-${key}">
                        ${key.replace("_", " ")}
                    </label>
                </div>
            `;
        });
        html += '</div>';
        return html;
    }

    var fetch_userAccessibility = () => {
        $.ajax({
            url: '../../assets/php/admin_module/user_accessibility/get_user_accessibility.php',
            method: "GET",
            dataType: "json",
            success: function (response) {
                // console.table(response);

                let users = response || [];
                let dataSet = [];

                for (let i = 0; i < users.length; i++) {
                    let item = users[i];

                    // ---------------- Password with eye toggle ----------------
                    let passwordDisplay = `
                        <span class="password-text" data-password="${item.password}">••••••</span>
                        <button class="btn btn-sm btn-outline-secondary toggle-password">
                            <i class="fa fa-eye"></i>
                        </button>
                    `;

                    // ---------------- Role ----------------
                    let roleDisplay = `<span class="badge bg-info">${item.role || 'N/A'}</span>`;

                    // ---------------- Permissions ----------------
                    let permissionsDisplay = renderPermissions(item.permission || {});

                    // ---------------- Action Buttons ----------------
                    let actionButtons = `
                        <button class="btn btn-sm btn-primary edit-user-btn" data-id="${item.user_ID}">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger delete-user-btn" data-id="${item.user_ID}">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    `;

                    // ---------------- Push Row ----------------
                    dataSet.push([
                        item.user_firstname,
                        item.user_lastname,
                        item.username,
                        passwordDisplay,
                        roleDisplay,
                        permissionsDisplay,
                        actionButtons
                    ]);
                }

                // ---------------- Init DataTable ----------------
                if ($.fn.DataTable.isDataTable('#user-accessibility-table')) {
                    $('#user-accessibility-table').DataTable().destroy();
                    $('#user-accessibility-table tbody').empty();
                }

                $('#user-accessibility-table').DataTable({
                    destroy: true,
                    data: dataSet,
                    columns: [
                        { title: "First Name", width: "10%" },
                        { title: "Last Name", width: "10%" },
                        { title: "Username", width: "12%" },
                        { title: "Password", width: "12%" },
                        { title: "Role", width: "12%" },
                        { title: "Access / Permission", width: "34%" },
                        { title: "Action", width: "10%" }
                    ],
                    pageLength: 4,
                    responsive: true,
                    autoWidth: false,
                    stripeClasses: [],
                    ordering: false,
                    searching: true,
                    info: false
                });
            },
            error: function (xhr, status, error) {
                console.error("User Accessibility AJAX failed:", error);
            }
        });
    };

    fetch_userAccessibility()

    $(document).on("click", ".toggle-password", function () {
        let $icon = $(this).find("i");
        let $text = $(this).siblings(".password-text");
        let hidden = $text.text() === "••••••";

        if (hidden) {
            $text.text($text.data("password")); // show password
            $icon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            $text.text("••••••"); // hide password
            $icon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });


    // Handle Edit User button click
    $(document).on("click", ".edit-user-btn", function () {
        let $btn = $(this);
        let table = $('#user-accessibility-table').DataTable();

        // handle responsive child rows
        let $tr = $btn.closest('tr');
        if ($tr.hasClass('child')) {
            $tr = $tr.prev(); // parent row
        }

        let row = table.row($tr);
        let rowData = row.data();
        let userId = $btn.data("id");

        if (!rowData) {
            console.error("Row data not found");
            return;
        }

        const htmlToText = (html) => $('<div>').html(html || '').text().trim();
        const escapeAttr = (str) => $('<div>').text(str || '').html();

        // Extract plain values
        let firstname = htmlToText(rowData[0]);
        let lastname  = htmlToText(rowData[1]);
        let username  = htmlToText(rowData[2]);

        let pwdWrapper = $('<div>').html(rowData[3] || '');
        let password = pwdWrapper.find('.password-text').attr('data-password') || '';

        let roleText = htmlToText(rowData[4]).toLowerCase();
        let isDoctorAdmin  = roleText.includes('doctor admin');
        let isDoctorCensus = roleText.includes('doctor census');
        let isAdmin = !isDoctorAdmin && !isDoctorCensus && roleText.includes('admin');

        let permissionsHtml = (rowData[5] || '').toString().replace(/disabled/gi, '');

        // 🔹 Edit cells in place instead of replacing row.data()
        let cells = $(row.node()).find('td');
        $(cells[0]).html(`<input type="text" class="form-control form-control-sm ua-edit-firstname" value="${escapeAttr(firstname)}">`);
        $(cells[1]).html(`<input type="text" class="form-control form-control-sm ua-edit-lastname" value="${escapeAttr(lastname)}">`);
        $(cells[2]).html(`<input type="text" class="form-control form-control-sm ua-edit-username" value="${escapeAttr(username)}">`);
        $(cells[3]).html(`<input type="password" class="form-control form-control-sm ua-edit-password" value="${escapeAttr(password)}">`);
        $(cells[4]).html(`
            <select class="form-select form-select-sm ua-edit-role">
                <option value="Admin" ${isAdmin ? 'selected' : ''}>Admin</option>
                <option value="Doctor Admin" ${isDoctorAdmin ? 'selected' : ''}>Doctor Admin</option>
                <option value="Doctor Census" ${isDoctorCensus ? 'selected' : ''}>Doctor Census</option>
            </select>
        `);
        $(cells[5]).html(permissionsHtml);
        $(cells[6]).html(`
            <button class="btn btn-sm btn-success save-user-btn" data-id="${userId}">
                <i class="fa fa-save"></i> Save
            </button>
            <button class="btn btn-sm btn-secondary cancel-edit-btn" data-id="${userId}">
                <i class="fa fa-times"></i> Cancel
            </button>
        `);

        // highlight editing row
        $("#user-accessibility-table tbody tr").removeClass("editing-row");
        $(row.node()).addClass("editing-row");
    });




    // ✅ Save edited row
    $(document).on("click", ".save-user-btn", function () {
        let $row = $(this).closest("tr");
        let table = $("#user-accessibility-table").DataTable();
        let userID = $(this).data("id"); // make sure your Save button has data-id="${item.user_ID}"

        let updatedData = {
            user_ID: userID,
            firstname: $row.find(".ua-edit-firstname").val(),
            lastname: $row.find(".ua-edit-lastname").val(),
            username: $row.find(".ua-edit-username").val(),
            password: $row.find(".ua-edit-password").val(),
            role: $row.find(".ua-edit-role").val(),
            permissions: {}
        };

        // collect permissions
        $row.find(".permission-checkbox").each(function () {
            updatedData.permissions[$(this).attr("id").replace("perm-", "")] = $(this).is(":checked");
        });

        // console.table(updatedData);

        // 🔹 Send via AJAX
        $.ajax({
            url: "../../assets/php/admin_module/user_accessibility/update_user_accessibility.php",
            method: "POST",
            data: {
                user_ID: updatedData.user_ID,
                user_firstname: updatedData.firstname,
                user_lastname: updatedData.lastname,
                username: updatedData.username,
                password: updatedData.password,
                role: updatedData.role,
                permissions: JSON.stringify(updatedData.permissions)
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    // 🔹 Re-render row with normal view
                    table.row($row).data([
                        updatedData.firstname,
                        updatedData.lastname,
                        updatedData.username,
                        `
                            <span class="password-text" data-password="${updatedData.password}">••••••</span>
                            <button class="btn btn-sm btn-outline-secondary toggle-password">
                                <i class="fa fa-eye"></i>
                            </button>
                        `,
                        `<span class="badge bg-info">${updatedData.role}</span>`,
                        renderPermissions(updatedData.permissions),
                        `
                            <button class="btn btn-sm btn-primary edit-user-btn" data-id="${updatedData.user_ID}">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger delete-user-btn" data-id="${updatedData.user_ID}">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        `
                    ]).draw(false);

                    $row.removeClass("editing-row");
                } else {
                    alert("⚠️ Update failed: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("❌ AJAX request failed.");
            }
        });
    });


    // ❌ Cancel edit
    $(document).on("click", ".cancel-edit-btn", function () {
        let table = $("#user-accessibility-table").DataTable();
        table.ajax.reload(); // reload from server OR restore row
    });


    // ADD NEW USER
    $("#user-accessibility-form").on("submit", function (e) {
        e.preventDefault();

        // ---- Collect data ----
        let firstName = $("#ua-first-name").val().trim();
        let middleName = $("#ua-middle-name").val().trim();
        let lastName = $("#ua-last-name").val().trim();
        let username = $("#ua-username").val().trim();
        let password = $("#ua-password").val().trim();

        // Roles: allow multiple selections
        let roles = [];
        $(".role-check:checked").each(function () {
            roles.push($(this).val());
        });

        if (!firstName || !lastName || !username || !password) {
            alert("Please fill out all required fields.");
            return;
        }

        // ---- AJAX ----
        $.ajax({
            url: "../../assets/php/admin_module/user_accessibility/add_user_accessibility.php",
            method: "POST",
            data: {
                first_name: firstName,
                middle_name: middleName,
                last_name: lastName,
                username: username,
                password: password,
                roles: roles
            },
            dataType: "json",
            success: function (res) {
                if (res.success) {
                    alert("✅ User added successfully!");
                    $("#user-accessibility-form")[0].reset();
                    fetch_userAccessibility(); // 🔄 reload table
                } else {
                    alert("⚠️ " + (res.message || "Something went wrong."));
                }
            },
            error: function (xhr, status, error) {
                console.error("Add User AJAX failed:", error);
                alert("❌ Failed to add user. Please try again.");
            }
        });
    });


});
