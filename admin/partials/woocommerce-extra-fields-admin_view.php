<div id="setting-page-container">
<div class="wrap woocommerce-extra-fields-container">
<h3> <?php _e( 'Adding extra fields', $this->text_domain ) ?> </h3>
<?php echo settings_errors() ?>
<div class="updated woocommerce-message below-h2">
	<p><?php _e( 'Click on this button to add more fields :', $this->text_domain ) ?></p>

	<p class="submit">
		<button id="add-more-fields"
		        class="button button-primary"><?php _e( 'Add Fields', $this->text_domain ) ?></button>
	</p>

</div>
<form action='options.php' method='post'>
<?php settings_fields( 'woocommerce_extra_fields_setting_group' ); ?>
<?php $fields = $this->options; ?>
<?php if ( ! empty( $fields ) ): ?>
	<div id="sortable">
		<?php foreach ( $fields as $key => $container ): ?>
			<?php if ( isset( $container[ 'woocommerce_extra_fields_setting_id_type' ] ) ): ?>
				<div class="wooextra-section-container">
					<div class="container-close-button">
						<a href="" class="containerclose"><i class="fa fa-close"></i></a>
					</div>
					<table class="form-table">
						<tbody>
						<tr>
							<th scope="row"><?php _e( 'Type', $this->text_domain ) ?></th>
							<td>
								<select
									name="woocommerce_extra_fields_setting_name[<?php echo $key ?>][woocommerce_extra_fields_setting_id_type]"
									class="adding-type-field">
									<option
										value=""><?php _e( 'Select a value', $this->text_domain ) ?></option>
									<option
										value="text" <?php selected( $container[ 'woocommerce_extra_fields_setting_id_type' ], 'text' ) ?>>
										<?php _e( 'Text field', $this->text_domain ) ?>
									</option>
									<option
										value="textarea" <?php selected( $container[ 'woocommerce_extra_fields_setting_id_type' ], 'textarea' ) ?>>
										<?php _e( 'Textarea field', $this->text_domain ) ?>
									</option>
									<option
										value="dropdown" <?php selected( $container[ 'woocommerce_extra_fields_setting_id_type' ], 'dropdown' ) ?>>
										<?php _e( 'Dropdown field', $this->text_domain ) ?>
									</option>

									<option
										value="date" <?php selected( $container[ 'woocommerce_extra_fields_setting_id_type' ], 'date' ) ?>>
										<?php _e( 'Date field', $this->text_domain ) ?>
									</option>

									<option
										value="check" <?php selected( $container[ 'woocommerce_extra_fields_setting_id_type' ], 'check' ) ?>>
										<?php _e( 'Check field', $this->text_domain ) ?>
									</option>

									<option
										value="radio" <?php selected( $container[ 'woocommerce_extra_fields_setting_id_type' ], 'radio' ) ?>>
										<?php _e( 'Radio field', $this->text_domain ) ?>
									</option>


								</select>

								<?php if ( $container[ 'woocommerce_extra_fields_setting_id_type' ] == 'dropdown' || $container[ 'woocommerce_extra_fields_setting_id_type' ] == 'radio' || $container[ 'woocommerce_extra_fields_setting_id_type' ] == 'check' ): ?>
									<?php foreach ( $container as $k => $f ): ?>
										<?php if ( is_array( $f ) ): ?>
											<div class="adding-dropdown-extra-fields">
												<input type="text" class="extra-dropdown-fields-label"
												       value="<?php echo $f[ 'woocommerce_extra_fields_setting_name_label' ] ?>"
												       placeholder="Label"
												       name="woocommerce_extra_fields_setting_name[<?php echo $key ?>][<?php echo $k ?>][woocommerce_extra_fields_setting_name_label]">
												<input type="text" class="extra-dropdown-fields-value"
												       value="<?php echo $f[ 'woocommerce_extra_fields_setting_name_value' ] ?>"
												       placeholder="Value"
												       name="woocommerce_extra_fields_setting_name[<?php echo $key ?>][<?php echo $k ?>][woocommerce_extra_fields_setting_name_value]">
												<a href="" class="boxclose"><i class="fa fa-close"></i></a>
												<a href="" class="boxadd"><i class="fa fa-plus"></i></a>
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</td>
						</tr>


						<tr>
							<th scope="row"><?php _e( 'Name', $this->text_domain ) ?></th>
							<td><input type="text"
							           value="<?php echo $container[ 'woocommerce_extra_fields_setting_id_name' ] ?>"
							           class="adding-name-field"
							           placeholder="Name.."
							           name="woocommerce_extra_fields_setting_name[<?php echo $key ?>][woocommerce_extra_fields_setting_id_name]">
							</td>
						</tr>


						<tr>
							<th scope="row"><?php _e( 'Field style', $this->text_domain ) ?></th>
							<td>
								<select
									name="woocommerce_extra_fields_setting_name[<?php echo $key ?>][woocommerce_extra_fields_setting_id_position]"
									class="adding-type-field">
									<option
										value="wide" <?php selected( $container[ 'woocommerce_extra_fields_setting_id_position' ], 'wide' ) ?>><?php _e( 'Wide', $this->text_domain ) ?></option>
									<option
										value="first" <?php selected( $container[ 'woocommerce_extra_fields_setting_id_position' ], 'first' ) ?>><?php _e( 'First', $this->text_domain ) ?></option>
									<option
										value="last" <?php selected( $container[ 'woocommerce_extra_fields_setting_id_position' ], 'last' ) ?>><?php _e( 'Last', $this->text_domain ) ?></option>

								</select>
							</td>
						</tr>

						<tr>
							<th scope="row"><?php _e( 'Required', $this->text_domain ) ?></th>
							<td><select
									name="woocommerce_extra_fields_setting_name[<?php echo $key ?>][woocommerce_extra_fields_setting_id_required]">

									<option
										value="yes" <?php selected( $container[ 'woocommerce_extra_fields_setting_id_required' ], 'yes' ) ?>>
										<?php _e( 'Yes', $this->text_domain ) ?>
									</option>
									<option
										value="no" <?php selected( $container[ 'woocommerce_extra_fields_setting_id_required' ], 'no' ) ?>>
										<?php _e( 'No', $this->text_domain ) ?>
									</option>
								</select>
							</td>
						</tr>

						</tbody>
					</table>
				</div> <!-- End of container -->
			<?php endif; ?>
		<?php endforeach; ?>
	</div> <!-- end sortable -->
	<?php // If there is no values in options table ?>
