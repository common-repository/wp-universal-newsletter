<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 * @package    wp-universal-newsletter
 * @subpackage wp-universal-newsletter/includes
 * @author     Brett Exnowslki <bexnowski@primitivespark.com>
 */
 
?>
<?php
//If they are updating options, might be a good idea to flush permalink rules!!!

//Ensure the $wp_rewrite global is loaded
global $wp_rewrite;
//Call flush_rules() as a method of the $wp_rewrite object
$wp_rewrite->flush_rules( true );

// UPLOAD ENGINE
function wpun_load_wp_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'wpun_load_wp_media_files' );

wp_enqueue_media();

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1>WP Universal Newsletter
        <a 
        class="page-title-action" 
        href="<?php echo get_admin_url();?>post-new.php?post_type=wpun_newsletter">Add 
        <?php echo (get_option('wp_newsletter_post_label') != false ? get_option('wp_newsletter_post_label') : "Newsletter"); ?>
        </a>
    </h1>
    <h2>Options</h2>
    <p>Configure the options below to control how you'd like your newsletter to appear on the front end.  The placeholder values correspond to the plugin defaults.</p>
<form method="post" action="options.php">
	<?php wp_nonce_field('update-options') ?>

        <p><label for="wp_newsletter_header"><strong>Hide Header:</strong></label><br />
        <em>By default, the logo chosen below and the date will be displayed in the header. Check to hide it</em><br />
	<input type="checkbox" id="wp_newsletter_header" name="wp_newsletter_header" size="90" value="true" <?php if(get_option('wp_newsletter_header') == true) echo "checked"; ?>/></p>
        <p><label for="logo"><strong>Company Logo:</strong></label><br />
        <em>By default we use your site logo, located in the theme directory. Leave this field blank to use your default logo, or else update the url path below if it is somewhere else OR upload a new one! <br />Lets try and keep it at a max width of 150px please :)
        <br/> Current Theme Directory:</em> <?php echo get_bloginfo('template_url').'/' ?>
	<input type="text" name="wp_newsletter_logo" id="logo" size="90" value="<?php echo get_option('wp_newsletter_logo'); ?>" placeholder="<?php echo get_bloginfo('template_url');?>/images/logo.png" data-url="<?php echo get_bloginfo('template_url');?>"/>
    <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
    <?php 
        if(get_option('wp_newsletter_logo') != ''){
            $img = get_option('wp_newsletter_logo');
        } else {
            $img = get_bloginfo('template_url').'/images/logo.png';
        }
    ?>
    <img src="<?php echo $img; ?>" id="logo-preview" style="display:block;margin:20px;max-width:150px;"/>
    </p>
    <hr />
    <h2>Styling Options</h2>
    <p><label for="wp_newsletter_bg_color"><strong>Body Color:</strong></label><br />
	<input type="text" id="wp_newsletter_html_bg_color" name="wp_newsletter_html_bg_color" size="90" value="<?php echo ( get_option('wp_newsletter_html_bg_color') != "" ?  get_option('wp_newsletter_html_bg_color') : "#ffffff" );  ?>" placeholder="#ffffff" class="hasColor" data-default-color="#ffffff"/></p>
    
    <p><label for="wp_newsletter_bg_color"><strong>Content Background Color:</strong></label><br />
	<input type="text" id="wp_newsletter_bg_color" name="wp_newsletter_bg_color" size="90" value="<?php echo ( get_option('wp_newsletter_bg_color') != "" ?  get_option('wp_newsletter_bg_color') : "#ffffff" );  ?>" placeholder="#ffffff" class="hasColor" data-default-color="#ffffff"/></p>
    
    <p><label for="wp_newsletter_body_width"><strong>Body Width:</strong></label><br />
	<input type="text" id="wp_newsletter_body_width" name="wp_newsletter_body_width" size="90" value="<?php echo get_option('wp_newsletter_body_width'); ?>" placeholder="620px"/></p>
    
    <p><label for="wp_newsletter_body_padding"><strong>Body Padding:</strong></label><br />
	<input type="text" id="wp_newsletter_body_padding" name="wp_newsletter_body_padding" size="90" value="<?php echo get_option('wp_newsletter_body_padding'); ?>" placeholder="20px"/></p>
    
    <p><label for="wp_newsletter_body_border_color"><strong>Body Border:</strong></label><br />
    <em>Set this using border shorthand notation to avoid errors. i.e. <i>1px solid #efefef</i></em><br />
	<input type="text" id="wp_newsletter_body_border_color" name="wp_newsletter_body_border_color" size="90" value="<?php echo ( get_option('wp_newsletter_body_border_color') != "" ?  get_option('wp_newsletter_body_border_color') : "" );  ?>" placeholder="1px solid #ffffff"/></p>
    
    <p><label for="wp_newsletter_font_family"><strong>Font Family:</strong></label><br />
	<input type="text" id="wp_newsletter_font_family" name="wp_newsletter_font_family" size="90" value="<?php echo get_option('wp_newsletter_font_family'); ?>" placeholder="Arial, sans-serif"/></p>
    
    <p><label for="wp_newsletter_font_color"><strong>Font Color:</strong></label><br />
	<input type="text" id="wp_newsletter_font_color" name="wp_newsletter_font_color" size="90" value="<?php echo ( get_option('wp_newsletter_font_color') != "" ?  get_option('wp_newsletter_font_color') : "#333333" );  ?>" placeholder="#333333" class="hasColor" data-default-color="#333333"/></p>
    
    <p><label for="wp_newsletter_text_size"><strong>Text Size:</strong></label><br />
	<input type="text" id="wp_newsletter_text_size" name="wp_newsletter_text_size" size="90" value="<?php echo get_option('wp_newsletter_text_size'); ?>" placeholder="13px"/></p>
    
	<p><label for="wp_newsletter_link_color"><strong>Link Color:</strong></label><br />
	<input type="text" id="wp_newsletter_link_color" name="wp_newsletter_link_color" size="90" value="<?php echo ( get_option('wp_newsletter_link_color') != "" ?  get_option('wp_newsletter_link_color') : "#06C" ); ?>" placeholder="#06C" class="hasColor" data-default-color="#06C"/></p>
    
    <p><label for="wp_newsletter_link_hover_color"><strong>Link Hover Color:</strong></label><br />
	<input type="text" id="wp_newsletter_link_hover_color" name="wp_newsletter_link_hover_color" size="90" value="<?php echo ( get_option('wp_newsletter_link_hover_color') != "" ?  get_option('wp_newsletter_link_hover_color') : "#039" ); ?>" placeholder="#039" class="hasColor" data-default-color="#039"/></p>
    
    <p><label for="wp_newsletter_heading_color"><strong>Heading Color:</strong></label><br />
	<input type="text" id="wp_newsletter_heading_color" name="wp_newsletter_heading_color" size="90" value="<?php echo ( get_option('wp_newsletter_heading_color') != "" ?  get_option('wp_newsletter_heading_color') : "#666666" ); ?>" placeholder="#666666" class="hasColor" data-default-color="#666666"/></p>
    
    <p><label for="wp_newsletter_button_bg_color"><strong>Button Background Color:</strong></label><br />
	<input type="text" id="wp_newsletter_button_bg_color" name="wp_newsletter_button_bg_color" size="90" value="<?php echo ( get_option('wp_newsletter_button_bg_color') != "" ?  get_option('wp_newsletter_button_bg_color') : "#06C" ); ?>" placeholder="#06C" class="hasColor" data-default-color="#06C"/></p>
    
    <p><label for="wp_newsletter_button_text_color"><strong>Button Text Color:</strong></label><br />
	<input type="text" id="wp_newsletter_button_text_color" name="wp_newsletter_button_text_color" size="90" value="<?php echo ( get_option('wp_newsletter_button_text_color') != "" ?  get_option('wp_newsletter_button_text_color') : "#ffffff" ); ?>" placeholder="#ffffff" class="hasColor" data-default-color="#ffffff"/></p>
    <hr />
    <h2>Formatting Options</h2>
    <p><label for="wp_newsletter_date_format"><strong>Date Format:</strong></label><br />
    <em>This will be the published date of the Post.</em><br />
    <!--
    Consider this in Paid Version, Absolute Control over Format via php date(); 
    <em>Use <a href="http://php.net/manual/en/function.date.php">php date()</a> parameters</em><br />
	<input type="text" name="wp_newsletter_button_date_format" size="90" value="<?php echo get_option('wp_newsletter_date_format'); ?>" placeholder="M Y"/>
    -->
    <select id="wp_newsletter_date_format" name="wp_newsletter_date_format" data-value="<?php echo ( get_option('wp_newsletter_date_format') != "" ?  get_option('wp_newsletter_date_format') : "F d, Y" ); ?>">
      <option value="F d, Y">April 20, 2008</option>
      <option value="m/d/Y">4/20/2008</option>
      <option value="l, F d, Y">Sunday, April 20, 2008</option>
      <option value="m/d/y">4/20/08</option>
      <option value="Y-m-d">2008-04-20</option>
      <option value="d-M-y">20-Apr-08</option>
      <option value="m.d.Y">4.20.2008</option>
      <option value="m.d.y">4.20.08</option>
      <option value="d.m.Y">20.04.2008</option>
    </select>
    </p>
    <p><label for="wp_newsletter_google_parameters"><strong>URL Tracking Paramters:</strong></label><br />
    <em>Append content links with Google tracking parameters <a href="https://support.google.com/analytics/answer/1033867?hl=en">Help</a></em><br />
    <em>The Following tokens are avaliable for use:</em><br />
    <ul>
        <li><strong>[date]</strong></li>
    </ul> 
	<input type="text" id="wp_newsletter_google_parameters" name="wp_newsletter_google_parameters" size="90" value="<?php echo get_option('wp_newsletter_google_parameters'); ?>" placeholder="utm_source=newsletter&utm_medium=email&utm_campaign=[date]"/></p>
    
    <p><label for="wp_newsletter_google_analytics"><strong>Google Analytics:</strong></label><br />
    <em>Enter a Google Analytics Code to enable. Note* Only used in this plugins single.php template.</em><br />
	<input type="text" id="wp_newsletter_google_analytics" name="wp_newsletter_google_analytics" size="90" value="<?php echo get_option('wp_newsletter_google_analytics'); ?>" placeholder="UA-XXXXXXXX-1"/></p>
    
    <p><label for="wp_newsletter_outlook"><strong>Optimize for Outlook</strong></label><br />
    <em>Will include Conditional statements in code to optimize formatting for Microsoft Outlook Clients</em><br />
	<input type="checkbox" name="wp_newsletter_outlook" size="90" value="true" <?php if(get_option('wp_newsletter_outlook') !== "" ) echo "checked"; ?>/></p>
    <p><label for="wp_newsletter_footer"><strong>Custom HTML Footer:</strong></label><br />
    <em>Create a custom HTML Footer. The Following tokens are avaliable for use:</em><br />
    <ul>
        <li><strong>[year]</strong></li>
        <li><strong>[site-name]</strong></li>
        <li><strong>[page-URL]</strong></li>
        <li><strong>[view-in-browser]</strong></li>
    </ul>
	<textarea id="wp_newsletter_footer" name="wp_newsletter_footer" value="" placeholder="© [year] [site-name]. All rights reserved.<br /><br /> [view-in-browser]" rows="3" style="width:100%;"><?php echo get_option('wp_newsletter_footer'); ?></textarea></p>
    
    <hr />
    <h2>Social Share Options</h2>
    <p><label for="wp_newsletter_socialize"><strong>Social Share Icons</strong></label><br />
    <em>If checked, Social Share buttons will be included in the footer (Email, Facebook, Twitter, LinkedIn, Google+) </em><br />
	<input type="checkbox" id="wp_newsletter_socialize" name="wp_newsletter_socialize" value="true" <?php if(get_option('wp_newsletter_socialize') != false) echo "checked"; ?>/></p>
    
    <hr />
    <h2>Post Type Options</h2>
    <p><label for="wp_newsletter_post_label"><strong>Post Type Label:</strong></label><br />
    <em>Will be used in Menu Labels</em><br />
	<input type="text" id="wp_newsletter_post_label" name="wp_newsletter_post_label" size="90" value="<?php echo get_option('wp_newsletter_post_label'); ?>" placeholder="Newsletter"/></p>
    
    <p><label for="wp_newsletter_post_slug"><strong>Post Type Slug:</strong></label><br />
    <em>Will be used in the permalink structure. i.e. <?php bloginfo('url'); ?>/newsletter/some-title/</em><br />
	<input type="text" id="wp_newsletter_post_slug" name="wp_newsletter_post_slug" size="90" value="<?php echo get_option('wp_newsletter_post_slug'); ?>" placeholder="newsletter"/></p>
    
    <p><label for="wp_newsletter_with_front"><strong>Permalink Structure with Front</strong></label><br />
    <em>If checked true, Post Type Slug will be prepended with site slug. i.e True = blog/newsletter/*. false = /newsletter/* </em><br />
	<input type="checkbox" id="wp_newsletter_with_front" name="wp_newsletter_with_front" size="90" value="true" <?php if(get_option('wp_newsletter_with_front') == true) echo "checked"; ?>/></p>
    
    <p><label for="wp_newsletter_archive_slug"><strong>Archive Slug:</strong></label><br />
    <em>Will be used in the permalink structure for the archive page. i.e.  <?php bloginfo('url'); ?>/newsletters</em><br />
	<input type="text" id="wp_newsletter_archive_slug" name="wp_newsletter_archive_slug" size="90" value="<?php echo get_option('wp_newsletter_archive_slug'); ?>" placeholder="newsletters"/></p>
    
    <p><label for="wp_newsletter_single_override"><strong>Use current themes single.php file.</strong></label><br />
    <em>If checked, your active themes single.php file will be used for displaying the content, which will not be optimized for HTML Email. Optimized HTML can still be accessed by appending a ?raw=true parameter to the post URL. Only check this if you know how to edit single.php file, as this may cause undesired results! Newsletter Custom fields and global settings set on this page wont be included in your themes single.php by default. </em><br />
	<input type="checkbox" id="wp_newsletter_single_override" name="wp_newsletter_single_override" size="90" value="true" <?php if(get_option('wp_newsletter_single_override') == true) echo "checked"; ?>/></p>
    
    

    
	<p>
    <input type="submit" name="Submit" value="Update Options" class="button add-new-h2" />
	<input type="hidden" name="action" value="update" />
    <!-- Probably a better way to save the options :( -->
	<input type="hidden" name="page_options" value="wp_newsletter_logo,wp_newsletter_link_color,wp_newsletter_outlook,wp_newsletter_text_size,wp_newsletter_google_parameters,wp_newsletter_date_format,wp_newsletter_button_text_color,wp_newsletter_button_bg_color,wp_newsletter_heading_color,wp_newsletter_link_color,wp_newsletter_font_family,wp_newsletter_body_width,wp_newsletter_bg_color,wp_newsletter_google_analytics,wp_newsletter_post_slug,wp_newsletter_archive_slug,wp_newsletter_with_front,wp_newsletter_post_label,wp_newsletter_link_hover_color,wp_newsletter_footer,wp_newsletter_body_border_color,wp_newsletter_socialize,wp_newsletter_font_color,wp_newsletter_single_override,wp_newsletter_header,wp_newsletter_html_bg_color,wp_newsletter_body_padding" />
    </p>

	</form>
</div><!-- end wrap -->


