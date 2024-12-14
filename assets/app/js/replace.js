;(function ($) {
    $(document).ready(function () {
        // Replace tags
        if (Array.isArray(htc_data.html_tag_replace)) {
            htc_data.html_tag_replace.forEach(function (tagReplace) {
                const oldTagSelector = tagReplace.html_old_tag;
                const newTag = tagReplace.html_new_tag;

                $(oldTagSelector).replaceWith(function () {
                    // Create a new element with the specified tag
                    const newElement = $('<' + newTag + '>');
                    
                    // Copy over attributes only if they exist
                    $.each(this.attributes, function (_, attr) {
                        newElement.attr(attr.name, attr.value);
                    });

                    // Copy inner HTML
                    newElement.html(this.innerHTML);

                    return newElement;
                });
            });
        }

        // Replace classes
        if (Array.isArray(htc_data.html_class_replace)) {
            htc_data.html_class_replace.forEach(function (classReplace) {
                const oldClass = classReplace.html_old_class;
                const newClass = classReplace.html_new_class;

                // Find elements with the old class and replace it
                $('[class*="' + oldClass + '"]').each(function () {
                    const $el = $(this);

                    // Replace the class (ensures partial matches)
                    const updatedClasses = $el
                        .attr('class')
                        .split(' ')
                        .map(function (cls) {
                            return cls === oldClass ? newClass : cls;
                        })
                        .join(' ');

                    $el.attr('class', updatedClasses);
                });
            });
        }
    });
})(jQuery);