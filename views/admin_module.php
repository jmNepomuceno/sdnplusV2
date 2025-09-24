<?php 
    session_start();
    date_default_timezone_set('Asia/Manila');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <?php include("../links/header_link.php") ?>

    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/admin_module.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/modal/user_accessibility.css">
    <link rel="stylesheet" href="../assets/css/modal/view_hospitals.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <div class="left-container">
        <?php include('../views/sidebar.php') ?>
    </div>

    <div class="right-container">
        <!-- Top Navbar inside right-container -->
        <?php include('../views/navbar.php') ?>
        
        <div class="admin-dashboard p-4">
            <h2 class="mb-4">Admin Dashboard</h2>
            <div class="row g-4">
                <!-- User Accessibility -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fa fa-users fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">User Accessibility</h5>
                            <p class="card-text">
                                Manage accounts of doctors and users. Assign permissions and access rights.
                            </p>
                            <button class="btn btn-primary w-100 go-user-access">
                                Manage Users
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Add Patient's Classification -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fa fa-tags fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Patient's Classification</h5>
                            <p class="card-text">
                                Add, edit, or delete referral classifications for patient referrals.
                            </p>
                            <button class="btn btn-success w-100 go-classification">
                                Manage Classifications
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hospitals and Users -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fa fa-hospital fa-3x text-danger mb-3"></i>
                            <h5 class="card-title">Hospitals & Users</h5>
                            <p class="card-text">
                                View all registered hospitals and RHUs, including associated users.
                            </p>
                            <button class="btn btn-danger w-100 go-hospitals">
                                View Hospitals
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include("../assets/php/admin_module/user_accessibility/user_accessibility_mod.php") ?>
    <?php include("../assets/php/admin_module/patient_classification/patient_classification_mod.php") ?>
    <?php include("../assets/php/admin_module/view_hospitals/view_hospitals_mod.php") ?>

    <?php include("../links/script_links.php") ?>
    <script src="../assets/websocket/script.js?v=<?php echo time(); ?>"></script>
    
    <script src="../assets/js/sidebar_traverse.js"></script>
    <script src="../assets/js/admin_module/admin_module.js"></script>
    <script src="../assets/js/admin_module/user_accessibility.js"></script>
    <script src="../assets/js/admin_module/patient_classification.js"></script>
    <script src="../assets/js/admin_module/view_hospitals.js"></script>
</body>
</html>
