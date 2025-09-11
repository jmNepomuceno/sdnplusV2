<div class="modal fade custom-modal-size" id="patient-referral-modal" tabindex="-1" role="dialog" aria-labelledby="referralLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xxl modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-3">

        <!-- Modal Header -->
        <div class="modal-header bg-dark text-white">
            <h5 class="modal-title" id="referralLabel">🏥 Referral Form</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body" id="referral-modal-body">
            <div class="referral-main-body">
                <div class="left-side">
                    <div class="header-row-div">PATIENT INFORMATION</div>

                    <div class="left-row-div">
                        <span class="title-span-form">Patient ID: </span>
                        <span class="value-span-form" id="hpercode-span"><b>PAT000056</b></span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Referral Status: </span>
                        <span class="value-span-form" id="status-span"><b>APPROVED</b></span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Referring Agency: </span>
                        <span class="value-span-form" id="referred-by-span">MARIVELES NATIONAL HOSPITAL</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Referred By: </span>
                        <span class="value-span-form" id="referred-by-span">PAT000056</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Mobile Number: </span>
                        <span class="value-span-form" id="doc-mobile-no-span">0919-6044-820</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Last Name: </span>
                        <span class="value-span-form" id="patlast-span">Nepomuceno</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">First Name: </span>
                        <span class="value-span-form" id="patfirst-span">John Marvin</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Middle Name: </span>
                        <span class="value-span-form" id="patmiddle-span">Gomez</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Extension Name: </span>
                        <span class="value-span-form" id="patsuffix-span">N/A</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Age: </span>
                        <span class="value-span-form" id="pat-age-span">13</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Gender: </span>
                        <span class="value-span-form" id="pat-gender-span">Male</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Civil Status: </span>
                        <span class="value-span-form" id="pat-civil-status-span">Single</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Religion: </span>
                        <span class="value-span-form" id="pat-religion-span">Roman Catholic</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Contact No.: </span>
                        <span class="value-span-form" id="pat-mobile-no-span">0919-6044-820</span>
                    </div>

                    <div class="header-row-div">PHYSICAL EXAMINATION</div>

                    <div class="left-row-div">
                        <span class="title-span-form">Blood Pressure: </span>
                        <span class="value-span-form" id="bp-span">PAT000056</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Heart Rate (HR): </span>
                        <span class="value-span-form" id="hr-span">PAT000056</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Respiratory Rate (RR): </span>
                        <span class="value-span-form" id="rr-span">PAT000056</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Body Temperature: </span>
                        <span class="value-span-form" id="temp-span">PAT000056</span>
                    </div>

                    <div class="left-row-div">
                        <span class="title-span-form">Weight: </span>
                        <span class="value-span-form" id="weight-span">PAT000056</span>
                    </div>
                </div>

                <div class="right-side">
                    <div class="header-row-div">REFERRAL INFORMATION</div>

                    <div class="right-row-div">
                        <div class="right-row-div-a">
                            <span class="title-span-form">Case Number: </span>
                            <span class="value-span-form" id="ref-id-span"><b>REF000056</b></span>
                        </div>
                        <div class="right-row-div-b">
                            <span class="title-span-form">Select Response Status: </span>
                            <!-- <span class="value-span-form">2025-08-04 09:41:49</span> -->
                            <section>
                                <select class="form-control" id="select-response-status">
                                    <option value=""></option>
                                    <option value="Approved">Approve</option>
                                    <option value="Deferred">Defer</option> 
                                    <option value="Interdepartamental" disabled>Interdepartamental Referral</option>
                                </select>
                            </section>
                        </div>
                    </div>

                    <div class="right-row-div">
                        <div class="right-row-div-a">
                            <span class="title-span-form">Process Date/Time: </span>
                            <span class="value-span-form" id="reception-time-span">REF000056</span>
                        </div>
                        <div class="right-row-div-b">
                            <span class="title-span-form">Processed By: </span>
                            <span class="value-span-form" id="processed-by-span">2025-08-04 09:41:49</span>
                        </div>
                    </div>

                    <div class="header-row-div">DIAGNOSIS</div>

                    <div class="right-row-div-textarea">
                        <span class="title-span-form">ICD-10 Diagnosis</span>
                        <textarea class="value-textarea-form" id="icd-diagnosis-span">A04 : Other bacterial intestinal infections</textarea>
                    </div>

                    <div class="right-row-div-textarea">
                        <span class="title-span-form">Subjective</span>
                        <textarea class="value-textarea-form" id="subjective-span">Test</textarea>
                    </div>

                    <div class="right-row-div-textarea">
                        <span class="title-span-form">Objective</span>
                        <textarea class="value-textarea-form" id="objective-span">Test</textarea>
                    </div>

                    <div class="right-row-div-textarea">
                        <span class="title-span-form">Assessment</span>
                        <textarea class="value-textarea-form" id="assessment-span">Test</textarea>
                    </div>

                    <div class="right-row-div-textarea">
                        <span class="title-span-form">Plan</span>
                        <textarea class="value-textarea-form" id="plan-span">Test</textarea>
                    </div>

                    <div class="right-row-div-textarea">
                        <span class="title-span-form">Remarks</span>
                        <textarea class="value-textarea-form" id="patlast-span">Test</textarea>
                    </div>
                    
                </div>
            </div>

            <div class="card shadow-sm border-0 approval-form-div">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0" id="approval-deferral-form-title">Approval Form</h6>
                </div>

                <div class="card-body bg-light">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Case Category</label>
                        <select class="form-select" id="category-approval-select">
                            <option value="">Select</option>
                            <option value="Primary">Primary</option>
                            <option value="Secondary">Secondary</option>
                            <option value="Tertiary">Tertiary</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Emergency Room Administrator Action</label>
                        <textarea id="er-action" class="form-control" rows="5"></textarea>
                    </div>

                    <div class="mt-3 small preemptive-text">
                        <p class="mb-1 text-primary selectable">+ May transfer patient once stable.</p>
                        <p class="mb-1 text-primary selectable">+ Please attach imaging and laboratory results to the referral letter.</p>
                        <p class="mb-1 text-primary selectable">+ Hook to oxygen support and maintain saturation at >95%.</p>
                        <p class="mb-1 text-primary selectable">+ Start venoclysis with appropriate intravenous fluids.</p>
                        <p class="mb-1 text-primary selectable">+ Insert nasogastric tube (NGT).</p>
                        <p class="mb-1 text-primary selectable">+ Insert indwelling foley catheter (IFC).</p>
                        <p class="mb-1 text-primary selectable">+ Thank you for your referral.</p>
                    </div>
                </div>

                <div class="card-footer text-end bg-light">
                    <button type="button" class="btn btn-success px-4" id="approve-deferred-submit-btn">Approve</button>
                </div>
            </div>

        </div>

        <!-- Modal Footer -->
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
