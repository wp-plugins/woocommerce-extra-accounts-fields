<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 */
class woocommerce_extra_account_fields {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      woocommerce_extra_account_fields_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $woocommerce_extra_account_fields The string used to uniquely identify this plugin.
     */
    protected $woocommerce_extra_account_fields;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the Dashboard and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct ( $woocommerce_extra_account_fields, $version ) {

        $this->woocommerce_extra_account_fields = $woocommerce_extra_account_fields;
        $this->version                          = $version;
        $this->os_load_dependencies();
        $this->os_set_locale();
        $this->os_define_admin_panel();
        $this->os_define_public_fields();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function os_load_dependencies () {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-extra-account-fields-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-extra-account-fields-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the Dashboard.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-extra-account-fields-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce-extra-account-fields-public.php';

        $this->loader = new woocommerce_extra_account_fields_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the woocommerce_extra_account_fields_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function os_set_locale () {

        $plugin_i18n = new woocommerce_extra_account_fields_i18n();
        $plugin_i18n->set_domain( $this->get_woocommerce_extra_account_fields() );
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

    }


    /**
     * Define the admin panel setting fields
     */
    private function os_define_admin_panel () {
        $woocommerce_admin_extra = new Woocommerce_Extra_Account_Fields_Admin( $this->woocommerce_extra_account_fields, $this->version );
        $this->loader->add_action( 'admin_enqueue_scripts', $woocommerce_admin_extra, 'os_admin_enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $woocommerce_admin_extra, 'os_admin_enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $woocommerce_admin_extra, 'os_register_my_adminpanel' );
        $this->loader->add_action( 'admin_init', $woocommerce_admin_extra, 'os_register_setting_init' );
    }

    /**
     * Adding the fields for the plugins
     */
    private function os_define_public_fields() {
        $extra_fields = new Woocommerce_Extra_Account_Fields_Public( $this->woocommerce_extra_account_fields, $this->version );

        // adding the styling for front end
        $this->loader->add_action( 'wp_enqueue_scripts', $extra_fields, 'os_public_enqueue_styles' );
	    // adding the scripts
	    $this->loader->add_action( 'wp_enqueue_scripts', $extra_fields, 'os_public_enqueue_scripts' );

        // adding the html for the fields
        $this->loader->add_action( 'woocommerce_register_form', $extra_fields, 'os_woocommerce_extra_register_fields' );
        // validate the fields
        $this->loader->add_action( 'woocommerce_register_post', $extra_fields, 'os_woocommerce_validate_extra_register_fields', 10, 3 );
        // Save the data
        $this->loader->add_action( 'woocommerce_created_customer', $extra_fields, 'os_woocommerce_save_extra_register_fields' );


	    // Adding the fields for the edit page
	    $this->loader->add_filter( 'woocommerce_edit_account_form', $extra_fields, 'os_woocommerce_extra_register_fields' );
	    // save the added data in the edit page
	    $this->loader->add_action('init', $extra_fields, 'os_woocommerce_edit_account_save');


    }


    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run () {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_woocommerce_extra_account_fields () {
        return $this->woocommerce_extra_account_fields;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    woocommerce_extra_account_fields_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader () {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version () {
        return $this->version;
    }

}
