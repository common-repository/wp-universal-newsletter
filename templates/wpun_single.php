<?php
 /* 
	
	@date 2015-1-23
	@author Primitive Spark
	@description Create an HTML Email or newsletter while levaraging WordPress 
	backend then importing into a 3rd party CRM like iContact or MailChimp

*/
 
 // Uncomment these to Turn on Errors for this page
    #ini_set('display_errors','on');
	#error_reporting(E_ALL);
		
if (have_posts()): while (have_posts()) : the_post();

// If its a bot, let it scrape the page. Are we redirecting to a in-theme page?

// Define the URL
if(isset($_GET['preview'])){$preview = true;} else{ $preview = false;}
if(isset($_GET['load'])){$load = true; $preview = true;} else{ $load = false;}
$url = $_SERVER['SERVER_NAME']; 

if(!preg_match('/FacebookExternalHit|LinkedInBot|googlebot|Facebot|robot|spider|crawler|curl|^$/i', $_SERVER['HTTP_USER_AGENT'])){
	// Dont redirect if its being loaded via lightbox
	if(!$preview || (!$load && !$preview)){
		#header("Location:http://".$url.$ext);
	}
}

/**
    MODIFY EXCERPTS FOR USE IN META DESCRIPTION
**/
/* Remove More link from excpert */
function wpun_excerpt_more($more) {
    return "";
    }
add_filter('excerpt_more', 'wpun_excerpt_more');

function wpun_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'wpun_excerpt_length', 999 );

/**
    DEFINE THE CONTENT
**/
/* URL */
$page_url = get_permalink(); 
/* Page Title */
$title = get_the_title();
/* Custom Field: Sub Title */
$sub_title = get_post_meta($post->ID, '_wp_newsletter_sub_title', true);
/* Date */
$dateFormat = "M-Y";
/* URL Friendly date */
$URL_date = get_the_date('M-Y');
/* Meta Description */
$meta_description = get_the_excerpt();
/* Preview Text */
$preview_text = $meta_description;
/* Twitter Text */ 
$twitter_text = $title;
/* Email Share Subject Line */
$emailSubject = $title;
/* LinkedIn Title */
$linkedInTitle = $title;
/* LinkedIn Title */
$linkedInDesc = $meta_description;


/**
    TEMPLATE GLOBAL DEFAULT SETTINGS
**/
/* Global BG Color */
$globalBG = "#fff";
/* Background Color */
$bodyBG = "#fff";
/* Body padding */
$padding = "20px";
/* Body width */
$bodyWidth = "620px";
/* Border Color */
$bodyBorder = "0px solid #fff";
/* Link Color */
$linkColor = "#06C";
/* Link Color */
$linkHoverColor = "#039";
/* Heading Color */
$headingColor = "#666";
/* Button BG Color */
$buttonColor = "#06C";
/* Button Text Color */
$buttonTextColor = "#fff";
/* Font Family */
$fontFamily = "Arial, sans-serif";
/* Font Color */
$fontColor = "#333";
/* Text Size */
$textSize = "13px";
/* Date format */
$dateFormat = 'M Y';
/* Google URL Parameters */
$google_parameters = "?utm_source=newsletter&utm_medium=email&utm_campaign=".$URL_date;
/* Outlook Optimized */
$outlookify = true;
/* Default Image Directory */
$imgDir = plugins_url( 'img/', __FILE__ );
/* Social Icon Width */
$socialIconWidth = "50px";
/* Social Icons */
$socialize = true;
/* Footer HTML */
$footer  = "© [year] [site-name]. All rights reserved.<br />";

/* Facebook App ID - For Sharing */
$fbAppID = "966242223397117"; //Default

/* Default Social Images */
$facebook = $imgDir.'fb.jpg';
$email = $imgDir.'email.jpg';
$twitter = $imgDir.'twitter.jpg';
$google = $imgDir.'google.jpg';
$linkedin = $imgDir.'linkedin.jpg';

/* LOGO */
/* Default - looks for logo.png in active theme folder */
$logoImg = get_bloginfo('template_url').'/images/logo.png'; 

