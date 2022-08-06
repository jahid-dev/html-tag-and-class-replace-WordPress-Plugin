;(function ($) {

$old_all_tags=htc_data.oldtag;
$replace_by_tag='<'+htc_data.newtag+'>';

$($old_all_tags).replaceWith(function(){
    return $($replace_by_tag, {
        html: this.innerHTML
    });
});

$old_class_name=htc_data.oldclass;
$new_class_name=htc_data.newclass;
$('[class^="'+$old_class_name+'"]').addClass($new_class_name).removeClass($old_class_name);

})(jQuery);
