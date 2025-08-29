
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
        
        <div class="function-div d-flex justify-content-between align-items-center">
            <div class="left-buttons d-flex align-items-center gap-2">
                <select id="classification-select" class="form-select d-none">
                    <option value="">-- Select Classification --</option>
                </select>
                <button type="button" class="btn btn-primary" id="add-patient-btn">Add</button>
                <button type="button" class="btn btn-danger" id="clear-patient-btn">Clear</button>
            </div>

            <div class="right-buttons d-flex align-items-center gap-2">
                <!-- ✅ New Add Referring Doctor button -->
                <button type="button" class="btn btn-warning" id="add-referring-doctor-btn">
                    <i class="bi bi-person-plus-fill"></i> Add Referring Doctor
                </button>
                
                <button type="button" class="btn btn-success" id="search-patient-btn">
                    <i class="bi bi-search"></i> Search Patient
                </button>
            </div>
        </div>


        <div class="form-container">
            <fieldset class="personal-info">
                <legend>Personal Information</legend>

                <div class="form-row">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input id="last-name-txt" type="text" name="last_name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input id="first-name-txt" type="text" name="first_name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input id="middle-name-txt" type="text" name="middle_name" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label>Name Ext.</label>
                        <select id="extension-name-select" name="name_ext">
                            <option value="">Select</option>
                            <option value="Jr.">Jr.</option>
                            <option value="Sr.">Sr.</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Birthday</label>
                        <input id="birthday-txt" type="date" name="birthday" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Age</label>
                        <input id="age-txt" type="number" name="age" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select id="gender-select" name="gender">
                            <option value="">Select</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Civil Status</label>
                        <select id="civil-status-select" name="civil_status">
                            <option value="">Select</option>
                            <option>Single</option>
                            <option>Married</option>
                            <option>Widowed</option>
                            <option>Separated</option>
                        </select>
                    </div>

                     <div class="form-group">
                        <label>Religion</label>
                        <input id="religion-txt" type="text" name="religion" placeholder="e.g. Roman Catholic" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Occupation</label>
                        <input id="occupation-txt" type="text" name="occupation" placeholder="e.g. Doctor" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Nationality</label>
                        <input id="nationality-txt" type="text" name="nationality" placeholder="e.g. Filipino" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Passport No.</label>
                        <input id="passport-no-txt" type="text" name="passport_no" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label>Hospital No.</label>
                        <input id="hospital-no-txt" type="text" name="hospital_no" autocomplete="off" value="1111">
                    </div>
                    <div class="form-group">
                        <label>PHIC</label>
                        <input id="phic-txt" type="text" name="phic" autocomplete="off">
                    </div>
                </div>

               
            </fieldset>


            <div class="address-grid">
                <fieldset>
                    <legend>Permanent Address</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label>House No./Lot/Bldg</label>
                            <input id="house-no-txt-pa" type="text" name="perm_house_no" placeholder="Lot 1" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Street/Block</label>
                            <input id="street-txt-pa" type="text" name="perm_street" placeholder="Block 1" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Region</label>
                            <select id="region-select-pa" name="perm_region">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Province</label>
                            <select id="province-select-pa" name="perm_province">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Municipality / City</label>
                            <select id="city-select-pa" name="perm_city">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Barangay</label>
                            <select id="barangay-select-pa" name="perm_barangay">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Home Phone No.</label>
                            <input id="phone-no-txt-pa" type="text" name="perm_phone" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Mobile Phone No.</label>
                            <input id="mobile-no-txt-pa" type="text" name="perm_mobile" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input id="email-txt-pa" type="email" name="perm_email" autocomplete="off">
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Current Workplace Address</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label>House No./Lot/Bldg</label>
                            <input id="house-no-txt-cwa" type="text" name="work_house_no" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Street/Block</label>
                            <input id="street-txt-cwa" type="text" name="work_street" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Region</label>
                            <select id="region-select-cwa" name="work_region">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Province</label>
                            <select id="province-select-cwa" name="work_province">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Municipality / City</label>
                            <select id="city-select-cwa" name="work_city">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Barangay</label>
                            <select id="barangay-select-cwa" name="work_barangay">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Name of Workplace</label>
                            <input id="workplace-txt-cwa" type="text" name="work_name" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Landline/Mobile No.</label>
                            <input id="mobile-no-txt-cwa" type="text" name="work_contact" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input id="email-txt-cwa" type="email" name="work_email" autocomplete="off">
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Current Address <label><input id="same-permanent-btn" type="checkbox" name="same_as_permanent"> Same as permanent</label></legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label>House No./Lot/Bldg</label>
                            <input id="house-no-txt-ca" type="text" name="curr_house_no" placeholder="Lot 1" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Street/Block</label>
                            <input id="street-txt-ca" type="text" name="curr_street" placeholder="Block 1" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Region</label>
                            <select id="region-select-ca" name="curr_region">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Province</label>
                            <select id="province-select-ca" name="curr_province">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Municipality / City</label>
                            <select id="city-select-ca" name="curr_city">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Barangay</label>
                            <select id="barangay-select-ca" name="curr_barangay">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Home Phone No.</label>
                            <input id="phone-no-txt-ca" type="text" name="curr_phone" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Mobile Phone No.</label>
                            <input id="mobile-no-txt-ca" type="text" name="curr_mobile" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input id="email-txt-ca" type="email" name="curr_email" autocomplete="off">
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Address Outside the Philippines (For OFW Only)</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Employer's Name</label>
                            <input id="employers-name-txt-ofw" type="text" name="ofw_employer" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Occupation</label>
                            <input id="occupation-txt-ofw" type="text" name="ofw_occupation" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Place of Work</label>
                            <input id="place-work-txt-ofw" type="text" name="ofw_place" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>House No./Lot/Bldg</label>
                            <input id="house-no-txt-ofw" type="text" name="ofw_house_no" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Street/Block</label>
                            <input id="street-txt-ofw"  type="text" name="ofw_street" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Region</label>
                            <input id="region-txt-ofw" type="text" name="ofw_region" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Province</label>
                            <input id="province-txt-ofw" type="text" name="ofw_province" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Municipality / City</label>
                            <input id="city-txt-ofw" type="text" name="ofw_city" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <input id="country-txt-ofw" type="text" name="ofw_country" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Office Phone No.</label>
                            <input id="office-mobile-txt-ofw" type="text" name="ofw_office_phone" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Mobile Phone No.</label>
                            <input id="mobile-no-txt-ofw" type="text" name="ofw_mobile" autocomplete="off">
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <?php include("../assets/php/patient_registration_form/modal/search_patient.php") ?>
    <?php include("../assets/php/patient_registration_form/modal/referral_form.php") ?>
    <?php include("../assets/php/patient_registration_form/modal/referring_doctor.php") ?>

    <?php include("../links/script_links.php") ?>

    <script src="../assets/js/patient_registration_form/patient_registration_form.js?v=<?php echo time(); ?>"></script>
    <script src="../assets/js/patient_registration_form/get_location.js?v=<?php echo time(); ?>"></script>
    <script src="../assets/js/modal/search_patient.js?v=<?php echo time(); ?>"></script>
    <script src="../assets/js/modal/referral_form.js?v=<?php echo time(); ?>"></script>
    <script src="../assets/js/modal/referring_doctor.js?v=<?php echo time(); ?>"></script>
</body>
</html>
