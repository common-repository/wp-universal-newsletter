<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://primitivespark.com
 * @since             1.0.0
 * @package           wp_universal_newsletter
 *
 * @wordpress-plugin
 * Plugin Name:       WP Universal Newsletter 
 * Plugin URI:        https://primitivespark.com/ideas/article/wp-universal-newsletter/
 * Description:       This plugin allows you to create a responsive HTML Email template via a Custom Post Type that can be scraped by iContact or GoDaddy for use in email campaigns.
 * Version:           1.1.1
 * Author:            Primitive Spark
 * Author URI:        http://primitivespark.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-universal-newsletter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/*function tl_save_error() {
    update_option( 'plugin_error',  ob_get_contents() );
}
add_action( 'activated_plugin', 'tl_save_error' );
/* Then to display the error message: */
#echo get_option( 'plugin_error' );

//Ensure the $wp_rewrite global is loaded
#global $wp_rewrite;
//Call flush_rules() as a method of the $wp_rewrite object
#$wp_rewrite->flush_rules( true );

/** Add Plugin Overview Page Links **/
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'wpun_action_links' );

function wpun_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=newsletter') ) .'">Configuration Options</a>';
   //$links[] = '<a href="https://primitivespark.com" target="_blank">Primtive Spark</a>';
   return $links;
}
/** Add new Post Type for the WP Newsletter **/
add_action( 'init', 'wpun_create_post_type' );

function wpun_create_post_type() {
    //Set up Defaults
    $post_slug = 'newsletter';
    $post_label = 'Newsletter';
    $with_front = false;
    $archive_slug = 'newsletters';
    
    //Get User defined Options first
    if(get_option('wp_newsletter_post_slug') != false && get_option('wp_newsletter_post_slug') != '') 
    $post_slug = get_option('wp_newsletter_post_slug');
    if(get_option('wp_newsletter_post_label') != false && get_option('wp_newsletter_post_label') != '') 
    $post_label = get_option('wp_newsletter_post_label');
    if(get_option('wp_newsletter_archive_slug') != false && get_option('wp_newsletter_archive_slug') != '') 
    $archive_slug = get_option('wp_newsletter_archive_slug');
    if(get_option('wp_newsletter_with_front') == true) $with_front = get_option('wp_newsletter_with_front');
    
	$labels = array(
		'name'               => _x( $post_label, 'post type general name', 'wpun-newsletter' ),
		'singular_name'      => _x( $post_label, 'post type singular name', 'wpun-newsletter' ),
		'menu_name'          => _x( $post_label, 'admin menu', 'wpun-newsletter' ),
		'name_admin_bar'     => _x( $post_label, 'add new on admin bar', 'wpun-newsletter' ),
		'add_new'            => _x( 'Add '.$post_label, 'wpun-newsletter' ),
		'add_new_item'       => __( 'Add ' .$post_label, 'wpun-newsletter' ),
		'new_item'           => __( 'New '.$post_label, 'wpun-newsletter' ),
		'edit_item'          => __( 'Edit '.$post_label, 'wpun-newsletter' ),
		'view_item'          => __( 'View '.$post_label, 'wpun-newsletter' ),
		'all_items'          => __( 'All '.$post_label.'s', 'wpun-newsletter' ),
		'search_items'       => __( 'Search '.$post_label.'s', 'wpun-newsletter' ),
		'parent_item_colon'  => __( 'Parent '.$post_label.'s:', 'wpun-newsletter' ),
		'not_found'          => __( 'No '.$post_label.'s found.', 'wpun-newsletter' ),
		'not_found_in_trash' => __( 'No '.$post_label.'s found in Trash.', 'wpun-newsletter' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Created by the WP Universal Newsletter Plugin', 'wpun-newsletter' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => $post_slug, 'with_front' => $with_front ),
		'capability_type'    => 'post',
        'has_archive'        => $archive_slug,
		'hierarchical'       => false,
		'menu_position'      => null,
        'menu_icon'          => 'dashicons-media-document', //Also can take an image URL
		'supports'           => array( 'title', 'editor','excerpt','thumbnail', 'title-tag'  )
	);

	register_post_type( 'wpun_newsletter', $args );
}


/** Add filter to load a custom template **/
add_filter( 'template_include', 'wpun_template_chooser');
 
 
/**
 * Returns template file
 *
 * @since 1.0
 */
 
function wpun_template_chooser( $template ) {
 
    // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'wpun_newsletter' ) {
        return $template;
    }
    
    //Grab the user override option
    $override = false;
    $override = get_option('wp_newsletter_single_override');
    
    // Is it the scrapable version?
    if ( get_post_type( $post_id ) == 'wpun_newsletter' && !isset($_GET['raw']) && !isset($_GET['preview']) && $override ){
        return $template;
    }
 
    // Else use custom template
    if ( is_single() ) {
        return wpun_get_template_hierarchy( 'wpun_single' );
    } elseif( is_archive()) {
        return wpun_get_template_hierarchy( 'wpun_archive' );
    } else {
        return $template;
    }
 
}

