$(function() {

    if ($('#file-directory-form').length) {
        var form = '#file-directory-form';

        // Update the label on Click event
        $('label', form).click(function() {
            var $label = $(this),
                $fieldset = $label.parents('section:first')
                                  .find('fieldset');

            if ($fieldset.is(':visible')) {
                $fieldset.slideUp('fast');
                $label.find('span')
                      .html('show');
            } else {
                $fieldset.slideDown('fast');
                $label.find('span')
                      .html('hide');
            }

        });
    }
    
})