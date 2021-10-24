$old_all_tags=htc_data.oldtag;
$replace_by_tag='<'+htc_data.newtag+'>';

jQuery($old_all_tags).replaceWith(function(){
    return jQuery($replace_by_tag, {
        html: this.innerHTML
    });
});

$old_class_name=htc_data.oldclass;
$new_class_name=htc_data.newclass;
jQuery('.'+$old_class_name).addClass($new_class_name).removeClass($old_class_name);