function wpun_get_template_hierarchy( $template ) {
 
    // Get the template slug
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';
 
    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    if ( $theme_file = locate_template( array( 'wpun_templates/' . $template ) ) ) {
        $file = $theme_file;
    }
    else {
        $file = plugin_dir_path( __FILE__ ) . '/templates/' . $template;
    }
 
    return apply_filters( $template, $file );
}

/** 
  Add Pagination to the Default Archive Page 
**/
 
// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function wpun_pagination(){
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

/***** 
    ADD CUSTOM FIELDS TO THE NEWSLETTER CONTENT TYPE
     
*****/
/** Add Meta Boxes **/

/** Repurpose the Excerpt Meta Box, Featured Image Box **/
add_filter( 'gettext', 'wpun_alter_excerpt', 10, 2 );
function wpun_alter_excerpt( $translation, $original )
{
    if ( 'Featured Image' == $original ) {
        return 'Promo Banner';
    }else{
       /* $pos = strpos($original, 'Excerpts are optional hand-crafted summaries of your');
        if ($pos !== false) {
            return  'Enter a Meta Description that will be is in the &lt;head&gt;';
        } */
    }
    return $translation;
}

// filter for Featured Thumbnail text
add_filter('admin_post_thumbnail_html', 'wpun_add_featured_image_dimensions', 10, 2);
function wpun_add_featured_image_dimensions($content, $post_id) {

  // If Newsletter Post Type, add featured image dimensions text
  if (get_post_type($post_id) == 'wpun_newsletter'){
    $width = (get_option('wp_newsletter_body_width') != "" ? get_option('wp_newsletter_body_width') : '620px');  
    $content .= '<p>Width for the Promo Image should be <strong>'.$width.'</strong></p>';
  }
  return $content;
}

/** 
    If the user is using in theme single.php, then we need to provide a raw link so they 
    can access the Optimized for HTML Email version :)
    
**/ 
add_filter ('edit_form_after_title','wpun_custom_post_title');
function wpun_custom_post_title($post) {
    $type = get_post_type($post->ID);
    if ($type == 'wpun_newsletter') {
		echo '<div class="inside" style="margin:5px 10px;">     
                <strong>Optimized HTML Link:</strong>
                <a href="'.get_permalink($post->ID).'?raw=true">'.get_permalink($post->ID).'?raw=true</a>
              </div>';
    }
}

/**
 * Calls the class on the post edit screen.
 */
function wpun_call_addMetaClass() {
	new wpun_metaClass();
}

if ( is_admin() ) {
	add_action( 'load-post.php', 'wpun_call_addMetaClass' );
	add_action( 'load-post-new.php', 'wpun_call_addMetaClass' );
}

/** 
 * The Class.
 */
