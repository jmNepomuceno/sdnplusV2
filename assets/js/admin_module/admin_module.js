$(document).ready(function () {
    let user_accessibility_modal = new bootstrap.Modal(document.getElementById('user-accessibility-modal'));
    let patientClassificationModal = new bootstrap.Modal(document.getElementById('patient-classification-modal'));
    let hospitalsModal = new bootstrap.Modal(document.getElementById('hospitals-modal'));
    
    // patientClassificationModal.show()
    // patientClassificationModal.show()
    // hospitalsModal.show()

    $('.go-user-access').click(function(){
        user_accessibility_modal.show()
    })

    $('.go-classification').click(function(){
        patientClassificationModal.show()
    })

    $('.go-hospitals').click(function(){
        hospitalsModal.show()
    })
});
