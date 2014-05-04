<?php
/**
 * @package Islamic Books by EDC
 * @version 1.0
 */
/*
 Plugin Name: Islamic Books by EDC
 Plugin URI: http://www.islam.com.kw/support
 Description: The Islamic Books Plugin by EDC endeavors to be a unique comprehensive online store of free downloadable PDF books about Islam, Muslims, and other faiths in different languages.
 Version: 1.0
 Author: EDC Team (E-Da`wah Committee)
 Author URI: http://www.islam.com.kw
 License: It is Free -_-
*/

include('functions.php');

function edc_free_books_plugin_install(){
     add_option( 'edc_free_books_form', '', '', 'yes' ); 
}
register_activation_hook(__FILE__,'edc_free_books_plugin_install'); 

function edc_free_books_plugin_scripts(){
	 wp_register_script('edc_free_books_plugin_scripts2',plugin_dir_url( __FILE__ ).'js/bxslider/jquery.min.js');
     wp_register_script('edc_free_books_plugin_scripts',plugin_dir_url( __FILE__ ).'js/bxslider/jquery.bxslider.min.js');
     wp_enqueue_script('edc_free_books_plugin_scripts2');
     wp_enqueue_script('edc_free_books_plugin_scripts');
}
add_action('wp_enqueue_scripts','edc_free_books_plugin_scripts'); 

function edc_free_books_plugin_styles() {
	wp_register_style( 'edc-styles2', plugin_dir_url( __FILE__ ).'style.css' );
	wp_register_style( 'edc-styles', plugin_dir_url( __FILE__ ).'js/bxslider/jquery.bxslider.css' );
	wp_enqueue_style( 'edc-styles' );
	wp_enqueue_style( 'edc-styles2' );
}
add_action( 'wp_enqueue_scripts', 'edc_free_books_plugin_styles' );

add_action('init','edc_free_books_plugin_init');


/* FUNCTIONS */

function edc_free_books_plugin_init(){
     run_sub_processs();
}

function run_sub_processs(){
  
} 

function edc_books_adminHeader() {
	echo "<style type=\"text/css\" media=\"screen\">\n";
	echo "#free-books { width:100%; margin:0; border:0px solid #cccccc; padding:0; }\n";
	echo "#free-books .widget { margin:0 auto; border:1px solid #cccccc; background-color:#fff; padding:10px; margin-right:15px; margin-top:15px; }\n";
	do_action('edc_css');
	echo "</style>\n";
}

add_action('admin_head','edc_books_adminHeader');
add_action( 'admin_menu', 'edc_books_plugin_menu' );

function edc_books_plugin_menu() {
	add_menu_page( 'Islamic Books', 'Islamic Books', 'manage_options', 'edc-free-books-edit', 'edc_free_books_options', ''.trailingslashit(plugins_url(null,__FILE__)).'/i/book.png' );
}

function edc_free_books_options() {
	global $books_languages;
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

if(isset($_POST['submitted']) && $_POST['submitted'] == 1){
$option_name = 'edc_free_books_form';
$new_value = $_POST['edc_free_books_form'];
$radio_width = $_POST['radio_width'];
$radio_height = $_POST['radio_height'];

if(isset($_POST['android'])){ $android = 'on'; }else{ $android = 'off'; }

if ( get_option( $option_name ) !== false ) {
	update_option( $option_name, $new_value );
	update_option( 'android', $android );
	update_option( 'edc_free_books_id', 0 );
	update_option( 'radio_title', addslashes($_POST['radio_title']) );
	update_option( 'radio_width', intval($_POST['radio_width']) );
	update_option( 'radio_height', intval($_POST['radio_height']) );
} else {
	add_option( $option_name, $new_value, null );
	add_option( 'android', 'on', null );
	add_option( 'edc_free_books_id', '0', null );
	add_option( 'radio_title', '', null );
	add_option( 'radio_width', '328', null );
	add_option( 'radio_height', '20', null );
}
}

if(get_option('android') == 'on'){ $check_1 = 'checked="checked"'; }else{ $check_1 = ''; }
$radio_title = strip_tags(get_option('radio_title'));
$radio_width = intval(get_option('radio_width'));
$radio_height = intval(get_option('radio_height'));

?>
	<div id="free-books">
	
			<div class="widget">				
				<h2>Islamic Books Plugin by EDC</h2>
				<br />
				The Islamic Books Plugin by EDC endeavors to be a unique comprehensive online store of free downloadable PDF books about Islam, Muslims, and other faiths in different languages.<br />
				<br />
				<a href="widgets.php">Insert Books by widgets.</a>
			</div>

	<div style="clear:both;"></div>
		</div>
<?php
}
