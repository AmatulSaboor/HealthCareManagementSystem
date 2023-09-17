function infoPopUp(msg){
    if(msg){
    Swal.fire(
        'Info!',
        msg,
        'info'
    )};
}
function errorPopUp(msg){
    if(msg){
    Swal.fire(
        'Error!',
        msg,
        'error'
    )};
}
function sucessPopUp(msg){
    if(msg){
    Swal.fire(
        'Success!',
        msg,
        'success'
    )};
}
function confirmationPopUp(id, formId, msg) {
    console.log('in fucntion ' +id)
    Swal.fire({
    title: 'Confirmation',
    text: 'Are you sure you want to delete this ' +msg+ '?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it',
    cancelButtonText: 'No, keep it',
    }).then((result) => {
    if (result.isConfirmed) {
        document.getElementById(formId + id).submit();
    }
});
}