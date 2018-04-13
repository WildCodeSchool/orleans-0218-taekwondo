$(document).ready(() => {
    // Turn on all tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Auto active the current nav tab
    $('#navMenu').find(`a[href="${window.location.pathname}"]`).parent().addClass('active');
})