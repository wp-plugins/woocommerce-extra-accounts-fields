<?php
$textarea_field = get_user_meta( get_current_user_id(), 'billing_' . $this->generate_name( $field[ 'woocommerce_extra_fields_setting_id_name' ] ), TRUE );
?>

<p class="form-row form-row-<?php echo $field[ 'woocommerce_extra_fields_setting_id_position' ] ?>">
	<label for="reg_<?php echo $field_name ?>">
		<?php _e( $field[ 'woocommerce_extra_fields_setting_id_name' ], $this->text_domain ); ?>
		<?php if ( $field[ 'woocommerce_extra_fields_setting_id_required' ] == 'yes' ) : ?>
			<span class="required">*</span>
		<?php endif; ?>
	</label>
	<textarea name="billing_<?php echo $this->generate_name( $field[ 'woocommerce_extra_fields_setting_id_name' ] ) ?>"
	          id="reg_<?php echo $field_name ?>" cols="30" rows="10"><?php echo isset( $textarea_field ) ?
			$textarea_field :
			NULL ?></textarea>
</p>