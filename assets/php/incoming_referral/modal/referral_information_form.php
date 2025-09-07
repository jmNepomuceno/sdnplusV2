<div class="modal fade custom-modal-size" id="patient-referral-modal" tabindex="-1" role="dialog"
     aria-labelledby="referralLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-3">

      <!-- Header -->
      <div class="modal-header bg-dark text-white align-items-center">
        <h5 class="modal-title" id="referralLabel">🏥 Patient Referral Information</h5>
        <button type="button" class="btn btn-success btn-sm me-3" id="proceed-to-response">
          Proceed to Referral Response
        </button>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- Top badges / summary -->
        <div class="row g-3 mb-3">
          <div class="col-md-3">
            <div class="ref-field">
              <label>Patient ID:</label>
              <div class="badge bg-success w-100 py-2" id="pf-patient-id">—</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="ref-field">
              <label>Case Number:</label>
              <div class="badge bg-success w-100 py-2" id="pf-case-no">—</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="ref-field">
              <label>Referral Status:</label>
              <div class="badge bg-success w-100 py-2" id="pf-ref-status">—</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="ref-field">
              <label>Age:</label>
              <div id="pf-age">—</div>
            </div>
          </div>
        </div>

        <!-- Meta (right column summary like in screenshot) -->
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <div class="ref-table">
              <div class="ref-row">
                <div class="ref-label">Referring Agency:</div>
                <div class="ref-value" id="pf-agency">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Referred By:</div>
                <div class="ref-value" id="pf-referred-by">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Mobile Number:</div>
                <div class="ref-value" id="pf-mobile">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Last Name:</div>
                <div class="ref-value" id="pf-lastname">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">First Name:</div>
                <div class="ref-value" id="pf-firstname">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Middle Name:</div>
                <div class="ref-value" id="pf-middlename">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Extension Name:</div>
                <div class="ref-value" id="pf-ext">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Gender:</div>
                <div class="ref-value" id="pf-gender">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Civil Status:</div>
                <div class="ref-value" id="pf-civil">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Religion:</div>
                <div class="ref-value" id="pf-religion">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Contact No.:</div>
                <div class="ref-value" id="pf-contact">—</div>
              </div>
            </div>
          </div>

          <div class="col-md-8">
            <div class="ref-table">
              <div class="ref-row">
                <div class="ref-label">Select Response Status:</div>
                <div class="ref-value">
                  <span class="badge bg-success" id="pf-selected-status">Approved</span>
                </div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Process Date/Time:</div>
                <div class="ref-value" id="pf-process-dt">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Processed By:</div>
                <div class="ref-value" id="pf-processed-by">—</div>
              </div>
            </div>

            <div class="section-heading mt-3">ICD-10 Diagnosis</div>
            <div class="p-3 border rounded">
              <span class="fw-bold text-warning" id="pf-icd-code">—</span>
              <span class="fw-bold ms-2 text-primary" id="pf-icd-desc">—</span>
            </div>

            <div class="mt-3">
              <label class="fw-bold small text-muted">SUBJECTIVE:</label>
              <div class="ref-box" id="pf-subjective">—</div>
            </div>
            <div class="mt-3">
              <label class="fw-bold small text-muted">OBJECTIVE:</label>
              <div class="ref-box" id="pf-objective">—</div>
            </div>
          </div>
        </div>

        <!-- ===== Second screenshot content ===== -->

        <div class="row g-3">
          <!-- Physical Examination (left) -->
          <div class="col-md-5">
            <div class="section-heading">Physical Examination</div>
            <div class="ref-table">
              <div class="ref-row">
                <div class="ref-label">Blood Pressure:</div>
                <div class="ref-value" id="pf-bp">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Heart Rate (HR):</div>
                <div class="ref-value" id="pf-hr">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Respiratory Rate (RR):</div>
                <div class="ref-value" id="pf-rr">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Body Temperature:</div>
                <div class="ref-value" id="pf-temp">—</div>
              </div>
              <div class="ref-row">
                <div class="ref-label">Weight:</div>
                <div class="ref-value" id="pf-weight">—</div>
              </div>
            </div>
          </div>

          <!-- Assessment / Plan / Remarks (right) -->
          <div class="col-md-7">
            <div class="mb-3">
              <label class="fw-bold small text-muted">ASSESSMENT:</label>
              <div class="ref-box" id="pf-assessment">—</div>
            </div>
            <div class="mb-3">
              <label class="fw-bold small text-muted">PLAN:</label>
              <div class="ref-box" id="pf-plan">—</div>
            </div>
            <div class="mb-3">
              <label class="fw-bold small text-muted">REMARKS:</label>
              <div class="ref-box" id="pf-remarks">—</div>
            </div>
          </div>
        </div>

        <!-- Approval Details -->
        <div class="mt-3">
          <div class="section-heading">Approval Details</div>
          <div class="ref-table">
            <div class="ref-row">
              <div class="ref-label">Case Category:</div>
              <div class="ref-value" id="pf-case-category">—</div>
              <div class="ref-label w-25">Update Status:</div>
              <div class="ref-value">
                <div class="d-flex align-items-center gap-2">
                  <select class="form-select form-select-sm w-auto" id="pf-update-status">
                    <option value="Pending">Status</option>
                    <option value="Approved">Approved</option>
                    <option value="Deferred">Deferred</option>
                    <option value="Cancelled">Cancelled</option>
                  </select>
                  <button class="btn btn-success btn-sm" id="pf-update-confirm">
                    <i class="bi bi-check-lg"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="ref-row">
              <div class="ref-label">Emergency Room Administrator Action:</div>
              <div class="ref-value" id="pf-admin-action">—</div>
            </div>
          </div>
        </div>

      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <div class="card mt-2 shadow-sm w-100">
          <div class="card-body text-end">
            <button class="btn btn-primary" id="pf-print"><i class="bi bi-printer me-1"></i> Print</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle me-1"></i> Close</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
