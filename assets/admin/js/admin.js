jQuery(document).ready(function ($) {
    // Function to add a new repeater row
    function addRepeaterRow(container, type) {
        const timestamp = Date.now(); // Unique identifier
        let newRow = '';
        if (type === 'tag') {
            newRow = `
                <div class="repeater-row">
                    <div class="repeater-field">
                        <p>
                            <label>Old Tag</label>
                            <input type="text" name="tag_repeater_data[${timestamp}][html_old_tag]" placeholder="Ex: .class-name a/h6/span">
                        </p>
                        <p>
                            <label>New Tag</label>
                            <input type="text" name="tag_repeater_data[${timestamp}][html_new_tag]" placeholder="Ex: h5">
                        </p>
                    </div>
                    <div class="repeater-controller">
                        <span class="remove-row"><p>×</p></span>
                    </div>
                </div>
            `;
        } else if (type === 'class') {
            newRow = `
                <div class="repeater-row">
                    <div class="repeater-field">
                        <p>
                            <label>Old Class</label>
                            <input type="text" name="repeater_data[${timestamp}][html_old_class]" placeholder="class-name">
                        </p>
                        <p>
                            <label>New Class</label>
                            <input type="text" name="repeater_data[${timestamp}][html_new_class]" placeholder="class-name">
                        </p>
                    </div>
                    <div class="repeater-controller">
                        <span class="remove-row"><p>×</p></span>
                    </div>
                </div>
            `;
        }
        container.append(newRow);
    }

    // Handle Add Row for Tag Replace
    $('#add-tag-row').on('click', function (e) {
        e.preventDefault();
        const tagContainer = $('#tag-repeater-container');
        addRepeaterRow(tagContainer, 'tag');
    });

    // Handle Add Row for Class Replace
    $('#add-class-row').on('click', function (e) {
        e.preventDefault();
        const classContainer = $('#class-repeater-container');
        addRepeaterRow(classContainer, 'class');
    });

    // Remove row functionality
    $(document).on('click', '.remove-row', function (e) {
        e.preventDefault();
        $(this).closest('.repeater-row').remove();
    });

    // Handle form submission
    $('.replace-tag-box form').on('submit', function (e) {
        e.preventDefault();
        $('.html-tag-and-class-submit').addClass('html-tag-and-class-loader');
        // Collect the form data
        const formData = {
            action: 'save_html_replace_data',
            nonce: htmlReplaceAjax.nonce,
            tag_data: $('#tag-repeater-container .repeater-row').map(function () {
                return {
                    html_old_tag: $(this).find('[name*="[html_old_tag]"]').val(),
                    html_new_tag: $(this).find('[name*="[html_new_tag]"]').val(),
                };
            }).get(),
            class_data: $('#class-repeater-container .repeater-row').map(function () {
                return {
                    html_old_class: $(this).find('[name*="[html_old_class]"]').val(),
                    html_new_class: $(this).find('[name*="[html_new_class]"]').val(),
                };
            }).get(),
        };

        // Send data via AJAX
        $.post(htmlReplaceAjax.ajax_url, formData, function (response) {
            const $responseBox = $('.html-tag-and-class-replace-response');
            $responseBox.html(''); // Clear previous messages

            if (response.success) {
                $responseBox.html('<div class="updated notice"><p>Settings Saved Successfully!</p></div>');
            } else {
                $responseBox.html('<div class="error notice"><p>Failed to Save Data</p></div>');
            }

            $('.html-tag-and-class-submit').removeClass('html-tag-and-class-loader');

            // Hide the response message after 5 seconds
            setTimeout(function () {
                $responseBox.fadeOut(500, function () {
                    $(this).html('').show(); // Clear the content and reset visibility
                });
            }, 5000);
        });
    });
});