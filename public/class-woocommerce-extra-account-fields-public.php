<?php

class Woocommerce_Extra_Account_Fields_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $woocommerce_extra_account_fields The ID of this plugin.
	 */
	private $text_domain;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string $woocommerce_extra_account_fields The name of the plugin.
	 * @var      string $version The version of this plugin.
	 */

	protected $fields_data;

	public function __construct( $woocommerce_extra_account_fields, $version ) {

		$this->text_domain = $woocommerce_extra_account_fields;
		$this->version     = $version;
		$this->fields_data = get_option( 'woocommerce_extra_fields_setting_name' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function os_public_enqueue_styles() {
		wp_enqueue_style( $this->text_domain . '_jquery_ui', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->text_domain, plugin_dir_url( __FILE__ ) . 'css/woocommerce-extra-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function os_public_enqueue_scripts() {

		wp_enqueue_script( $this->text_domain, plugin_dir_url( __FILE__ ) . 'js/front-custom.js', array(
			'jquery',
			'jquery-ui-core',
			'jquery-ui-datepicker'
		), $this->version, FALSE );

	}


	/**
	 * @param $label
	 *
	 * @return mixed
	 * Generate the name for the fields from the label passed
	 */
	private function generate_name( $label ) {
		// make sure first is the string is in lowercase
		$label = strtolower( $label );
		$name  = preg_replace( '/\s+/', '_', $label ); #replace spaces with underscores

		return $name;
	}

	/**
	 * Adding the html for the fields
	 */
	public function os_woocommerce_extra_register_fields() {

		if ( isset( $this->fields_data ) ):

			foreach ( $this->fields_data as $field ) :
				$field_name = 'billing_' . $this->generate_name( $field[ 'woocommerce_extra_fields_setting_id_name' ] );

				switch ( $field[ 'woocommerce_extra_fields_setting_id_type' ] ) {
					case 'text':
						require plugin_dir_path( dirname( __FILE__ ) ) . '/public/partials/text.php';
						break;
					case 'textarea':
						require plugin_dir_path( dirname( __FILE__ ) ) . '/public/partials/textarea.php';
						break;
					case 'dropdown':
						require plugin_dir_path( dirname( __FILE__ ) ) . '/public/partials/dropdown.php';
						break;
					case 'radio':
						require plugin_dir_path( dirname( __FILE__ ) ) . '/public/partials/radio.php';
						break;
					case 'check':
						require plugin_dir_path( dirname( __FILE__ ) ) . '/public/partials/check.php';
						break;
					case 'date':
						require plugin_dir_path( dirname( __FILE__ ) ) . '/public/partials/date.php';
						break;
				}


			endforeach;
		endif;
	}


	public function os_woocommerce_validate_extra_register_fields( $username, $email, $validation_errors ) {

		foreach ( $this->fields_data as $field ) {

			// if the field is required ignore it and continue
			if ( $field[ 'woocommerce_extra_fields_setting_id_required' ] == 'no' ) {
				continue;
			}

			$field_name = 'billing_' . $this->generate_name( $field[ 'woocommerce_extra_fields_setting_id_name' ] );
			if ( isset( $_POST[ $field_name ] ) && empty( $_POST[ $field_name ] ) ) {
				$validation_errors->add( "billing_" . $field_name . "_error", __( "<strong>Error</strong>: " . $field[ 'woocommerce_extra_fields_setting_id_name' ] . " is required!", $this->text_domain ) );
			}
		}
	}

	/**
	 * Save the fields
	 * parameter $customer_id
	 */
	public function os_woocommerce_save_extra_register_fields( $customer_id ) {
		$fields = $_POST;
		foreach ( $fields as $key => $field ) {
			if ( isset( $field ) ) {
				if ( $key == 'billing_firstname' ) {
					update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST[ 'billing_firstname' ] ) );
					update_user_meta( $customer_id, 'billing_firstname', sanitize_text_field( $_POST[ 'billing_firstname' ] ) );
					update_user_meta( $customer_id, 'account_first_name', sanitize_text_field( $_POST[ 'billing_firstname' ] ) );
				} elseif ( $key == 'billing_lastname' ) {
					update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST[ 'billing_lastname' ] ) );
					update_user_meta( $customer_id, 'billing_lastname', sanitize_text_field( $_POST[ 'billing_lastname' ] ) );
					update_user_meta( $customer_id, 'account_last_name', sanitize_text_field( $_POST[ 'billing_lastname' ] ) );
				} else {

					if ( $key == 'email_2' || $key == '_wpnonce' || $key == '_wp_http_referer' || $key == 'register' ) {
						continue;
					}

					update_user_meta( $customer_id, $key, sanitize_text_field( $field ) );
				}
			}
		}

	}


	public function os_woocommerce_edit_account_save() {


		if ( 'POST' !== strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ) ) {
			return;
		}


		if ( empty( $_POST[ 'action' ] ) || ( 'save_account_details' !== $_POST[ 'action' ] ) || empty( $_POST[ '_wpnonce' ] ) ) {
			return;
		}

		wp_verify_nonce( $_POST[ '_wpnonce' ], 'woocommerce-save_account_details' );

		// Custom fields
		if ( ! empty( $_POST[ '_wp_http_referer' ] ) ) {
			$fields = $_POST;
			$customer_id = get_current_user_id();
			foreach ( $fields as $key => $field ) {
				if ( isset( $field ) ) {
					if ( $key == 'billing_firstname' ) {
						update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST[ 'billing_firstname' ] ) );
						update_user_meta( $customer_id, 'billing_firstname', sanitize_text_field( $_POST[ 'billing_firstname' ] ) );
						update_user_meta( $customer_id, 'account_first_name', sanitize_text_field( $_POST[ 'billing_firstname' ] ) );
					} elseif ( $key == 'billing_lastname' ) {
						update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST[ 'billing_lastname' ] ) );
						update_user_meta( $customer_id, 'billing_lastname', sanitize_text_field( $_POST[ 'billing_lastname' ] ) );
						update_user_meta( $customer_id, 'account_last_name', sanitize_text_field( $_POST[ 'billing_lastname' ] ) );
					} else {

						if ( $key == 'email_2' || $key == '_wpnonce' || $key == '_wp_http_referer' || $key == 'register' ) {
							continue;
						}

						update_user_meta( $customer_id, $key, sanitize_text_field( $field ) );
					}
				}
			}
		}


		$update = TRUE;
		$errors = new WP_Error();
		$user   = new stdClass();

		$user->ID     = (int) get_current_user_id();
		$current_user = get_user_by( 'id', $user->ID );

		if ( $user->ID <= 0 ) {
			return;
		}

		$account_first_name = ! empty( $_POST[ 'account_first_name' ] ) ?
			wc_clean( $_POST[ 'account_first_name' ] ) :
			'';
		$account_last_name  = ! empty( $_POST[ 'account_last_name' ] ) ?
			wc_clean( $_POST[ 'account_last_name' ] ) :
			'';
		$account_email      = ! empty( $_POST[ 'account_email' ] ) ?
			sanitize_email( $_POST[ 'account_email' ] ) :
			'';
		$pass1              = ! empty( $_POST[ 'password_1' ] ) ?
			$_POST[ 'password_1' ] :
			'';
		$pass2              = ! empty( $_POST[ 'password_2' ] ) ?
			$_POST[ 'password_2' ] :
			'';

		$user->first_name   = $account_first_name;
		$user->last_name    = $account_last_name;
		$user->user_email   = $account_email;
		$user->display_name = $user->first_name;

		if ( $pass1 ) {
			$user->user_pass = $pass1;
		}

		if ( empty( $account_first_name ) || empty( $account_last_name ) ) {
			wc_add_notice( __( 'Please enter your name.', 'woocommerce' ), 'error' );
		}

		if ( empty( $account_email ) || ! is_email( $account_email ) ) {
			wc_add_notice( __( 'Please provide a valid email address.', 'woocommerce' ), 'error' );
		} elseif ( email_exists( $account_email ) && $account_email !== $current_user->user_email ) {
			wc_add_notice( __( 'This email address is already registered.', 'woocommerce' ), 'error' );
		}

		if ( ! empty( $pass1 ) && empty( $pass2 ) ) {
			wc_add_notice( __( 'Please re-enter your password.', 'woocommerce' ), 'error' );
		} elseif ( ! empty( $pass1 ) && $pass1 !== $pass2 ) {
			wc_add_notice( __( 'Passwords do not match.', 'woocommerce' ), 'error' );
		}

		// Allow plugins to return their own errors.
		do_action_ref_array( 'user_profile_update_errors', array( &$errors, $update, &$user ) );

		if ( $errors->get_error_messages() ) {
			foreach ( $errors->get_error_messages() as $error ) {
				wc_add_notice( $error, 'error' );
			}
		}

		if ( wc_notice_count( 'error' ) == 0 ) {

			wp_update_user( $user );

			wc_add_notice( __( 'Account details changed successfully.', 'woocommerce' ) );

			do_action( 'woocommerce_save_account_details', $user->ID );

			wp_safe_redirect( get_permalink( wc_get_page_id( 'myaccount' ) ) );
			exit;
		}


	}


}
