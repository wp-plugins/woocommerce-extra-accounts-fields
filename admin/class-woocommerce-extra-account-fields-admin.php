<?php

class Woocommerce_Extra_Account_Fields_Admin {


    private $text_domain;
    private $version;
    private $title;
    private $options;

    public function __construct ( $woocommerce_extra_account_fields, $version ) {
        $this->title       = __( 'Extra Fields', $woocommerce_extra_account_fields );
        $this->text_domain = $woocommerce_extra_account_fields;
        $this->version     = $version;
        $this->options     = get_option( 'woocommerce_extra_fields_setting_name' );
    }

    /**
     * Register the stylesheets for the Dashboard.
     *
     * @since    1.0.0
     */
    public function os_admin_enqueue_styles () {

        wp_enqueue_style( 'woocommerce_extra_fields_styles_font_awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'woocommerce_extra_fields_styles_admin', plugin_dir_url( __FILE__ ) . 'css/custom-admin.css', array(), $this->version, 'all' );


    }

    /**
     * Register the JavaScript for the dashboard.
     *
     * @since    1.0.0
     */
    public function os_admin_enqueue_scripts () {

        wp_enqueue_script( 'woocommerce_extra_fields_scripts_admin', plugin_dir_url( __FILE__ ) . 'js/admin-custom-script.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), $this->version, FALSE );

    }

    public function os_register_my_adminpanel () {
        add_submenu_page( 'woocommerce', $this->title, $this->title, 'manage_options', 'woocommerce_extra_submenu_page', array(
            $this,
            'os_woocommerce_extra_fields_options_page'
        ) );
    }

    /*
     * Register the setting for the admin page
     */
    public function os_register_setting_init () {
        register_setting( 'woocommerce_extra_fields_setting_group', 'woocommerce_extra_fields_setting_name' );
        register_setting( 'woocommerce_extra_fields_setting_group', 'woocommerce_extra_dropdown_fields_name' );
    }

    /*
     * Adding the admin page
     */
    public function os_woocommerce_extra_fields_options_page () {
        require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/woocommerce-extra-fields-admin_view.php';
    }
}
