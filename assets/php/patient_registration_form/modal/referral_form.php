<div class="modal fade custom-modal-size" id="referral-form-modal" tabindex="-1" role="dialog" aria-labelledby="referralLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-3">

            <!-- Modal Header -->
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="referralLabel">🏥 ER Referral Form</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

        <!-- Modal Body -->
            <div class="modal-body">
                <form id="referral-form">

                    <!-- 🔹 Critical Section -->
                    <div class="row m-3 g-3 align-items-center">
                        <div class="row" id="critical-section">
                            <!-- Sensitive Case -->
                            <div class="col-md-4" id="sensitive-case-section">
                            <label class="form-label fw-bold text-danger">
                                Sensitive Case <span class="text-danger">*</span>
                                <i class="bi bi-question-circle-fill text-primary"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Mark 'Yes' if this is a sensitive case (e.g., assault, abuse, rape, etc.)."></i>
                            </label>
                            <div class="d-flex gap-3 mt-1">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sensitive_case" id="sensitiveYes" value="Yes" required>
                                <label class="form-check-label" for="sensitiveYes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sensitive_case" id="sensitiveNo" value="No" required>
                                <label class="form-check-label" for="sensitiveNo">No</label>
                                </div>
                            </div>
                            </div>

                            <!-- ICD-10 Diagnosis -->
                            <div class="col-md-8 position-relative" id="icd-section">
                            <label class="form-label fw-bold">
                                ICD-10 Diagnosis <span class="text-danger">*</span>
                                <i class="bi bi-question-circle-fill text-primary"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Search and select the appropriate ICD-10 code and description for the diagnosis."></i>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="icdCode" placeholder="Enter ICD-10 Code" required>
                                <input type="text" class="form-control" id="icdTitle" placeholder="Enter ICD-10 Title" required>
                            </div>
                            <!-- Dropdown Results -->
                            <div id="icdSuggestions"
                                class="list-group mt-1"
                                style="display:none; max-height:200px; overflow-y:auto; position:absolute; z-index:1000; width:100%;">
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- 🔹 General Info -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                            Registered at RHU / Hospital <span class="text-danger">*</span>
                            <i class="bi bi-question-circle-fill text-primary"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Select the referring RHU or hospital where the patient was registered."></i>
                            </label>
                            <select class="form-select custom-input" id="rhu-select" required>
                                <option selected disabled value="">Select RHU</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                            Referring Doctor <span class="text-danger">*</span>
                            <i class="bi bi-question-circle-fill text-primary"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Select the doctor who referred the patient."></i>
                            </label>
                            <select class="form-select custom-input" required>
                            <option selected disabled value="">Select Doctor</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                            Parent/Guardian (if minor) <span class="text-danger">*</span>
                            <i class="bi bi-question-circle-fill text-primary"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Enter the name of the parent or guardian if the patient is a minor."></i>
                            </label>
                            <input type="text" class="form-control custom-input" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                            PHIC Member <span class="text-danger">*</span>
                            <i class="bi bi-question-circle-fill text-primary"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Select if the patient is a member of PhilHealth."></i>
                            </label>
                            <select class="form-select custom-input" required>
                            <option value="" disabled selected>Select</option>
                            <option>Yes</option>
                            <option>No</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                            Mode of Transport <span class="text-danger">*</span>
                            <i class="bi bi-question-circle-fill text-primary"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Select the type of transport used by the patient."></i>
                            </label>
                            <select class="form-select custom-input" required>
                            <option value="" disabled selected>Select</option>
                            <option>Ambulance</option>
                            <option>Private Car</option>
                            <option>Commute</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                            Date/Time Admitted <span class="text-danger">*</span>
                            <i class="bi bi-question-circle-fill text-primary"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="This field records the exact date and time the patient was admitted."></i>
                            </label>
                            <input type="datetime-local" class="form-control custom-input" value="<?php echo date('Y-m-d\TH:i'); ?>" readonly required>
                        </div>
                    </div>

                    <!-- 🔹 Textareas -->
                    <div class="mt-4">
                        <label class="form-label fw-bold">
                            Chief Complaint & History (Subjective) <span class="text-danger">*</span>
                            <i class="bi bi-question-circle-fill text-primary"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Enter the patient's chief complaint and relevant medical history."></i>
                        </label>
                        <textarea class="form-control custom-input" rows="2" required></textarea>
                    </div>

                    <div class="mt-3">
                        <label class="form-label fw-bold">
                            Reason for Referral (Plan) <span class="text-danger">*</span>
                            <i class="bi bi-question-circle-fill text-primary"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="State the reason for referral or the plan for further management."></i>
                        </label>
                        <textarea class="form-control custom-input" rows="2" required></textarea>
                    </div>

                    <div class="mt-3">
                        <label class="form-label fw-bold">
                            Diagnosis (Assessment) <span class="text-danger">*</span>
                            <i class="bi bi-question-circle-fill text-primary"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Enter the working diagnosis based on assessment."></i>
                        </label>
                        <textarea class="form-control custom-input" rows="2" required></textarea>
                    </div>

                    <div class="mt-3">
                        <label class="form-label fw-bold">
                            Remarks <span class="text-danger">*</span>
                            <i class="bi bi-question-circle-fill text-primary"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Enter any additional remarks or notes."></i>
                        </label>
                        <textarea class="form-control custom-input" rows="2" required></textarea>
                    </div>

                    <!-- 🔹 Physical Examination -->
                    <div class="card mt-4 shadow-sm">
                        <div class="card-header bg-light fw-bold d-flex align-items-center justify-content-between">
                            <span>
                            🩺 Physical Examination <span class="text-danger">*</span>
                            <i class="bi bi-question-circle-fill text-primary ms-1"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Enter the patient's vital signs and any pertinent physical examination findings."></i>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">BP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control custom-input" placeholder="e.g. 120/80" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">HR <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control custom-input" placeholder="e.g. 80 bpm" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">RR <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control custom-input" placeholder="e.g. 20 cpm" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Temp (°C) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control custom-input" placeholder="e.g. 37.2" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">WT (kg) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control custom-input" placeholder="e.g. 70" required>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <label class="form-label fw-bold">
                                    Pertinent PE Findings (Objective) <span class="text-danger">*</span>
                                    <i class="bi bi-question-circle-fill text-primary ms-1"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Describe significant findings from the physical examination."></i>
                                    </label>
                                    <textarea class="form-control custom-input" rows="2" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>


            <!-- Modal Footer -->
            <div class="modal-footer">
                <!-- <button type="submit" class="btn btn-success px-4">Submit Referral</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> -->
                <!-- 🔹 Submit Referral -->
                <div class="card mt-4 shadow-sm">
                    <div class="card-body text-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary" id="submit-referral-btn">
                            <i class="bi bi-send-check me-1"></i> Submit Referral
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- 🔹 Custom Styling -->
<style>
  .custom-input {
    background-color: #f8f9fa;
    border-radius: 0.4rem;
    border: 1px solid #ced4da;
  }
  .custom-input:focus {
    background-color: #fff;
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
  }
</style>

<script>
  // enable all tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>
