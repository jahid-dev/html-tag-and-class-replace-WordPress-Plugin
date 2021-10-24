<div class="wrap">
   <h2 class="best-header-title"><?php echo esc_html($this->plugin->displayName); ?> &raquo; <?php esc_html_e( 'Settings','html-tag-and-class-replace'); ?> </h2>
  <?php
    if ( isset( $this->message ) ) {
  ?>
   <div class="updated fade">
      <p><?php echo esc_html($this->message); ?></p>
   </div>
  <?php
  }
  if ( isset( $this->errorMessage ) ) {
  ?>
  <div class="error fade"><p><?php echo esc_html($this->errorMessage); ?></p></div>
  <?php
  }
  ?>
   <?php
      $hfcm_form_action = admin_url('options-general.php?page=html-tag-and-class-replace');
      
      ?>
   <div class="html_tag_replace_notes">
      <h3><?php esc_html_e("Note: Replace Tag","html-tag-and-class-replace"); ?></h3>
      <ul>
         <li><?php esc_html_e("Old Tag","html-tag-and-class-replace"); ?> <code><?php esc_html_e("h1.....h6, p, a, span, .class-name h1.....h6, .class-name p, .class-name a","html-tag-and-class-replace"); ?></code> <b><?php esc_html_e("You can add multiple tag using comma ( , )","html-tag-and-class-replace"); ?></b></li>
         <li><?php esc_html_e("New Tag just type","html-tag-and-class-replace"); ?> <code><?php esc_html_e(" h1.......h6, p, span","html-tag-and-class-replace"); ?></code> <b><?php esc_html_e("You can only add one tag", "html-tag-and-class-replace"); ?></b></li>
      </ul>
   </div>
   <div class="replace-tag-box">
      <form method='post' action='<?php echo esc_html($hfcm_form_action); ?>'>
         <p>
            <label for="html-old-tag"><?php esc_html_e("Old Tag","html-tag-and-class-replace"); ?> <small><?php esc_html_e("(Tag Name)", "html-tag-and-class-replace"); ?></small></label>
            <input type="text" name="html_old_tag" id="html-old-tag" placeholder="Example: .class-name a, p, h1..... h6, span" value="<?php if(!empty($this->html_tag_replace_info['html_old_tag'])){ echo esc_html($this->html_tag_replace_info['html_old_tag']); } ?>" <?php echo ( ! current_user_can( 'unfiltered_html' ) ) ? ' disabled="disabled" ' : ''; ?> />
         </p>
         <p>
            <label for="html-new-tag"><?php esc_html_e("New Tag","html-tag-and-class-replace"); ?> <small><?php esc_html_e("(Tag Name)", "html-tag-and-class-replace"); ?></small></label>
            <input type="text" name="html_new_tag" id="html-new-tag" placeholder="Example: h1.....h6, p, span"  value="<?php if(!empty($this->html_tag_replace_info['html_new_tag'])){ echo esc_html($this->html_tag_replace_info['html_new_tag']); } ?>" <?php echo ( ! current_user_can( 'unfiltered_html' ) ) ? ' disabled="disabled" ' : ''; ?> />
         </p>
         <p>
            <label for="html-old-class"><?php esc_html_e("Old Class Name","html-tag-and-class-replace"); ?> <small><?php esc_html_e("(Class Name)", "html-tag-and-class-replace"); ?></small></label>
            <input type="text" name="html_old_class" id="html-old-class" placeholder="class-name" value="<?php if(!empty($this->html_tag_replace_info['html_old_class'])){ echo esc_html($this->html_tag_replace_info['html_old_class']); } ?>" <?php echo ( ! current_user_can( 'unfiltered_html' ) ) ? ' disabled="disabled" ' : ''; ?> />
         </p>
         <p>
            <label for="html-new-class"><?php esc_html_e("New Class Name","html-tag-and-class-replace"); ?> <small><?php esc_html_e("(Class Name)", "html-tag-and-class-replace"); ?></small></label>
            <input type="text" name="html_new_class" id="html-new-class" placeholder="class-name"  value="<?php if(!empty($this->html_tag_replace_info['html_new_class'])){ echo esc_html($this->html_tag_replace_info['html_new_class']); } ?>" <?php echo ( ! current_user_can( 'unfiltered_html' ) ) ? ' disabled="disabled" ' : ''; ?> />
         </p>
          <?php if ( current_user_can( 'unfiltered_html' ) ) { ?>
         <?php wp_nonce_field( $this->plugin->name, $this->plugin->name . '_nonce' ); ?>
         <p>
            <input type='submit' name='but_submit' value='<?php esc_attr_e("Submit","html-tag-and-class-replace"); ?>'>
         </p>
        <?php } ?>
      </form>
   </div>
</div>