/**
    USER OPTIONS
**/
//User Defined Options cound in wp-newsletter-admin-display.php
/* Heading Color */ 
if("" !== get_option('wp_newsletter_heading_color') && get_option('wp_newsletter_heading_color') != NULL)
$headingColor = get_option('wp_newsletter_heading_color');
/* Body width */ 
if("" !== get_option('wp_newsletter_body_width') && get_option('wp_newsletter_body_width') != NULL)
$bodyWidth = get_option('wp_newsletter_body_width'); 
/* Body Border Color */ 
if("" !== get_option('wp_newsletter_body_border_color') && get_option('wp_newsletter_body_border_color') != NULL)
$bodyBorder = get_option('wp_newsletter_body_border_color');
if(get_option('wp_newsletter_body_border_color') == 'none') $bodyBorder = 'none';
/* Global Background Color */
if("" !== get_option('wp_newsletter_html_bg_color') && get_option('wp_newsletter_html_bg_color') != NULL)
$globalBG = get_option('wp_newsletter_html_bg_color');
/* Background Color */
if("" !== get_option('wp_newsletter_bg_color') && get_option('wp_newsletter_bg_color') != NULL)
$bodyBG = get_option('wp_newsletter_bg_color');
/* Body Padding */
if("" !== get_option('wp_newsletter_body_padding') && get_option('wp_newsletter_body_padding') != NULL)
$padding = get_option('wp_newsletter_body_padding');
/* Link Color */
if("" !== get_option('wp_newsletter_link_color') && get_option('wp_newsletter_link_color') != NULL)
$linkColor = get_option('wp_newsletter_link_color');
/* Link Hover Color */
if("" !== get_option('wp_newsletter_link_color') && get_option('wp_newsletter_link_color') != NULL)
$linkHoverColor = get_option('wp_newsletter_link_color');
/* Button BG Color */
if("" !== get_option('wp_newsletter_button_bg_color') && get_option('wp_newsletter_button_bg_color') != NULL)
$buttonColor = get_option('wp_newsletter_button_bg_color');
/* Button Text Color */
if("" !== get_option('wp_newsletter_button_text_color') && get_option('wp_newsletter_button_text_color') != NULL )
$buttonTextColor = get_option('wp_newsletter_button_text_color');
/* Font Family */
if(get_option('wp_newsletter_font_family') !== "" && get_option('wp_newsletter_font_family') != NULL )
$fontFamily = get_option('wp_newsletter_font_family');
/* Text Size */
if(get_option('wp_newsletter_text_size') !== "" && get_option('wp_newsletter_text_size') != NULL )
$textSize = get_option('wp_newsletter_text_size');
/* Date Format */
if(get_option('wp_newsletter_date_format') !== "" && get_option('wp_newsletter_date_format') != NULL )
$dateFormat = get_option('wp_newsletter_date_format');
/* Date Format */
if(get_option('wp_newsletter_logo') !== "" && get_option('wp_newsletter_logo') != NULL )
$logoImg = get_option('wp_newsletter_logo');
/* Outlook Optimized? */
$outlookify = (get_option('wp_newsletter_outlook')  == true ? true : false);
/* Add Social Icons? */
$socialize = (get_option('wp_newsletter_socialize') == true ? true : false);
/* HTML Footer */
if(get_option('wp_newsletter_footer') !== "" && get_option('wp_newsletter_footer') != NULL )
$footer = get_option('wp_newsletter_footer');
/* Google Parameters */
if(get_option('wp_newsletter_google_parameters') !== "" && get_option('wp_newsletter_google_parameters') != NULL )
$google_parameters = get_option('wp_newsletter_google_parameters');
$google_parameters = str_replace('[date]', date('m-Y'), $google_parameters);//Replace shortcode if present
/* FB App ID */
if(get_option('wp_newsletter_fb_app_id') !== "" && get_option('wp_newsletter_fb_app_id') != NULL )
$fbAppID = get_option('wp_newsletter_fb_app_id');
/* Hide Header */
$hideHeader = (get_option('wp_newsletter_header')  == true ? true : false);

/* Define Button Styles */
$buttonStyles ='font-weight:bold;font-size:'.$textSize.';color:'.$buttonTextColor.';display:inline-block;line-height:36px;min-width:170px;background:'.$buttonColor.';text-decoration:none;text-align:center;-webkit-text-size-adjust:none;';

