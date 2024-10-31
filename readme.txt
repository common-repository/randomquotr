=== RandomQuotr ===
Contributors: jfcby
Tags: quote, random, random quotes, one liner
Requires at least: 4.0
Tested up to: 6.5.2
Stable tag: 1.0.4
Requires PHP: 7.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create a list of quotes and then display a random quote or specific quote.

== Description ==

Create a list of quotes to be displayed in random order or a specific quote one at time using custom template tags or shortcodes. Now the quotes can be listed on a page or post using a shortcode.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/randomquotr` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' page in WordPress
1. Use the Settings->RandomQuotr page add quotes in the textarea on the left-hand side. Each quote needs to be on a new line. They are split with carriage returns (line breaks).
1. Use the following hooks to display the quotes:

**Get a random quote**
* `rdqr_random_quote();` - this will display the text automatically.
* `$quote = rdqr_get_random_quote();` - this stores the text within a variable.

**Getting a specific quote**
* `rdqr_target_quote(3);` - this will display the third quote in the list.
* `$quote = rdqr_get_target_quote();` - this stores the text within a variable.


== Frequently Asked Questions ==

= After adding quotes when using rdqr_target_quote(0) why is nothing displayed? =

The list starts at 1 not 0. 

= When using rdqr_target_quote and rdqr_get_target_quote why are they not doing anything? =

Make sure that you are passing in a valid value. If you are passing in an invalid number (below 1, above the number of quotes), a non-number ("forty"), or there are no quotes to get, all of the functions will return null.

= Can a shortcode be used to display a random quote? =

Yes, use [rdqr_randomquote] in a page or post.

= Can a shortcode be used to display a specific quote? =

Yes, use [rdqr_targetquote singlequote="3"] to display the third quote. Change the number 3 to the quote that you want displayed.

= Can a shortcode be used to display a list of all quotes in a page or post? =

Yes, use [rdqrallqts] in a page or post.

= Can shortcodes be used in theme files? =

Yes, to display a random quote place <?php echo do_shortcode("[rdqr_randomquote]"); ?> in your theme template. Display a specific quote by placing <?php echo do_shortcode('[rdqr_targetquote singlequote="3"]'); ?> in your theme template. Change the number 3 to the quote that you want displayed.

= Can shortcodes be used in widgets? =

Yes, the shortcodes can be used in widgets.

== Screenshots ==

1. Frontend page listing all quotes.
1. WP admin plugins page.
1. RandomQuotr in the "Settings" menu.
1. Add or edit quotes.
1. Explanations on the WP admin settings page.
1. RandomQuotr settings page.
1. Add shortcode to page to list all quotes.
1. Add random quote shortcode to page.
1. Add specific quote shortcode to page.


== Changelog ==

= 1.0.4 =
* added screenshots
* added shortcode to list all quotes on a page or post
* made general text updates thru the readme file
* updated wp version

= 1.0.3 =
* updated images
* updated wp version

= 1.0.2 =
* added shortcodes

= 1.0.1 =
* made within the functions.php file of the theme

= 1.0.0 =
* created plugin, cleaned things up