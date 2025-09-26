<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div id="side-bar-title-bgh">
        <img src="../../assets/imgs/BGHMC logo hi-res.png" alt="logo-img">
        <p id="bgh-name">Bataan General Hospital and Medical Center</p>
    </div>

    <?php
        $permissions = $_SESSION['user']['permission'];
    ?>

    <ul class="sidebar-menu">
        <?php if (!empty($permissions['patient_registration'])): ?>
            <li><a href="../views/patient_registration_form.php">📄 <span>Patient Registration</span></a></li>
        <?php endif; ?>

        <?php if (!empty($permissions['incoming_referral'])): ?>
            <li><a href="../views/incoming_referral.php">📄 <span>Incoming Referral</span></a></li>
        <?php endif; ?>

        <?php if (!empty($permissions['outgoing_referral'])): ?>
            <li><a href="../views/outgoing_referral.php">📄 <span>Outgoing Referral</span></a></li>
        <?php endif; ?>

        <li><a href="../views/dashboard_incoming.php">📊 <span>Dashboard – Incoming Referral</span></a></li>
        <li><a href="#">📊 <span>Dashboard – Outgoing Referral</span></a></li>

        <?php if (!empty($permissions['admin_function'])): ?>
            <li><a href="../views/admin_module.php">🛠 <span>Admin Module</span></a></li>
        <?php endif; ?>

        <?php if (!empty($permissions['history_log'])): ?>
            <li><a href="#">📜 <span>History Log</span></a></li>
        <?php endif; ?>

        <?php if (!empty($permissions['setting'])): ?>
            <li><a href="#">⚙ <span>Settings</span></a></li>
        <?php endif; ?>

        <li><a href="#">📌 <span>Acknowledgements</span></a></li>
    </ul>


</div>
