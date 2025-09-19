<?php 
    include("../assets/connection/connection.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incoming Referral</title>
    <?php include("../links/header_link.php") ?>

    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/outgoing_referral.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/modal/referral_information_form.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <div class="left-container">
        <?php include('../views/sidebar.php') ?>
    </div>

    <div class="right-container">
        <!-- Top Navbar inside right-container -->
        <?php include('../views/navbar.php') ?>

        <div class="incoming-referral-container">
            <!-- 🔹 Filter/Search Section -->
            <div class="filter-section card">
                <h3>Filter Referrals</h3>
                <form class="filter-form" id="referral-search-form">
                    <div class="form-row">
                        <input type="text" class="form-control" id="referral_no" name="referral_no" placeholder="Referral No." autocomplete="off">
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" autocomplete="off">
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" autocomplete="off">
                        <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" autocomplete="off">
                    </div>
                    
                    <div class="form-row">
                        <!-- Case Type populated dynamically -->
                        <select class="form-control" id="case_type" name="case_type">
                            <option value="">Select Case Type</option>
                        </select>

                        <!-- Agency populated dynamically -->
                        <select class="form-control" id="agency" name="agency">
                            <option value="">Select Agency</option>
                        </select>

                        <!-- Start/End Date -->
                        <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Start Date" onfocus="(this.type='date')" autocomplete="off">
                        <input type="text" class="form-control" id="end_date" name="end_date" placeholder="End Date" onfocus="(this.type='date')" autocomplete="off">

                    </div>

                    <div class="form-row">
                        <select class="form-control" id="tat_filter" name="tat_filter">
                            <option value="">Turnaround Time</option>
                            <option value="true">≥ 15 minutes (greater than or equal to 15)</option>
                            <option value="false">< 15 minutes (less than 15)</option>
                        </select>
                        
                        <select class="form-control" id="sensitive_case" name="sensitive_case">
                            <option value="">Sensitive Case</option>
                            <option value="true">Yes</option>
                            <option value="false">No</option>
                        </select>

                        <select class="form-control" id="status" name="status">
                            <option value="">Status</option>
                            <option value="all">All</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="deferred">Deferred</option>
                            <option value="cancelled">Cancelled</option>
                        </select>

                    </div>

                    <div class="form-row form-actions">
                        <button type="submit" class="btn btn-primary" id="search-filter-btn">Search</button>
                        <button type="reset" class="btn btn-secondary">Clear</button>
                    </div>
                </form>



            </div>

            <!-- 🔹 DataTable Section -->
            <div class="table-section card">
                <div class="table-responsive">
                    <table id="outgoingReferralsTable" class="table table-striped table-bordered referral-table">
                        <thead>
                            <tr>
                                <th>Reference No.</th>
                                <th>Patient's Name</th>
                                <th>Type</th>
                                <th>Agency</th>
                                <th>Date/Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include("../links/script_links.php") ?>

    <?php include("../assets/php/incoming_referral/modal/referral_information_form.php") ?>

    <script src="../assets/websocket/script.js?v=<?php echo time(); ?>"></script>


    <script src="../assets/js/sidebar_traverse.js"></script>
    <script src="../assets/js/outgoing_referral/outgoing_referral.js?v=<?php echo time(); ?>"></script>
    <script src="../assets/js/modal/referral_information_form.js?v=<?php echo time(); ?>"></script>
    <script src="../assets/js/modal/referral_search.js?v=<?php echo time(); ?>"></script>
</body>
</html>
