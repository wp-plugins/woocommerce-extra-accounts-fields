<?php
$date_field_value = get_user_meta( get_current_user_id(), 'billing_' . $this->generate_name( $field[ 'woocommerce_extra_fields_setting_id_name' ] ), TRUE );
?>
<p class="form-row form-row-<?php echo $field[ 'woocommerce_extra_fields_setting_id_position' ] ?>">
	<label for="reg_<?php echo $field_name ?>">
		<?php _e( $field[ 'woocommerce_extra_fields_setting_id_name' ], $this->text_domain ); ?>
		<?php if ( $field[ 'woocommerce_extra_fields_setting_id_required' ] == 'yes' ) : ?>
			<span class="required">*</span>
		<?php endif; ?>
	</label>
	<input type="text" class="input-text"
	       name="billing_<?php echo $this->generate_name( $field[ 'woocommerce_extra_fields_setting_id_name' ] ) ?>"
	       id="reg_date_picker"
	       value="<?php echo isset( $date_field_value ) ?
		       $date_field_value :
		       NULL ?>"/>
</p>