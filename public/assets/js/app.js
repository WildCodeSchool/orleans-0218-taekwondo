/** ##### INITIALISATION ##### */
$(document).ready(() => {
    // Turn on all tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Auto active the current nav tab
    $('#navMenu').find(`a[href="${window.location.pathname}"]`).parent().addClass('active');

    // Turn on all dropdowns
    $('.dropdown-toggle').dropdown();
})

/** ##### FORM CONFIRMATION ##### */
$(document).on('submit', 'form[confirm]', async function(e){
    if (this.hasAttribute('confirmed')) {
        this.removeAttribute('confirmed');
        return;
    }
    e.preventDefault();
    const content = $(this).attr('confirm') || "Confirmez-vous l'envoi de ce formulaire ?";
    const approbation = await swal({
        title: content,
        icon: 'warning',
        buttons: ['Annuler', 'Confirmer'],
        dangerMode: true
    })
    if (approbation)
        $(this).attr('confirmed', true).submit();
})