class wpun_metaClass {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'wpun_add_meta_box' ) );
		add_action( 'save_post', array( $this, 'wpun_save' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function wpun_add_meta_box( $post_type ) {
		$post_types = array('wpun_newsletter');   //limit meta box to certain post types
		if ( in_array( $post_type, $post_types )) {
			add_meta_box(
				'wpun_newsletter_box_name'
				,__( 'WP Universal Newsletter Options', 'wpun_newsletter' )
				,array( $this, 'wpun_render_meta_box_content' )
				,$post_type
				,'advanced'
				,'high'
			);
		}
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function wpun_save( $post_id ) {
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['wpun_newsletter_inner_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['wpun_newsletter_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'wpun_newsletter_inner_custom_box' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page' ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post') )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user inputs.
		$subTitle = sanitize_text_field( $_POST['wp_newsletter_sub_title'] );
        $metaDescription = sanitize_text_field( $_POST['wp_newsletter_meta_description'] );
        $imgURL = sanitize_text_field( $_POST['wp_newsletter_image_url'] );
        $previewText = sanitize_text_field( $_POST['wp_newsletter_preview_text'] );

		// Update the meta fields.
		update_post_meta( $post_id, '_wp_newsletter_sub_title', $subTitle ); //Sub Title
        update_post_meta( $post_id, '_wp_newsletter_meta_description', $metaDescription ); // Meta Description
        update_post_meta( $post_id, '_wp_newsletter_image_url', $imgURL ); // URL for Featured Image
        update_post_meta( $post_id, '_wp_newsletter_preview_text', $previewText ); // URL for Featured Image
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function wpun_render_meta_box_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'wpun_newsletter_inner_custom_box', 'wpun_newsletter_inner_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$wp_newsletter_sub_title_value = get_post_meta( $post->ID, '_wp_newsletter_sub_title', true );
        $wp_newsletter_meta_description_value = get_post_meta( $post->ID, '_wp_newsletter_meta_description', true );
        $wp_newsletter_image_url_value = get_post_meta( $post->ID, '_wp_newsletter_image_url', true );
        $wp_newsletter_preview_text_value = get_post_meta( $post->ID, '_wp_newsletter_preview_text', true );

		// Display the form, using the current value.
        
		/*echo '<label for="wp_newsletter_sub_title">';
		_e( 'Enter a sub title for the Newsletter', 'wp_newsletter' );
		echo '</label> ';
		echo '<input type="text" id="wp_newsletter_sub_title" name="wp_newsletter_sub_title"';
		echo ' value="' . esc_attr( $value ) . '" size="50" />'; */
        ?>
        <p>
        <label for="wp_newsletter_sub_title"><strong><?php echo _e( 'Sub-title', 'wpun_newsletter' );?></strong></label><br />
		<input type="text" id="wp_newsletter_sub_title" name="wp_newsletter_sub_title" value="<?php echo esc_attr( $wp_newsletter_sub_title_value )?>" size="50" /><br />
        <span><?php echo _e( 'Enter a sub title for the Newsletter.', 'wp_newsletter' );?></span>
        </p>
        <p>
        <label for="wp_newsletter_meta_description"><strong><?php echo _e( 'Meta Description', 'wpun_newsletter' );?></strong></label><br />
		<textarea id="wp_newsletter_meta_description" name="wp_newsletter_meta_description" style="width:100%;" maxlength="300"/><?php echo esc_attr( $wp_newsletter_meta_description_value )?></textarea><br />
        <span><?php echo _e( 'Excerpt will be used if left blank.', 'wp_newsletter' );?></span>
        </p>
        <p>
        <label for="wp_newsletter_image_url"><strong><?php echo _e( 'Promo Banner URL', 'wpun_newsletter' );?></strong></label><br />
		<input type="text" id="wp_newsletter_image_url" name="wp_newsletter_image_url" value="<?php echo esc_attr( $wp_newsletter_image_url_value )?>" size="50" placeholder="http://someurl.com" /><br />
        <span><?php echo _e( 'If you added a Featured Image, you can add a link here.', 'wp_newsletter' );?></span>
        </p>
        <p>
        <label for="wp_newsletter_preview_text"><strong><?php echo _e( 'Email Preview Copy', 'wpun_newsletter' );?></strong></label><br />
		<textarea id="wp_newsletter_preview_text" name="wp_newsletter_preview_text" style="width:100%;" maxlength="300"/><?php echo esc_attr( $wp_newsletter_preview_text_value )?></textarea><br />
        <span><?php echo _e( 'Customize how your email preview text appears! Curious, just start typing above or <a href="https://litmus.com/blog/the-ultimate-guide-to-preview-text-support" target="_blank">Learn more</a>', 'wp_newsletter' );?></span>
        </p>
        <?php
            //Get Johnson Box text
            $jbox = get_the_excerpt();
            if($wp_newsletter_preview_text_value != "" && $wp_newsletter_preview_text_value != false){
                $jbox = $wp_newsletter_preview_text_value;
            }
        ?>
        <div>
            <h4>Johnson Box Preview</h4>
            <?php $src = plugins_url( 'img/', __FILE__ )."johnson-b.jpg"; ?>
            <div class="j-box" style="background: url(<?php echo $src; ?>) 0 0 no-repeat transparent;">
                <div id="from">
                    <?php echo get_bloginfo('name'); ?>
                </div>
                <div id="subject">
                    <?php echo get_the_title($post->ID); ?>
                </div>
                <div id="jbox">
                    <?php echo $jbox; ?>
                </div>
            </div>
        </div>
        <script>
            jQuery(document).ready( function($){
                var excerpt = "<?php echo get_the_excerpt(); ?>";
                $('#wp_newsletter_preview_text').on('keyup blur', function(){
                    var html = $(this).val();
                    if(html == ""){
                        html = excerpt;
                    }
                  $('#jbox').html(html)  
                });
               ; 
            });
        </script>
        
        <?php 
	}
}

add_action('admin_head', 'wpun_tinymce_plugins');

function wpun_tinymce_plugins(){
add_filter( 'mce_external_plugins', 'wpun_button_link', 10, 1 );
}

/* Function adds editor-class js file
   This adds: rel="nofollow" and class="button" Options 
   when creating links with the WYSIWYG Editor
    
*/
function wpun_button_link($plugin_array) {
    global $post_type;
    if($post_type == 'wpun_newsletter'){
        $plugin_array['my_button_link'] = plugin_dir_url( __FILE__ ) . 'admin/js/editor-class.min.js';
        return $plugin_array;
    }
}


/** Add Newsletter Menu option to Admin Menu **/
add_action('admin_menu', 'wpun_admin_menu');

function wpun_admin_menu() {
	add_options_page(__('WP Universal Newsletter', 'wpun-newsletter'), __('WP Universal Newsletter', 'wpun-newsletter'), 'manage_options', 'newsletter', 'wpun_newsletter_home');
}

function wpun_newsletter_home(){
    include_once plugin_dir_path( __FILE__ ) . 'admin/partials/wp-newsletter-admin-display.php';
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-newsletter-activator.php
 */
function wpun_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-newsletter-activator.php';
	wpun_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-newsletter-deactivator.php
 */
function wpun_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-newsletter-deactivator.php';
	wpun_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'wpun_activate' );
register_deactivation_hook( __FILE__, 'wpun_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-newsletter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function wpun_run_wp_newsletter() {

	$plugin = new wp_universal_newsletter();
	$plugin->run();

}
wpun_run_wp_newsletter();