<?php 
    session_start();
    date_default_timezone_set('Asia/Manila');
    $currentDate = date("F d, Y h:i A");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Incoming</title>
    <?php include("../links/header_link.php") ?>

    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/dashboard_incoming.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    
    <!-- Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <div class="left-container">
        <?php include('../views/sidebar.php') ?>
    </div>

    <div class="right-container">
        <?php include('../views/navbar.php') ?>

        <!-- <button id="darkModeToggle" class="btn btn-sm btn-secondary">
            🌙 Dark Mode
        </button> -->

        <div class="dashboard-content">
            <!-- Title -->
            <div class="dashboard-header">
                <h2>📊 Dashboard Incoming</h2>
                <p><?= $currentDate ?></p>
            </div>

            <!-- Filters -->
            <div class="filter-section">
                <h3>Filters</h3>
                <form id="filterForm">
                    <label>Start Date:</label>
                    <input type="date" name="start_date">
                    <label>End Date:</label>
                    <input type="date" name="end_date">

                    <label>Case Type:</label>
                    <select name="case_type">
                        <option value="">All</option>
                        <option value="ER">ER</option>
                        <option value="OB">OB</option>
                        <option value="OPD">OPD</option>
                        <option value="TOX">Toxicology</option>
                        <option value="PCR">PCR</option>
                        <option value="CANCER">Cancer</option>
                        <option value="NBSCC">NBSCC</option>
                    </select>

                    <label>Referring Health Unit:</label>
                    <select id="rhu-select" name="rhu">
                        <option value="">All</option>
                        <!-- Dynamically populate RHU + Local Hospitals -->
                    </select>

                    <button type="submit">Apply</button>
                </form>
            </div>

            <!-- Averages -->
            <div class="averages-section">
                <div class="card">Total Processed Referrals: <span id="totalReferrals">0</span></div>
                <div class="card">Average Reception Time: <span id="avgReception">--</span></div>
                <div class="card">Average Approval Time: <span id="avgApproval">--</span></div>
                <div class="card">Fastest Response Time: <span id="fastestResponse">--</span></div>
                <div class="card">Slowest Response Time: <span id="slowestResponse">--</span></div>
            </div>

            <!-- Charts -->
            <div class="charts-section">
                <div id="chart-case-category" style="height: 400px; margin-bottom: 30px;"></div>
                <div id="chart-case-type" style="height: 400px; margin-bottom: 30px;"></div>
                <div id="chart-referring-facility" style="height: 400px;"></div>
            </div>


            <!-- ICD Reports -->
            <div class="icd-section">
                <h3>Top 10 ICD Diagnosis</h3>
                <div id="icdChart"></div>

                <table id="icdTable">
                    <thead>
                        <tr>
                            <th>ICD Code</th>
                            <th>ICD Title</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filled dynamically , this is going to be datatable please-->
                    </tbody>
                </table>
            </div>

            <!-- RHU Data Table -->
            <div class="rhu-table-section">
                <h3>Referring Health Facility Summary</h3>
                <table id="rhuTable">
                    <thead>
                        <tr>
                            <th>Referring Health Facility</th>
                            <th colspan="3">ER</th>
                            <th colspan="3">OB</th>
                            <th colspan="3">PCR</th>
                            <th colspan="3">Toxicology</th>
                            <th colspan="3">Cancer</th>
                            <th colspan="3">OPD</th>
                            <th>Total</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Primary</th><th>Secondary</th><th>Tertiary</th>
                            <th>Primary</th><th>Secondary</th><th>Tertiary</th>
                            <th>Primary</th><th>Secondary</th><th>Tertiary</th>
                            <th>Primary</th><th>Secondary</th><th>Tertiary</th>
                            <th>Primary</th><th>Secondary</th><th>Tertiary</th>
                            <th>Primary</th><th>Secondary</th><th>Tertiary</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filled dynamically -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <?php include("../links/script_links.php") ?>
    <script src="../assets/websocket/script.js?v=<?php echo time(); ?>"></script>
    <script src="../assets/js/sidebar_traverse.js"></script>
    <script src="../assets/js/dashboard_incoming/dashboard_incoming.js"></script>

</body>
</html>
