$(document).ready(function() {
    $('#btnSignIn').on('click', function() {
        let form = document.getElementById('loginForm');
        if (form.checkValidity()) {
            $(this).prop('disabled', true);
            $('#btnText').text('Processing...');
            $('#btnSpinner').removeClass('d-none');
            form.submit();
        } else {
            form.reportValidity();
        }
    });
});