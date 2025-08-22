
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <?php include("../links/header_link.php") ?>
    <link rel="stylesheet" href="../assets/css/patient_registration.css">

</head>
<body>

    <div class="left-container">
        <?php include('../views/sidebar.php') ?>
    </div>

    <div class="right-container">
        <h1>Patient Registration Form</h1>
        <form>

            <!-- Personal Information -->
            <fieldset>
                <legend>Personal Information</legend>
                <div class="form-row">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name">
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" name="middle_name">
                    </div>
                    <div class="form-group">
                        <label>Name Ext.</label>
                        <input type="text" name="name_ext">
                    </div>
                    <div class="form-group">
                        <label>Birthday</label>
                        <input type="date" name="birthday">
                    </div>
                    <div class="form-group">
                        <label>Age</label>
                        <input type="number" name="age">
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">Select</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Civil Status</label>
                        <select name="civil_status">
                            <option value="">Select</option>
                            <option>Single</option>
                            <option>Married</option>
                            <option>Widowed</option>
                            <option>Separated</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Religion</label>
                        <input type="text" name="religion" placeholder="e.g. Roman Catholic">
                    </div>
                    <div class="form-group">
                        <label>Occupation</label>
                        <input type="text" name="occupation" placeholder="e.g. Doctor">
                    </div>
                    <div class="form-group">
                        <label>Nationality</label>
                        <input type="text" name="nationality" placeholder="e.g. Filipino">
                    </div>
                    <div class="form-group">
                        <label>Passport No.</label>
                        <input type="text" name="passport_no">
                    </div>
                    <div class="form-group">
                        <label>Hospital No.</label>
                        <input type="text" name="hospital_no">
                    </div>
                    <div class="form-group">
                        <label>PHIC</label>
                        <input type="text" name="phic">
                    </div>
                </div>
            </fieldset>

           <!-- Permanent Address -->
            <fieldset>
                <legend>Permanent Address</legend>
                <div class="form-row">
                    <div class="form-group">
                        <label>House No./Lot/Bldg</label>
                        <input type="text" name="perm_house_no" placeholder="Lot 1">
                    </div>
                    <div class="form-group">
                        <label>Street/Block</label>
                        <input type="text" name="perm_street" placeholder="Block 1">
                    </div>
                    <div class="form-group">
                        <label>Region</label>
                        <select name="perm_region">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Province</label>
                        <select name="perm_province">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Municipality / City</label>
                        <select name="perm_city">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Barangay</label>
                        <select name="perm_barangay">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Home Phone No.</label>
                        <input type="text" name="perm_phone">
                    </div>
                    <div class="form-group">
                        <label>Mobile Phone No.</label>
                        <input type="text" name="perm_mobile">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="perm_email">
                    </div>
                </div>
            </fieldset>

            <!-- Current Address -->
            <fieldset>
                <legend>Current Address</legend>
                <div class="form-row">
                    <div class="form-group">
                        <label><input type="checkbox" name="same_as_permanent"> Same as permanent</label>
                    </div>
                    <div class="form-group">
                        <label>House No./Lot/Bldg</label>
                        <input type="text" name="curr_house_no" placeholder="Lot 1">
                    </div>
                    <div class="form-group">
                        <label>Street/Block</label>
                        <input type="text" name="curr_street" placeholder="Block 1">
                    </div>
                    <div class="form-group">
                        <label>Region</label>
                        <select name="curr_region">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Province</label>
                        <select name="curr_province">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Municipality / City</label>
                        <select name="curr_city">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Barangay</label>
                        <select name="curr_barangay">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Home Phone No.</label>
                        <input type="text" name="curr_phone">
                    </div>
                    <div class="form-group">
                        <label>Mobile Phone No.</label>
                        <input type="text" name="curr_mobile">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="curr_email">
                    </div>
                </div>
            </fieldset>

            <!-- Current Workplace Address -->
            <fieldset>
                <legend>Current Workplace Address</legend>
                <div class="form-row">
                    <div class="form-group">
                        <label>House No./Lot/Bldg</label>
                        <input type="text" name="work_house_no">
                    </div>
                    <div class="form-group">
                        <label>Street/Block</label>
                        <input type="text" name="work_street">
                    </div>
                    <div class="form-group">
                        <label>Region</label>
                        <select name="work_region">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Province</label>
                        <select name="work_province">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Municipality / City</label>
                        <select name="work_city">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Barangay</label>
                        <select name="work_barangay">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name of Workplace</label>
                        <input type="text" name="work_name">
                    </div>
                    <div class="form-group">
                        <label>Landline/Mobile No.</label>
                        <input type="text" name="work_contact">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="work_email">
                    </div>
                </div>
            </fieldset>

            <!-- Address Outside the Philippines (For OFW only) -->
            <fieldset>
                <legend>Address Outside the Philippines (For OFW only)</legend>
                <div class="form-row">
                    <div class="form-group">
                        <label>Employer's Name</label>
                        <input type="text" name="ofw_employer">
                    </div>
                    <div class="form-group">
                        <label>Occupation</label>
                        <input type="text" name="ofw_occupation">
                    </div>
                    <div class="form-group">
                        <label>Place of Work</label>
                        <input type="text" name="ofw_place">
                    </div>
                    <div class="form-group">
                        <label>House No./Lot/Bldg</label>
                        <input type="text" name="ofw_house_no">
                    </div>
                    <div class="form-group">
                        <label>Street/Block</label>
                        <input type="text" name="ofw_street">
                    </div>
                    <div class="form-group">
                        <label>Region</label>
                        <input type="text" name="ofw_region">
                    </div>
                    <div class="form-group">
                        <label>Province</label>
                        <input type="text" name="ofw_province">
                    </div>
                    <div class="form-group">
                        <label>Municipality / City</label>
                        <input type="text" name="ofw_city">
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" name="ofw_country">
                    </div>
                    <div class="form-group">
                        <label>Office Phone No.</label>
                        <input type="text" name="ofw_office_phone">
                    </div>
                    <div class="form-group">
                        <label>Mobile Phone No.</label>
                        <input type="text" name="ofw_mobile">
                    </div>
                </div>
            </fieldset>

            <!-- More fieldsets go here following same .form-row style -->

            <button type="submit">Submit</button>
        </form>
    </div>

    <?php include("../links/script_links.php") ?>
</body>
</html>
