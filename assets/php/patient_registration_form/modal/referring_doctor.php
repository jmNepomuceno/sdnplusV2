<div class="modal fade custom-modal-size" id="add-referring-doctor-modal" tabindex="-1" role="dialog" aria-labelledby="addReferringDoctorLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- Large modal for form -->
        <div class="modal-content shadow-lg rounded-3">
            
            <!-- Modal Header -->
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="addReferringDoctorLabel">👨‍⚕️ Add Referring Doctor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                
                <!-- Doctor Form -->
                <form id="add-referring-doctor-form" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Last Name" id="doctor-last-name" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="First Name" id="doctor-first-name" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Middle Name" id="doctor-middle-name">
                        </div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="License No." id="doctor-license-no" required>
                        </div>

                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Mobile Number" id="doctor-mobile-no" required>
                        </div>

                        <div class="col-md-4">
                            <select class="form-select" id="doctor-specialization" required>
                                <option value="">-- Select Specialization --</option>
                                <option value="General Medicine">General Medicine</option>
                                <option value="Pediatrics">Pediatrics</option>
                                <option value="Surgery">Surgery</option>
                                <option value="OB-GYN">OB-GYN</option>
                                <option value="Internal Medicine">Internal Medicine</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-person-plus"></i> Save Doctor
                        </button>
                    </div>
                </form>

                <hr>

                <!-- Recently Added Doctors -->
                <div id="recent-doctors" class="mt-3">
                    <table id="doctors-table" class="table table-striped table-bordered table-sm w-100">
                        <thead class="table-light">
                            <tr>
                                <th>Full Name</th>
                                <th>Mobile No</th>
                                <th>License No</th>
                                <th>Status</th>
                                <th style="width: 120px;">Action</th>
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
