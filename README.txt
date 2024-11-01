=== WP Universal Newsletter ===
Contributors: brettex
Tags: HTML Email, Responsive, iContact, MailChimp, Outlook, SEO, Newsletter
Requires at least: 4.0
Tested up to: 4.9.4
Stable tag: trunk
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Finally! A WP plugin for easy creation of responsive HTML newsletters that deliver consistent layout and design across all email clients and browsers.

== Description ==
For the first time ever, easily create responsive HTML newsletters directly in WordPress. With [Primitive Spark's](https://primitivespark.com) plugin, create and host your own newsletter content on your WordPress site. Then easily integrate your newsletter content into any email marketing service for campaign management.

= RESPONSIVE EMAIL DESIGN =
With WP Universal Newsletter, your responsive newsletter will be optimized to look great on multiple screen sizes and devices, even Outlook!. 

= CONSISTENT DESIGN ON ALL EMAIL CLIENTS =
Have you spent hours with your email marketing service's inadequate newsletter creation tools only to find that your newsletter looks like garbage when email clients “break” your design? 

With our plugin, easily create your newsletter content in WordPress. Then simply copy and paste a link in MailChimp or iContact or simply view source of the page, copy all and then paste into WYSIWYG Editor (code view)  for Constant Contact and others. It's that easy. WP Universal Newsletter ensures your design displays as intended -- on every web browser and email platform (even Outlook!). 

= SEO CREDIT =

When you host your newsletters with your email marketing provider, you get NO SEO CREDIT for all that content. When you use WP Universal Newsletter and host your newsletter content on your WordPress site, Google can index all your fab newsletter content for boosted SEO!

= EASY CONTENT ENTRY =

Our free WP Universal Newsletter plugin comes with a template already designed so that content creators don't need to mess with layouts and styles. 


= SEPARATE DESIGN CONTROLS =

Our plugin offers customization for key template elements, including: 

* **Company logo**
* **Background color**
* **Body width and body border color**
* **Font family, font color and text size**
* **Link color and link hover color**
* **Heading color**
* **Button background color and button text color**
* **Border width**

= NEWSLETTER ARCHIVING =

Never lose archived newsletter content by switching email marketing providers. With your newsletters stored in WordPress you have total control of your content.

= REBRAND RETROACTIVELY =

When your company rebrands, retroactively change your branding on past newsletters to your new brand guidelines in minutes.


== Installation ==
1. Upload this directory to your plugins directory

2. Its a good idea to refresh permalinks after installation. Settings>Permalinks>Save Permalinks

3. Be sure to Configure your Settings>WP Universal Newsletter

== Frequently Asked Questions ==
= What's the raw url? =

The raw URL is the url that will always display your newsletter as a universally valid HTML email. For those that check the 'Use current theme's single.php file' option, you MUST use the raw URL to send an HTML email. If you do not check that option, you can use either the normal or the raw URL.

= How can I make my newsletter content conform to my site's theme when viewed in the browser? =

See the 'Use current theme's single.php file' option. You'll have to know some php, and you can create the folder called 'wpun_templates' in your active theme and add a wpun_single.php file there to override the plugins wpun_single.php file. Its recommended to  copy the plugins wpun_single.php as a starting point.

= What newsletter services does this plugin work with? =

Any newsletter service that allows you to import html from a URL, such as Mailchimp, iContact. Also any service that allows you to paste in raw HTML Into a WYSIWYG editor, like Constant Contact.

= My newsletter is not loading correctly after I save and view it, whats happening? =

Try re-saving the permalinks in Wordpress Settings>Permalinks>Update Permalinks. Or if you are using a caching plugin, like W3Cache, trying clearing it.

= How to I create a button? =

In the WYSIWYG, you can simply highlight the text you wish to turn into a button, use the link icon in the tool bar, and check the option to 'Make Button'. That's it! Remember to configure your button styles in Settings>WP Universal Newsletter

= Where are the p and div tags going? =

These 2 types of tags are problematic when used in HTML emails. Email clients, like hotmail and yahoo, will often add their own styles to these tags, if present, such as paddings and margins. This will cause inconsistency in the layout across email clients, and in an effort to normalize the look, we made the decision to remove them.  As of version 1.1, `<p>` tags are now converted to table tags in an effort to preserve any inline styles that may have been added to the original `<p>` tag.

== Screenshots ==
1. Settings Screen
2. Newsletter Edit Screen
3. HTML Optimized Result

== Changelog ==

= 1.0 = 

* Initial Release

= 1.0.1 = 

* Clean up README.txt

= 1.1.0 = 

* Convert `<p>` tags into `<table>` tags instead of removing completely; Additionally preserve inline styles of the `<p>` tag and place them in the `<td>` for more granular style control.
* Fix Outlook conditional statement from breaking if more than one button was added to the page.

= 1.1.1 = 

* Fix mismatching nonce name-spaces when saving post meta fields, causing meta fields saving failures.

== Upgrade Notice ==
Added support for `<p>` tag inline styles.