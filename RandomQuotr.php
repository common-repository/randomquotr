<?php
/* 
Plugin Name: RandomQuotr
Plugin URI: https://wordpress.org/plugins/randomquotr/
Description: RandomQuotr allows the user to create their own list of quotes and then use the hooks or shortcodes available to display either a random or a specific quote.
Version: 1.0.4
Author: jfcby
Author URI: http://www.corematrixgrid.com
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: randomquotr
*/

/** If this file is called directly, abort. */
if ( !defined( 'ABSPATH' ) ) {
	die;
}

/* Admin Menu */
add_action('admin_menu', 'randomquotr_menu');

function randomquotr_menu() {
  add_options_page('RandomQuotr Options', 'RandomQuotr', 8, __FILE__, 'randomquotr_adminPage');
}

/* Admin Page */
function randomquotr_adminPage() {
?>
  <div class='wrap'>
  	<h2>RandomQuotr Settings</h2>
  	
  	<form method='post' action='options.php'>
  	<?php wp_nonce_field('update-options'); ?>
  		<table class='form-table'>
  			<tr>
  				<td style="vertical-align:top">
  					<h3>Quotes</h3>
  					<textarea rows="20" cols="60" name='randomquotr_quotes' id='randomquotr_quotes'><?php echo get_option('randomquotr_quotes'); ?></textarea>
  				</td>
  				<td style="vertical-align:top">
  					<h3>Explanation</h3>
  					<p>Each line is a random quote. Don't worry if your line wraps onto the next one, it will still count as one line. Carriage returns (the Enter key) breaks up each quote on a new line.</p>
  					<h4>Hooks</h4>
					<p><strong>To get a random quote use the following hook:</strong><p>
  					<p><em>&lt;?php rdqr_random_quote() ?&gt;</em></p>
  					<p>You can also use <em>&lt;?php $quote = rdqr_get_random_quote(); ?&gt;</em></p>
  					<p><strong>To get a specific quote use the following hook:</strong><p>
  					<p><em>&lt;?php rdqr_target_quote($quoteNumber) ?&gt;</em> where $quoteNumber is the quote line.</p>
  					<p>You can also use <em>&lt;?php $quote = rdqr_get_target_quote($quoteNumber); ?&gt;</em></p>
  					<p><em>e.g. rdqr_target_quote(3) will return the 3rd quote.</em></p>
					<p><strong>To list all quotes use the following hook:</strong><p>
  					<p><em>&lt;?php rdqr_get_allqts() ?&gt;</em></p>					
  					<p><strong>Note: rdqr_target_quote will return null when:</strong>
  					<ul>
  					<li>There are no quotes available.</li>
  						<li>A number less than one is passed to it (the list starts at 1, not 0).</li>
  						<li>A number greater than the total amount of quotes is passed: 100, when there are only 20 quotes.</li>
  						<li>A non-numeric value is passed: "twenty". Note that "33" <em><strong>WILL</strong></em> work.</li>
  					</ul>
					<h4>Shortcodes</h4>
					<p>Use shortcode <em><strong>[rdqr_randomquote]</strong></em> to display a random quote in a page or post.</p>
					<p>Use shortcode <em><strong>[rdqr_targetquote singlequote="3"]</strong></em> to display a specific quote in a post or page. Change the number 3 to the line number of the quote that you want to display.</p>					
					<p>Use shortcode <em><strong>[rdqrallqts]</strong></em> to display all quotes in a page or post.</p>
					<p><strong>Use the following shortcode in your theme files to get a random quote:</strong><p>
  					<p><em>&lt;?php echo do_shortcode("[rdqr_randomquote]"); ?&gt;</em>.</p>
					<p><strong>Use the following shortcode in your theme files to get a specific quote:</strong><p>
  					<p><em>&lt;?php echo do_shortcode('[rdqr_targetquote singlequote="3"]'); ?&gt;</em>. Change the number 3 to the quote that you want displayed.</p>
					<p><strong>Use the following shortcode in your theme files to list all quotes:</strong><p>
  					<p><em>&lt;?php echo do_shortcode("[rdqrallqts]"); ?&gt;</em>.</p>
  				</td>
  			</tr>
  		</table>
  		
  		<input type='hidden' name='action' value='update' />
		<input type='hidden' name='page_options' value='randomquotr_quotes' />

  		<p class='submit'>
			<input type='submit' name='Submit' value='<?php _e("Save Changes") ?>' />
		</p>

  	</form>
  </div>
  <?php
}

/* Echos a texturized random quote */
function rdqr_random_quote() { 
	echo rdqr_get_random_quote(); 
}

/* Returns a texturized random quote */
function rdqr_get_random_quote() {
	$rQuote = explode("\n", get_option('randomquotr_quotes'));
	if($rQuote == null || count($rQuote) <= 0)
		return null;
	return wptexturize($rQuote[ mt_rand(0, count($rQuote) - 1) ]);
}

/* Display Random Shortcode */
add_shortcode('rdqr_randomquote', 'rdqr_get_random_quote');

/* Set function to execute when the admin_notices action is called */
add_action( 'admin_notices', 'rdqr_random_quote' );

/* Echos a specific texturized quote If it cannot select a quote (invalid selection, invalid input) it will echo null (nothing will display)*/
function rdqr_target_quote($lineNumber) { 
	echo rdqr_get_target_quote ($lineNumber); 
}

/* Returns a specific texturized quote. If it cannot select a quote (invalid selection, invalid input) it will return null */
function rdqr_get_target_quote($lineNumber) {
	$rQuote = explode("\n", get_option('randomquotr_quotes'));
	if($rQuote == null || count($rQuote) <= 0 || $lineNumber < 1 || !is_numeric($lineNumber) || intval($lineNumber) > count($rQuote))
		return null;
	return wptexturize($rQuote[ intval($lineNumber) - 1 ]);
}

/* Shortcode with parameter */
function rdqr_target_quote_shortcode($singlequote) {
 extract(shortcode_atts(array(
  	'singlequote' => ''
  	), $singlequote));		
  return rdqr_get_target_quote($singlequote);
}
add_shortcode('rdqr_targetquote', 'rdqr_target_quote_shortcode');

/* Returns texturized all quotes */
function rdqr_get_allqts() {
    $rQuote = explode("\n", get_option('randomquotr_quotes'));
    if($rQuote == null || count($rQuote) <= 0) 
        return null;
    
    $ret = '';
    foreach($rQuote as $rQts) {
        $ret .= wptexturize($rQts).'<br />';
    }    
    return $ret;
}

/* Display All Quotes Shortcode */
add_shortcode('rdqrallqts', 'rdqr_get_allqts');

/* Using Shortcodes in Widgets */
add_filter('widget_text', 'do_shortcode');

// Add settings link on plugin page
function rdqr_plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=randomquotr/randomquotr.php">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
} 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'rdqr_plugin_settings_link' );

?>