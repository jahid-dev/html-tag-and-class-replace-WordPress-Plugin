<div class="wrap">
   <h2 class="best-header-title"><?php echo esc_html($this->plugin->displayName); ?> &raquo; <?php esc_html_e( 'Settings','html-tag-and-class-replace'); ?> </h2>

   <?php
      $hfcm_form_action = admin_url('options-general.php?page=html-tag-and-class-replace');
   ?>
   <div class="replace-tag-box">
      <form method='post' action='<?php echo esc_html($hfcm_form_action); ?>'>
         
         <!-- Tag Replace Start -->
         <h3><?php esc_html_e("Replace Tag", "html-tag-and-class-replace"); ?></h3>
         <div class="repeater-box">
            <div id="tag-repeater-container" class="repeater-container">
               <?php
               $tag_repeater_data = $this->html_tag_replace_info['html_tag_replace'] ?? [];
               if (empty($tag_repeater_data)) {
                     $tag_repeater_data[] = ['html_old_tag' => '', 'html_new_tag' => ''];
               } else {
                     $tag_repeater_data = $tag_repeater_data["repeater_data"];
               }
               foreach ($tag_repeater_data as $index => $row) {
               ?>
                     <div class="repeater-row">
                        <div class="repeater-field">
                           <p>
                                 <label><?php esc_html_e("Old Tag", "html-tag-and-class-replace"); ?></label>
                                 <input type="text" name="tag_repeater_data[<?php echo $index; ?>][html_old_tag]" placeholder="Ex: .class-name a/h6/span" value="<?php echo esc_attr($row['html_old_tag']); ?>">
                           </p>
                           <p>
                                 <label><?php esc_html_e("New Tag", "html-tag-and-class-replace"); ?></label>
                                 <input type="text" name="tag_repeater_data[<?php echo $index; ?>][html_new_tag]" placeholder="Ex: h5" value="<?php echo esc_attr($row['html_new_tag']); ?>">
                           </p>
                        </div>
                        <div class="repeater-controller">
                           <span class="remove-row"><p>×</p></span>
                        </div>
                     </div>
               <?php } ?>
            </div>
            <div class="add-new-row">
               <button type="button" class="button button-primary" id="add-tag-row"><?php esc_html_e("Add Row", "html-tag-and-class-replace"); ?></button>
            </div>
         </div>
         <!-- Tag Replace End -->

         <!-- Class Replace Start -->
         <h3><?php esc_html_e("Replace Class", "html-tag-and-class-replace"); ?></h3>
         <div class="repeater-box">
            <div id="class-repeater-container" class="repeater-container">
               <?php
               $class_repeater_data = $this->html_tag_replace_info['html_class_replace'] ?? [];
               if (empty($class_repeater_data)) {
                     $class_repeater_data[] = ['html_old_class' => '', 'html_new_class' => ''];
               } else {
                     $class_repeater_data = $class_repeater_data["repeater_data"];
               }
               foreach ($class_repeater_data as $index => $row) {
               ?>
                     <div class="repeater-row">
                        <div class="repeater-field">
                           <p>
                                 <label><?php esc_html_e("Old Class", "html-tag-and-class-replace"); ?></label>
                                 <input type="text" name="repeater_data[<?php echo $index; ?>][html_old_class]" placeholder="class-name" value="<?php echo esc_attr($row['html_old_class']); ?>">
                           </p>
                           <p>
                                 <label><?php esc_html_e("New Class", "html-tag-and-class-replace"); ?></label>
                                 <input type="text" name="repeater_data[<?php echo $index; ?>][html_new_class]" placeholder="class-name" value="<?php echo esc_attr($row['html_new_class']); ?>">
                           </p>
                        </div>
                        <div class="repeater-controller">
                           <span class="remove-row"><p>×</p></span>
                        </div>
                     </div>
               <?php } ?>
            </div>
            <div class="add-new-row">
               <button type="button" class="button button-primary" id="add-class-row"><?php esc_html_e("Add Row", "html-tag-and-class-replace"); ?></button>
            </div>
         </div>
         <!-- Class Replace End -->
         <div class="html-tag-and-class-replace-response">

         </div>
         <?php wp_nonce_field( $this->plugin->name, $this->plugin->name . '_nonce' ); ?>
         <p>
            <button type='submit' class="html-tag-and-class-submit">
            <?php esc_attr_e("Save Settings","html-tag-and-class-replace"); ?>
            </button>
         </p>

      </form>
   </div>
</div>
