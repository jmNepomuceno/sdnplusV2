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
            <!-- Sensitive Case -->
            <div class="row" id="critical-section">
                <!-- Sensitive Case -->
                <div class="col-md-4" id="sensitive-case-section">
                    <label class="form-label fw-bold text-danger">
                        Sensitive Case <span class="text-danger">*</span>
                        <i class="bi bi-question-circle-fill text-primary" 
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="Mark 'Yes' if this is a sensitive case (e.g. assault, abuse, etc.)">
                        </i>
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
                    <label class="form-label fw-bold">ICD-10 Diagnosis</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="icdCode" placeholder="Enter ICD-10 Code">
                        <input type="text" class="form-control" id="icdTitle" placeholder="Enter ICD-10 Title">
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
              <label class="form-label">Registered at RHU / Hospital</label>
              <select class="form-select custom-input">
                <option selected disabled>Select RHU</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Referring Doctor</label>
              <select class="form-select custom-input">
                <option selected disabled>Select Doctor</option>
              </select>
            </div>burat
          </div>

          <div class="row g-3 mt-2">
            <div class="col-md-3">
                <label class="form-label">Parent/Guardian (if minor)</label>
                <input type="text" class="form-control custom-input">
            </div>
            <div class="col-md-3">
                <label class="form-label">PHIC Member</label>
                <select class="form-select custom-input">
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Mode of Transport</label>
                <select class="form-select custom-input">
                <option>Ambulance</option>
                <option>Private Car</option>
                <option>Commute</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date/Time Admitted</label>
                <input type="datetime-local" class="form-control custom-input" value="<?php echo date('Y-m-d\TH:i'); ?>" readonly>
            </div>
          </div>

          <!-- 🔹 Textareas -->
          <div class="mt-4">
            <label class="form-label fw-bold">Chief Complaint & History (Subjective)</label>
            <textarea class="form-control custom-input" rows="2"></textarea>
          </div>

          <div class="mt-3">
            <label class="form-label fw-bold">Reason for Referral (Plan)</label>
            <textarea class="form-control custom-input" rows="2"></textarea>
          </div>

          <div class="mt-3">
            <label class="form-label fw-bold">Diagnosis (Assessment)</label>
            <textarea class="form-control custom-input" rows="2"></textarea>
          </div>

          <div class="mt-3">
            <label class="form-label fw-bold">Remarks</label>
            <textarea class="form-control custom-input" rows="2"></textarea>
          </div>

          <!-- 🔹 Physical Examination -->
          <div class="card mt-4 shadow-sm">
            <div class="card-header bg-light fw-bold">🩺 Physical Examination</div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-2"><input type="text" class="form-control custom-input" placeholder="BP"></div>
                <div class="col-md-2"><input type="text" class="form-control custom-input" placeholder="HR"></div>
                <div class="col-md-2"><input type="text" class="form-control custom-input" placeholder="RR"></div>
                <div class="col-md-2"><input type="text" class="form-control custom-input" placeholder="Temp (°C)"></div>
                <div class="col-md-2"><input type="text" class="form-control custom-input" placeholder="WT (kg)"></div>
                <div class="col-md-12 mt-2">
                  <textarea class="form-control custom-input" rows="2" placeholder="Pertinent PE Findings (Objective)"></textarea>
                </div>
              </div>
            </div>
          </div>

        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success px-4">Submit Referral</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
