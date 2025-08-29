<div class="modal fade custom-modal-size" id="search-patient-modal" tabindex="-1" role="dialog" aria-labelledby="searchPatientLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- Make it large for better viewing -->
        <div class="modal-content shadow-lg rounded-3">
            
            <!-- Modal Header -->
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="searchPatientLabel">🔍 Search Patient</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                
                <!-- Search Filters -->
                <form id="search-patient-form" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Last Name" id="last-name-search">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="First Name" id="first-name-search">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Middle Name" id="middle-name-search">
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </form>

                <hr>

                <!-- Search Results -->
                <div id="search-results">

                    <!-- Example Result Card -->
                    <!-- <div class="card shadow-sm mb-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><strong>Patient ID:</strong> PAT000001</h6>
                                <p class="mb-0 text-muted">
                                    <strong>Name:</strong> TEST RHU_1, TEST RHU_1 TEST RHU_1 <br>
                                    <strong>Registered at:</strong> Test RHU
                                </p>
                                <span class="badge bg-success mt-2">Status: Referred - Approved</span>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-dark">1991-01-01</span><br>
                                <button class="btn btn-primary btn-sm mt-2">View Details</button>
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
