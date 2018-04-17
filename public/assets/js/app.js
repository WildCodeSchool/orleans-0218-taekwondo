/** ##### INITIALISATION ##### */
$(document).ready(() => {
    // Turn on all tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Auto active the current nav tab
    $('#navMenu').find(`a[href="${window.location.pathname}"]`).parent().addClass('active');

    // Turn on all dropdowns
    $('.dropdown-toggle').dropdown();
})

/** ##### Handle AJAX forms ##### */
window.sendForm = async (action, method, data) => {
    console.log('Send new AJAX request.', { action, method, data });
    const isForm = data.tagName && data.tagName === 'FORM';
    const form = isForm ? $(data) : null;
    if(data == null) data = {};

    // Format data
    let body = new FormData();
    if($.isPlainObject(data)) for(let key in data) body.append(key, data[key]);
    else body = new FormData(data);

    // Do ajax request
    if (isForm) form.find('[type="submit"]:not([disabled])').prop('disabled', true);
    
    const req = await fetch(action, { method, body });
    const rep = await req.json();
        
    if (isForm && !form[0].hasAttribute('no-reset')) {
        if (!form[0].hasAttribute('no-reset')) {
            form[0].reset();
            form
                .find('[value]:not([readonly], [disabled], [type=hidden], option, input[type=checkbox], input[type=radio])')
                .each((index, value) => { $(value).val('') });
        }
        setTimeout(() => { form.find('[type=submit][disabled]').prop('disabled', false); }, 2000);
    }

    return rep;
};

$(document).on("submit", "form[ajax]", function(e) {
    e.preventDefault();
    const action = $(this).attr('action');
    const method = $(this).attr('method');

    if(action != null && method != null){
        window.sendForm(action, method, this)
        .then(({ state, message }) => {
            toastr[state ? 'success' : 'error'](message);
        })
    }
});