/* Hide <a> buttons from Outlook? */
if($outlookify) $buttonStyles = $buttonStyles.'mso-hide:all;';

/* Outlook Vector Button Markup */
$preButton = '<!--[if mso]><v:rect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="#" style="height:36px;v-text-anchor:middle;width:170px;" fillcolor="'.$buttonColor.'" strokecolor="'.$buttonColor.'"><w:anchorlock/><center style="color:'.$buttonTextColor.';font-family:'.$fontFamily.';'.$textSize.'">{text}</center></v:rect><![endif]--><!--[if !mso]><!-->';
$postButton = '<!--<![endif]-->';


/**
    LAYOUT OPTIONS
**/
//Is Promo area Vertical or Horizontal
//$orientation = get('default_orientation'); 

/** 
    META FIELDS 
**/
/* Meta Description */
if(get_post_meta( $post->ID, '_wp_newsletter_meta_description', true ) != "" && get_post_meta( $post->ID, '_wp_newsletter_meta_description', true ) != NULL){
	$meta_description = get_post_meta( $post->ID, '_wp_newsletter_meta_description', true );
}
/* Preview Text*/
if(get_post_meta( $post->ID, '_wp_newsletter_preview_text', true ) != "" && get_post_meta( $post->ID, '_wp_newsletter_preview_text', true ) != NULL){
	$preview_text = get_post_meta( $post->ID, '_wp_newsletter_preview_text', true );
}
/* Promo Banner Link */
$promoLink = false;
if(get_post_meta( $post->ID, '_wp_newsletter_image_url', true ) != "" && get_post_meta( $post->ID, '_wp_newsletter_image_url', true ) != NULL){
	$promoLink = get_post_meta( $post->ID, '_wp_newsletter_image_url', true );
}
/* Facebook Description */
if(get_post_meta('meta_information_meta_facebook_description')){
	$meta_description = get_post_meta('meta_information_meta_facebook_description');
}
/* Twitter Share Message */
if(get_post_meta('meta_information_twitter_share_copy')){
	$twitter_text = get_post_meta('meta_information_twitter_share_copy');
}
/* Set og:image */
$ogImage = $logoImg;
// Override if Featured Image is present
if(has_post_thumbnail()){
    $imageObject = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'thumbnail');
    $ogImage = $imageObject[0];
}


/** Clean up <p> tags and inline style to <a>, <h> tags **/
function wpun_addStyle($string){
    // Define and make availiable GLOBALS
    global $buttonStyles, $linkColor, $headingColor, $google_parameters, $outlookify, $preButton, $postButton, $bodyWidth;
    $string = preg_replace('/<h(.*?)>/', '<h$1 style="color:'.$headingColor.';">', $string); //Add inline style to <h> tags
	#$string = preg_replace('/<p(.*?)>/', '<p style="text-align:center;">', $string); //Remove <p> tags - Causes problems with Hotmail, etc
    $string = preg_replace('/<p(.*?)>/', '<table width="100%"><tr><td$1> ', $string); //Remove <p> tags - Causes problems with Hotmail, etc
    $string = preg_replace('/<div(.*?)>/', '', $string); //Remove <div> tags - Causes problems with Hotmail, etc
    $string = str_replace('</p>', '</td></tr></table><br />', $string); 
    $removeClosing = array('</div>');
	$string = str_replace($removeClosing, '<br /><br />', $string); // Convert closing tags to <br />
    
    //Remove inline height attributes from images to make them responsive
    $string = preg_replace('/height="(.*?)"/', 'style="max-width:100%;"', $string);
    
    // Loop through all inline images, if width is greater than max width of body, then use max-widrth for image width
    // Note* You need to have a number value for width attr for Outlook, or Outlook will render image at its natural full size
    /* Grab all the inline images */
    preg_match_all('/width="(.*?)"/', $string, $matches, PREG_OFFSET_CAPTURE);
    foreach($matches[1] as $key => $match){
        /* Larger than the body? */
        if($match[0] > wpun_noPX($bodyWidth)){
            $string = substr_replace($string, wpun_noPX($bodyWidth), $match[1], strlen($match[0]));
        }
    }
    
    
    /** 
        ADD INLINE STYLES TO LINKS
    **/
    $links = substr_count($string, '<a'); //Count how many links in a string

	$offset=0;
    $hrefOffset=0;
	for($i=0;$i<$links;$i++){
		$start =  strpos($string, '<a', $offset); // Begin
		$end = strpos($string, '</a>', $start); // End 
        $link = substr($string, $start, $end-$start);
        if(strpos($link, 'class="button"')){
            $string = substr_replace($string, ' class="button" style="'.$buttonStyles.'" ', $start+2, 0);
            
        } else {
            $string = substr_replace($string, ' style="color:'.$linkColor.';" ', $start+2, 0);
        }
		$offset = $end+1;
        
        //Append all in-content links with $google_parameters
        $off =  strpos($string, 'href="', $hrefOffset); // Begin href
		$pos = strpos($string, '"', $off+6); // End href
		$string = substr_replace($string, $google_parameters, $pos, 0); //Append
		$hrefOffset = $pos+1; 
	}
    
    /* Adding Outlook buttons? */
    if($outlookify){
        $offset=0;
        for($i=0;$i<$links;$i++){
            $start =  strpos($string, '<a', $offset); // Begin
            $firstTag = strpos($string, '>', $start); // First Tag
            $end = strpos($string, '</a>', $start); // End 
            $buttonText = substr($string, $firstTag+1, $end-($firstTag+1)); //Button Text
            $link = substr($string, $start, $end-$start);
            if(strpos($link, 'class="button"')){
                $tempButton = str_replace("{text}", $buttonText, $preButton);
                $string = substr_replace($string, $tempButton, $start-1, 0);
                $string = substr_replace($string, $postButton, $end+strlen($tempButton)+4, 0);
            //$string = preg_replace('/<a(.*?)>(.*?)<\/a>/', "<a$1>$2</a>", $string);
            }
            $offset = $end+strlen($tempButton)+5;
        }
    }
	
	return $string;	
}

