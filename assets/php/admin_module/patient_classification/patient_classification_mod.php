<div class="modal fade" id="patient-classification-modal" tabindex="-1" role="dialog" aria-labelledby="patientClassificationLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered custom-modal-patient-classification">
        <div class="modal-content shadow-lg rounded-3">
            
            <!-- Modal Header -->
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="patientClassificationLabel">🏷️ Patient Classification</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                
                <!-- 🟢 Add Classification Form -->
                <form id="patient-classification-form" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="pc-classification" placeholder="Classification Name" required autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="pc-code" placeholder="Code (e.g., SC001)" required autocomplete="off">
                        </div>
                        <div class="col-md-3">
                            <input type="color" class="form-control form-control-color" id="pc-color" value="#0d6efd" title="Choose color">
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-plus-circle"></i> Add
                            </button>
                        </div>
                    </div>
                </form>


                <hr>

                <!-- Classification Table -->
                <div id="patient-classification-list" class="mt-3">
                    <table id="patient-classification-table" class="table table-striped table-bordered table-sm w-100">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10%;">ID</th>
                                <th style="width: 70%;">Classification Name</th>
                                <th style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamically filled -->
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
