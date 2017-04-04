<?php 
/**
 * @package MC_Divi_Custom_Modules
 * @version 1.0.0
 */
/*
* Plugin Name: MC Divi Custom Modules
* Plugin URI: 
* Version: 1.0.0
* Description: MC Divi Custom Modules include some custom modules for Divi theme
* Author: Marie Comet
* Author URI: http://mariecomet.fr
* License: GPL2
* Text-domain: mc-dcm
*/
/**
*
* Escape is someone tries to access directly
*
**/
if ( ! defined( 'ABSPATH') ) {
    exit;
}
/**
*
* Call the translation file
*
**/
add_action('init', 'mc_dcm_load_translation_file');
function mc_dcm_load_translation_file() {
    // relative path to WP_PLUGIN_DIR where the translation files will sit:
    $plugin_path = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
    load_plugin_textdomain( 'mc-dcm', false, $plugin_path );
}

/**
 * Main plugin class
 *
 * @since 0.1
 **/
class MC_Divi_Custom_Modules {
	
	/**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

	/**
	 * Class contructor
	 *
	 * @since 0.1
	 **/
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
		//call register settings function
		add_action( 'admin_init', array($this, 'mc_dcm_settings' ));
		
	}

	/**
	 * Add administration menus
	 *
	 * @since 0.1
	 **/
	public function add_admin_pages() {

		//create new top-level menu
		add_submenu_page( 
            'options-general.php', 
            __( 'Divi Custom Modules', 'mc-dcm' ),
            __( 'Divi Custom Modules', 'mc-dcm' ),
            'manage_options', 
            'mc-dcm-settings', 
            array( $this,'mc_dcm_settings_page') 
        );
		
	}

	/**
	* Add administration page
	*
	* @since 0.1
	**/
	public function mc_dcm_settings_page() {		
	
	// Set class property
    $this->options = get_option( 'mc_dcm_option' );
    ?>
    <div class="wrap">
        <h1>Modules personnalisés pour Divi</h1>
        <form method="post" action="options.php">
        <?php
            // This prints out all hidden setting fields
            settings_fields( 'mc_dcm_group' );
            do_settings_sections( 'mc-dcm-settings' );
            submit_button();
        ?>
        </form>
    </div>
<?php }
	
	/**
     * Register and add settings
     */
    public function mc_dcm_settings()
    {        
        register_setting(
            'mc_dcm_group', // Option group
            'mc_dcm_option' // Option name
        );

        add_settings_section(
            'mc_dcm_section', // ID
            'Modules', // Title
            array( $this, 'print_section_info' ), // Callback
            'mc-dcm-settings' // Page
        );  

        add_settings_field(
            'choose_post', // ID
            'Articles choisis', // Title 
            array( $this, 'choose_post_callback' ), // Callback
            'mc-dcm-settings', // Page
            'mc_dcm_section' // Section           
        );
        add_settings_field(
            'choose_product', // ID
            'Produits choisis', // Title 
            array( $this, 'choose_product_callback' ), // Callback
            'mc-dcm-settings', // Page
            'mc_dcm_section' // Section           
        ); 
        add_settings_field(
            'carousel', // ID
            'Carousel', // Title 
            array( $this, 'carousel_callback' ), // Callback
            'mc-dcm-settings', // Page
            'mc_dcm_section' // Section           
        ); 
        add_settings_field(
            'custom_slider', // ID
            'Slider Posts', // Title 
            array( $this, 'custom_slider_callback' ), // Callback
            'mc-dcm-settings', // Page
            'mc_dcm_section' // Section           
        );   
        add_settings_field(
            'filter_posts', // ID
            'Articles filtrables', // Title 
            array( $this, 'filter_posts_callback' ), // Callback
            'mc-dcm-settings', // Page
            'mc_dcm_section' // Section           
        );          
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Sélectionnez les modules que vous souhaitez activer :';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function choose_post_callback()
    {	?>
    	<input type="checkbox" id="choose_post" name="mc_dcm_option[choose_post]" value="1" <?php isset($this->options['choose_post'] ) ? checked( $this->options['choose_post'], 1, true ) : '' ?> />
    <?php   
    }
    public function choose_product_callback()
    {	?>
    	<input type="checkbox" id="choose_product" name="mc_dcm_option[choose_product]" value="1" <?php isset($this->options['choose_product'] ) ? checked( $this->options['choose_product'], 1, true ) : '' ?> />
    <?php  
    }
    public function carousel_callback()
    {	?>
    	<input type="checkbox" id="carousel" name="mc_dcm_option[carousel]" value="1" <?php isset($this->options['carousel'] ) ? checked( $this->options['carousel'], 1, true ) : '' ?> />
    <?php  
    }
    public function custom_slider_callback()
    {	?>
    	<input type="checkbox" id="custom_slider" name="mc_dcm_option[custom_slider]" value="1" <?php isset($this->options['custom_slider'] ) ? checked( $this->options['custom_slider'], 1, true ) : '' ?> />
    <?php  
    }
    public function filter_posts_callback()
    {   ?>
        <input type="checkbox" id="filter_posts" name="mc_dcm_option[filter_posts]" value="1" <?php isset($this->options['filter_posts'] ) ? checked( $this->options['filter_posts'], 1, true ) : '' ?> />
    <?php  
    }
}

if( is_admin() )
$my_settings_page = new MC_Divi_Custom_Modules();

add_action('after_setup_theme', 'include_modules');

function include_modules() {
	$options = get_option( 'mc_dcm_option' );

    foreach($options as $option => $value) {
    	require_once(plugin_dir_path( __FILE__ ) . 'modules/'. $option .'/'. $option .'.php');
    }
}