/* Get the body content without removing links, etc */
function wpun_get_the_content_with_formatting ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}

/* Process the footer. Substitute tokens for actual values */
function wpun_processFooter($string){
    
    $string = str_replace('[year]', date('Y'), $string); //Swap in the year
    $string = str_replace('[site-name]', get_bloginfo('name'), $string); //Swap in site name
    $string = str_replace('[page-URL]', get_permalink(), $string); //Swap page URL
    $string = str_replace('[view-in-browser]', "<a href='".get_permalink()."' target='_blank'>View in browser</a>", $string); //Swap page URL
    
    return $string;
}

/** Remove px from string **/
function wpun_noPx($string){
    return str_replace('px', '', $string);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<title> <?php echo $title; ?> - <?php echo $date; ?> | <?php bloginfo('name'); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta content="IE=edge, chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="p:domain_verify" content="<?php echo $domain_verify; ?>"/>
    <meta name="description" content="<?php echo $meta_description; ?>" />
    <meta name="keywords" content=""  />
    <meta property="fb:app_id" content="<?php echo $fbAppID;?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<?php echo $ogImage;?>"/>
    <meta property="og:title" content="<?php echo $title; ?> | <?php echo $date; ?>" />
    <meta property="og:description" content="<?php echo $meta_description; ?>" />
    <meta property="og:url" content="<?php echo $page_url; ?>" />
    
    <!-- Font Awesome for Iconography -->
    <!-- Cant be used in HTML Emails, but can be used on web versions. Currently not being utilized -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" >
    
    <style type="text/css">
      html, body, td{
          color:<?php echo $fontColor;?>;
          font-family:<?php echo $fontFamily;?>;
          font-size:<?php echo $fontSize;?>;
          line-height:22px;
      }
    a, a:link{
        color:<?php echo $linkColor;?>;
    }
    a:hover, a:link:hover{
        text-decoration:underline !important;
        color:<?php echo $linkHoverColor; ?>
        }
    a.button:hover, a.button:link:hover{
        background:<?php echo $buttonColor;?> !important;
        text-decoration:none !important;
        opacity:0.7;
    }
    #social a:hover img{opacity:0.7;}
    @media only screen and (min-width: 630px) {
    .left-side{
        width: 53% !important;
        max-width:300px;
    }
    .right-side{
        width:46% !important;
        max-width:240px
    }
    .hero{
        display:block !important;
        height:auto !important;
        width:100% !important; 
    }
    .paddingTop{padding-top:0 !important;}
    .fullWidth{width:30% !important;}
    .hideMobile{width:70% !important;}
    }
    @media only screen and (min-width: 450px) {
        .main-wrapping-table{
            max-width:100%;
            padding:20px;
        }
    }
    @media only screen and (max-width: 600px) {
        
    }
    @media only screen and (max-width: 450px) {
    .hideMobile{
        width:0 !important;
        display:table-cell;
    }
     }
    </style>
    <?php 
     // Add Outlook Conditional Styles 
     if($outlookify): 
    ?>
    <!--[if mso]>
    <style type="text/css">
    html, body{
        width:<?php echo $bodyWidth?> !important;}
    .body-text,
    .main-wrapping-table{
        font-family:<?php echo $fontFamily ?> !important;
        width:<?php echo $bodyWidth?> !important;
    }
	h1{}
	.fullWidth{
        padding-top:0 !important;}
    </style>
    <![endif]-->
    
    <!--[if gte mso 14]>
    <style type="text/css">
    html, body{width:<?php echo $bodyWidth?> !important;}
    .main-wrapping-table{
        padding:20px;
        width:<?php echo $bodyWidth?> !important;}
    .left-side{
        width: 52% !important;
        max-width:300px;
    }
    .right-side{
        width:46% !important;
        max-width:240px
    }
    </style>
<![endif]-->
<?php endif; ?>
</head>
<body 
    style="margin:0 auto;
    -webkit-text-size-adjust:none;
    font-family:<?php echo $fontFamily;?>;
    background-color:<?php echo $globalBG;?>;"
 >
<!-- For Adding Custom Preview Text: Seen in Gmail, iPhone mail, etc -->
<div class="hide-outlook" style="display:none;font-size:1px;color:#ffffff;line-height:1px;max-height:0px;max-width:0px;width:1px;height:1px;opacity:0;overflow:hidden;">
  <?php echo $preview_text; ?>            
</div>
<!-- end custom preview text -->
    <table 
        class="main-wrapping-table" 
        align="center" 
        style="font-family:<?php echo $fontFamily;?>;
        color:<?php echo $fontColor;?>;
        font-size:<?php echo $textSize;?>;
        max-width:<?php echo $bodyWidth;?>;
        margin:0 auto;
        line-height:19px;
        border:<?php echo $bodyBorder;?>;
        background:<?php echo $bodyBG;?>;" 
        cellpadding="0" 
        cellspacing="0"
    >
        <tr>
            <td align="center">
            <table 
                class="inner-table"
                style="max-width:<?php echo $bodyWidth;?>;" 
                width="100%" 
                cellpadding="0" 
                cellspacing="0"
             >
            <?php if(!$hideHeader): ?>
            <!-- header -->
            <tr>
                <td>
                    <table style="background:<?php echo $bodyBG;?>;" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width:50%;padding:0 10px;" align="left">
                            <a href="<?php bloginfo('url'); ?>" target="_blank">
                                <img src="<?php echo $logoImg ?>" alt="<?php bloginfo('name');?>" border="0" style="max-width:100%;width:100%;" />
                            </a>
                            </td>
                            <td align="right" style=""><?php echo get_the_date($dateFormat); ?></td>
                        </tr>
                        <tr><td style="line-height:10px;">&nbsp;</td></tr>
                    </table>
                </td>
            </tr>
          <!-- end header -->
          <?php endif; ?>
          <?php if(has_post_thumbnail()): ?>
          <?php $promoImage = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'original');?>
          <!-- promo area -->
            <tr>
                <td>
                    <table width="100%" style="max-width:<?php echo $bodyWidth;?>;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td valign="top">
                            <?php if($promoLink):?> 
                                <a href="<?php echo $promoLink;?>" style="display:block;" target="_blank">
                            <?php endif; ?>
                                <img src="<?php echo $promoImage[0]; ?>" alt="<?php the_title(); ?>" border="0" width="<?php echo wpun_noPx($bodyWidth);?>"
                                style="width:100%;max-width:<?php echo $bodyWidth;?>;display:block;height:auto;"  />
                            <?php if($promoLink):?> 
                                </a>
                            <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
         <!-- end promo -->
         <?php endif; ?>    
            <tr>
                 <td>
                     <!-- Main Table Item -->
                     <table align="left" width="100%" cellpadding="0" cellspacing="0" style="background:<?php echo $bodyBG;?>;padding:<?php echo $padding; ?>">
                     <!-- Title -->
                         <tr>
                            <td style="padding-bottom:20px;">
                            <h1 style="line-height: normal;color:<?php echo $headingColor; ?>"><?php echo $title; ?></h1>
                            <h2 style="line-height: normal;color:<?php echo $headingColor; ?>"><?php echo $sub_title; ?></h2>
                            </td>
                        </tr>
                      <!-- body -->
                          <tr>
                            <td valign="top">
                                <?php echo wpun_addStyle(wpun_get_the_content_with_formatting()); ?> 
                            </td>
                         </tr>
                     </table> 
                     <?php if($socialize === true): ?>
                     <!-- Social Share Links Links -->             
                     <table id="social" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="100%" style="text-align:center;">
                                <!-- Email Share -->
                                <a 
                                href="mailto:Enter Email(s) Here?subject=<?php echo $emailSubject?>&body=Dear Friend, %0A%0AI think you would enjoy this Newsletter below %0A%0A<?php echo $page_url; ?>" 
                                target="_blank" 
                                style="text-decoration:none !important;"
                                >
                                    <img src="<?php echo $email ?>" width="<?php echo wpun_noPx($socialIconWidth);?>" border="0" alt="email"/>
                                </a>
                                &nbsp;
                                <a 
                                href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $page_url; ?>" 
                                target="_blank" 
                                style="text-decoration:none !important;"
                                >
                                    <img src="<?php echo $facebook ?>" width="<?php echo wpun_noPx($socialIconWidth);?>" border="0" alt="Facebook" />
                                </a>
                                &nbsp;
                                <a 
                                href="https://twitter.com/share?url=<?php echo $page_url; ?>&text=<?php echo $twitter_text; ?>" 
                                target="_blank" 
                                style="text-decoration:none !important;"
                                >
                                    <img src="<?php echo $twitter ?>" width="<?php echo wpun_noPx($socialIconWidth);?>"  border="0" alt="Twitter" />
                                </a>
                                &nbsp;
                                <a 
                                href="https://plus.google.com/share?url=<?php echo $page_url; ?>" 
                                target="_blank" 
                                style="text-decoration:none !important;">
                                    <img src="<?php echo $google ?>" width="<?php echo wpun_noPx($socialIconWidth);?>" border="0" alt="Google" />
                                </a>
                                &nbsp;
                                <a 
                                href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $page_url; ?>&title=<?php echo $linkedInTitle; ?>&summary=<?php echo $linkedInDesc; ?>" 
                                target="_blank" 
                                style="text-decoration:none !important;">
                                    <img src="<?php echo $linkedin ?>" width="<?php echo wpun_noPx($socialIconWidth);?>"  border="0" alt="LinkedIn" />
                                </a>
                            </td>
                        </tr>
                     </table>
                     <!-- end social share links -->
                     <?php endif; ?>
                     <!-- copyright info -->
                     <table width="100%" cellpadding="0" cellspacing="0">
                        <tr><td colspan="5" style="line-height:30px;">&nbsp;</td></tr>
                        <tr><td colspan="5" style="line-height:20px;border-top:2px solid #e4e4e4">&nbsp;</td></tr>
                         <tr>
                            <td style="font-size:10px;line-height:16px;padding:10px;" align="center">
                                <?php echo wpun_processFooter($footer); ?>
                            </td>
                        </tr>
                     </table>
                     <!-- end copyright info -->
                  </td>
              </tr>
         </table><!-- end .inner-table -->
         </td>
      </tr>
    </table><!-- end .main-wrapping-table -->
    <!-- Google Analytics Code -->
    <?php if("" !== get_option('wp_newsletter_google_analytics') && get_option('wp_newsletter_google_analytics') != NULL):?>
        <script>
			var _gaq=[['_setAccount','<?php echo get_option('wp_newsletter_google_analytics'); ?>'],['_trackPageview']];
			(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
			g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
			s.parentNode.insertBefore(g,s)})(document,'script')
		</script>
    
    <?php endif; ?>
</body>
</html>
<?php endwhile; endif; ?>