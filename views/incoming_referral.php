<?php 
    include("../assets/connection/connection.php");
    session_start();

    // $sql = "UPDATE incoming_referrals SET status='Pending', reception_time=null, final_progressed_timer=null, approved_time=null, approval_details=null, status_interdept=null, sent_interdept_time=null, last_update=null, pat_class=null WHERE referral_id='REF002944'";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute();

    // $sql = "UPDATE incoming_referrals SET status='Pending', reception_time=null, final_progressed_timer=null, approved_time=null, approval_details=null, status_interdept=null, sent_interdept_time=null, last_update=null, pat_class=null WHERE referral_id='REF002943'";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute();

    // $sql = "UPDATE incoming_referrals SET status='Pending', reception_time=null, final_progressed_timer=null, approved_time=null, approval_details=null, status_interdept=null, sent_interdept_time=null, last_update=null, pat_class=null WHERE referral_id='REF002942'";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute();

    // $sql = "UPDATE hperson SET status=null, referral_id=null, type=null WHERE referral_id='REF002944'";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute();

    // $sql = "UPDATE hperson SET status=null, referral_id=null, type=null WHERE referral_id='REF002943'";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute();

    // $sql = "UPDATE hperson SET status=null, referral_id=null, type=null WHERE referral_id='REF002942'";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incoming Referral</title>
    <?php include("../links/header_link.php") ?>

    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/incoming_referral.css">
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
                        <input type="text" class="form-control" id="referral_no" name="referral_no" placeholder="Referral No.">
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                        <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name">
                    </div>
                    
                    <div class="form-row">
                        <select class="form-control" id="case_type" name="case_type">
                            <option value="">Case Type</option>
                            <option value="emergency">Emergency</option>
                            <option value="non-emergency">Non-Emergency</option>
                        </select>
                        <input type="text" class="form-control" id="agency" name="agency" placeholder="Agency">
                        <input type="date" class="form-control" id="start_date" name="start_date">
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>

                    <div class="form-row">
                        <input type="text" class="form-control" id="tat_filter" name="tat_filter" placeholder="Turnaround Time Filter">
                        <select class="form-control" id="sensitive_case" name="sensitive_case">
                            <option value="">Sensitive Case</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                        <select class="form-control" id="status" name="status">
                            <option value="">Status</option>
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
                    <table id="incomingReferralsTable" class="table table-striped table-bordered referral-table">
                        <thead>
                            <tr>
                                <th>Reference No.</th>
                                <th>Patient's Name</th>
                                <th>Type</th>
                                <th>Agency</th>
                                <th>Date/Time</th>
                                <th>Response Time</th>
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
    <script src="../assets/js/incoming_referral/incoming_referral.js?v=<?php echo time(); ?>"></script>
    <script src="../assets/js/modal/referral_information_form.js?v=<?php echo time(); ?>"></script>
    <script src="../assets/js/modal/referral_search.js?v=<?php echo time(); ?>"></script>
</body>
</html>
