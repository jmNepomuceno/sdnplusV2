<div class="navbar">
    <h2>Patient Registration</h2>
    <div class="nav-links">
        <span class="notification">
            <i class="fa-solid fa-bell"></i>
        </span>
        <div class="user-info">
            <i class="fa-solid fa-user"></i>
            <?php echo $_SESSION['user']['hospital_name']; ?> | 
            <?php echo $_SESSION['user']['fullname']; ?>
            <i class="fa-solid fa-caret-down"></i>

            <!-- Dropdown for Logout -->
            <div class="user-dropdown">
                <a href="../logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </div>
    </div>
</div>
