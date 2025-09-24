<!-- ===============================
     📌 VIEW HOSPITALS MODAL
==================================-->
<div class="modal fade" id="hospitals-modal" tabindex="-1" role="dialog" aria-labelledby="hospitalsLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered custom-modal-view-hospitals">
        <div class="modal-content shadow-lg rounded-3">

            <!-- 🔹 Modal Header -->
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="hospitalsLabel">🏥 Registered RHU & Local Hospitals</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- 🔹 Modal Body -->
            <div class="modal-body">

                <!-- 🔹 Hospitals Table -->
                <div id="hospitals-list" class="mt-3">
                    <table id="hospitals-table" class="table table-striped table-bordered table-sm w-100">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 15%;">Hospital Name</th>
                                <th style="width: 10%;">Hospital Code</th>
                                <th style="width: 6%;">Verified</th>
                                <th style="width: 8%;">No. of Users</th>
                                <th style="width: 15%;">Contact Information</th>
                                <th style="width: 12%;">Hospital Director</th>
                                <th style="width: 10%;">Director Mobile</th>
                                <th style="width: 12%;">Point Person</th>
                                <th style="width: 10%;">Point Person Mobile</th>
                                <th style="width: 8%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Populated dynamically via AJAX -->
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- 🔹 Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
