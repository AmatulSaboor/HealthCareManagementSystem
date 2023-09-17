$(document).ready(function () {
    $('#stepper-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    });
});
let currentStep = 0;
function updateStepper() {
    $('#stepper-tabs .nav-link').removeClass('active');
    $('#stepper-tabs .nav-link').eq(currentStep).addClass('active');
    $('#stepper-content .tab-pane').removeClass('show active');
    $('#stepper-content .tab-pane').eq(currentStep).addClass('show active');
    $('#prevBtn').prop('disabled', currentStep === 0);
    $('#nextBtn').prop('disabled', currentStep === 2);
}
function nextStep() {
    if (currentStep < 2) {
        currentStep++;
        updateStepper();
    }
}
function prevStep() {
    if (currentStep > 0) {
        currentStep--;
        updateStepper();
    }
}
updateStepper();