<?php else: ?>
<div id="sortable">
	<div class="wooextra-section-container">
		<div class="container-close-button">
			<a href="" class="containerclose"><i class="fa fa-close"></i></a>
		</div>
		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row"><?php _e( 'Type', $this->text_domain ) ?></th>
				<td>
					<select
						name="woocommerce_extra_fields_setting_name[0][woocommerce_extra_fields_setting_id_type]"
						class="adding-type-field">
						<option
							value=""><?php _e( 'Select a value', $this->text_domain ) ?></option>
						<option value="text"><?php _e( 'Text field', $this->text_domain ) ?></option>
						<option
							value="textarea"><?php _e( 'Textarea field', $this->text_domain ) ?></option>
						<option
							value="dropdown"><?php _e( 'Dropdown field', $this->text_domain ) ?></option>
						<option
							value="date">
							<?php _e( 'Date field', $this->text_domain ) ?>
						</option>

						<option
							value="check">
							<?php _e( 'Check field', $this->text_domain ) ?>
						</option>

						<option
							value="radio">
							<?php _e( 'Radio field', $this->text_domain ) ?>
						</option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope="row"><?php _e( 'Name', $this->text_domain ) ?></th>
				<td><input type="text" value="" class="adding-name-field"
				           placeholder="Name.."
				           name="woocommerce_extra_fields_setting_name[0][woocommerce_extra_fields_setting_id_name]">
				</td>
			</tr>

			<tr>
				<th scope="row"><?php _e( 'Field style', $this->text_domain ) ?></th>
				<td>
					<select
						name="woocommerce_extra_fields_setting_name[0][woocommerce_extra_fields_setting_id_position]"
						class="adding-type-field">
						<option value="wide"><?php _e( 'Wide', $this->text_domain ) ?></option>
						<option value="first"><?php _e( 'First', $this->text_domain ) ?></option>
						<option value="last"><?php _e( 'Last', $this->text_domain ) ?></option>

					</select>
				</td>
			</tr>

			<tr>
				<th scope="row"><?php _e( 'Required', $this->text_domain ) ?></th>
				<td><select
						name="woocommerce_extra_fields_setting_name[0][woocommerce_extra_fields_setting_id_required]">
						<option
							value=""><?php _e( 'Select a value', $this->text_domain ) ?></option>
						<option value="yes"><?php _e( 'Yes', $this->text_domain ) ?></option>
						<option value="no"><?php _e( 'No', $this->text_domain ) ?></option>
					</select>
				</td>
			</tr>

			</tbody>
		</table>
	</div>
</div>

<?php endif; ?>

</div>
<div class="wrap woocommerce-extra-fields-help">

	<h4><?php _e( 'How this work ?', $this->text_domain ) ?></h4>
	<ul>
		<li><?php _e('Start first to add a new field, there is various fields to choose from like text, textarea, dropdown, radio, checkbox and date fields', $this->text_domain) ?></li>
		<li><?php _e('fields like dropdown, radio, checkbox allow you to add mutliple sub fields for various options ', $this->text_domain) ?></li>
		<li><?php _e('You can choose the field style like wide, first, last', $this->text_domain) ?></li>
		<li><?php _e('Also you many want to choose if this field is required field or not ', $this->text_domain) ?></li>
		<li><?php _e('after that you can save you results from the save button', $this->text_domain) ?></li>
		<li><?php _e('The fields will appear in my account page, also they appear in edit page', $this->text_domain) ?></li>
		<li><?php _e('for any more information please drop message for plugin author at the following email oaattia at gmail dot com, please consider 24 hours tp reply on the message ', $this->text_domain) ?></li>
	</ul>
</div>

</div>

<?php submit_button(); ?>
</form>
