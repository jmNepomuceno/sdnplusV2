<div class="modal fade" id="user-accessibility-modal" tabindex="-1" role="dialog" aria-labelledby="userAccessibilityLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered custom-modal-user-accessibility">
        <div class="modal-content shadow-lg rounded-3">
            
            <!-- Modal Header -->
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="userAccessibilityLabel">👤 User Accessibility</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                
                <!-- User Accessibility Form -->
                <form id="user-accessibility-form" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="First Name" id="ua-first-name" required autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Middle Name" id="ua-middle-name" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Last Name" id="ua-last-name" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row g-2 mt-2">
                        <!-- Username -->
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Username" id="ua-username" required autocomplete="off">
                        </div>

                        <!-- Password -->
                        <div class="col-md-4">
                            <input type="password" class="form-control" placeholder="Password" id="ua-password" required autocomplete="off">
                        </div>

                        <!-- Roles -->
                        <div class="col-md-4">
                            <div class="roles-box p-1 rounded border d-flex flex-row gap-3">
                                <label class="fw-bold d-block mb-2">Roles</label>
                                <div class="form-check">
                                    <input class="form-check-input role-check" type="checkbox" id="role-admin" value="admin">
                                    <label class="form-check-label" for="role-admin">Admin</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input role-check" type="checkbox" id="role-doctor-admin" value="doctor_admin">
                                    <label class="form-check-label" for="role-doctor-admin">Doctor Admin</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input role-check" type="checkbox" id="role-doctor-census" value="doctor_admin">
                                    <label class="form-check-label" for="role-doctor-census">Doctor Census</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-person-plus"></i> Add User
                        </button>
                    </div>
                </form>

                <hr>

                <!-- User Accessibility List -->
                <div id="user-accessibility-list" class="mt-3">
                    <table id="user-accessibility-table" class="table table-striped table-bordered table-sm w-100">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10%;">First Name</th>
                                <th style="width: 10%;">Last Name</th>
                                <th style="width: 12%;">Username</th>
                                <th style="width: 12%;">Password</th>
                                <th style="width: 12%;">Role</th>
                                <th style="width: 34%;">Access / Permission</th> <!-- biggest space -->
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Filled dynamically -->
                        </tbody>
                    </table>
                </div>



            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
