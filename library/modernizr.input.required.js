$('form').find('input[required]').each(function() {
    $(this).attr('class', 'required ' + this.getAttribute('type')).removeAttr('required');
});
$('form').each(function() {
    $(this).validate();
});