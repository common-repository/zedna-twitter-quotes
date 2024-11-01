<?php
/*
  Plugin Name: Zedna Twitter Quotes
  Plugin URI: https://profiles.wordpress.org/zedna#content-plugins
  Text Domain: zedna-twitter-quotes
  Domain Path: /languages
  Description: Share your quotes in the content and let user to share them on Twitter.
  Version: 1.0
  Author: Radek Mezulanik
  Author URI: https://www.mezulanik.cz
  License: GPL3
*/

// CREATE Zedna Twitter Quotes options
//Set options
add_option( 'zednatq_username', '',  '', 'yes' );
add_option( 'zednatq_share_text', 'Tweet me',  '', 'yes' );
add_option( 'zednatq_class', '',  '', 'yes' );
add_option( 'zednatq_utm_campaign', 'blog',  '', 'yes' );
add_option( 'zednatq_utm_medium', 'social',  '', 'yes' );
add_option( 'zednatq_utm_source', 'twitter',  '', 'yes' );


// #CREATE Zedna Twitter Quotes options
add_action( 'plugins_loaded', 'zednatq_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0
 */
function zednatq_load_textdomain() {
  load_plugin_textdomain( 'zedna-twitter-quotes', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'zednatq_links' );

function zednatq_links( $links ) {
   $links[] = '<a href="https://profiles.wordpress.org/zedna/#content-plugins" target="_blank">More plugins by Radek Mezulanik</a>';
   return $links;
}

//Add admin page
add_action('admin_menu', 'zednatq_setttings_menu');

if( !defined('ABSPATH') ) die('-1');

function zednatq_setttings_menu(){        
  add_options_page( __('Zedna Twitter Quotes Settings page','zedna-twitter-quotes'), __('Twitter Quotes','zedna-twitter-quotes'), 'manage_options', 'zednatq', 'zednatq_init','dashicons-format-quote');
  // Call update_zednatq function to update database
  add_action( 'admin_init', 'update_zednatq' );
}

// Create function to register plugin settings in the database
if( !function_exists("update_zednatq") )
{
function update_zednatq() {
  register_setting( 'zednatq-settings', 'zednatq_username' );
  register_setting( 'zednatq-settings', 'zednatq_share_text' );
  register_setting( 'zednatq-settings', 'zednatq_class' );
  register_setting( 'zednatq-settings', 'zednatq_utm_campaign' );
  register_setting( 'zednatq-settings', 'zednatq_utm_medium' );
  register_setting( 'zednatq-settings', 'zednatq_utm_source' );
}
}
function zednatq_init(){
  $zednatq_username = (get_option('zednatq_username') !== '') ? get_option('zednatq_username') : '';
  $zednatq_share_text = (get_option('zednatq_share_text') !== '') ? get_option('zednatq_share_text') : 'Tweet me';
  $zednatq_class = (get_option('zednatq_class') !== '') ? get_option('zednatq_class') : '';
  $zednatq_utm_campaign = (get_option('zednatq_utm_campaign') !== '') ? get_option('zednatq_utm_campaign') : 'blog';
  $zednatq_utm_medium = (get_option('zednatq_utm_medium') !== '') ? get_option('zednatq_utm_medium') : 'social';
  $zednatq_utm_source = (get_option('zednatq_utm_source') !== '') ? get_option('zednatq_utm_source') : 'twitter';
?>
<h1><?php print __('Zedna Twitter Quotes Settings','zedna-twitter-quotes');?></h1>
<div class="wrap">
  <form method="post" action="options.php">
    <?php
    settings_fields('zednatq-settings'); ?>
    <?php
    do_settings_sections('zednatq-settings'); ?>
    <style>
    .form-table{
      background-color: #fff;
      padding: 16px;
      max-width: 96%;
    }
    .row{
      padding: 16px 0;
    }

    .row.first{
      padding: 0;
    }
  </style>
    <div class="form-table">
      <div valign="top">
      <div class="row first"><h4><?php print __('Shortcode settings:','zedna-twitter-quotes');?></h4></th>
      <div>
    <?php
    $zednatq_username = get_option('zednatq_username');
    $zednatq_share_text = get_option('zednatq_share_text');
    $zednatq_class = get_option('zednatq_class');
    ?>
        <p>
          <label>
          <?php print __('Twitter username');?>
            <input type="text" name="zednatq_username" value="<?php if ($zednatq_username){print $zednatq_username;}?>" />
          </label>
        </p>
        <p>
          <label>
          <?php print __('Quote box share text');?>
            <input type="text" name="zednatq_share_text" value="<?php if ($zednatq_share_text){print $zednatq_share_text;}?>" />
          </label>
        </p>
        <p>
          <label>
          <?php print __('Custom class');?>
            <input type="text" name="zednatq_class" value="<?php if ($zednatq_class){print $zednatq_class;}?>" />
          </label>
        </p>
      </div>
      </div>

      <div class="row"><h4><?php print __('UTM parameters','zedna-twitter-quotes');?></h4></th>
      <div>
      <?php
        $zednatq_utm_campaign = get_option('zednatq_utm_campaign');
        $zednatq_utm_medium = get_option('zednatq_utm_medium');
        $zednatq_utm_source = get_option('zednatq_utm_source');
      ?>
          <p>
          <label>
          <?php print __('Campaign name');?>
            <input type="text" name="zednatq_utm_campaign" value="<?php if ($zednatq_utm_campaign){print $zednatq_utm_campaign;}else{print "blog";}?>" />
          </label>
        </p>
        <p>
          <label>
          <?php print __('Campaign medium');?>
            <input type="text" name="zednatq_utm_medium" value="<?php if ($zednatq_utm_medium){print $zednatq_utm_medium;}else{print "social";}?>" />
          </label>
        </p>
        <p>
          <label>
          <?php print __('Campaign source');?>
            <input type="text" name="zednatq_utm_source" value="<?php if ($zednatq_utm_source){print $zednatq_utm_source;}else{print "twitter";}?>" />
          </label>
        </p>
       
      </div>
      </div>
      
      <div class="row"><h4><?php print __('How to use','zedna-twitter-quotes');?></h4></th>
        <div>
          <p>
          <?php print __('Put this shortcode into your post <code>[zednatq tweet="This is my quote."]</code>');?>
          </p>
          <p>
          <?php print __('Optionaly you can change parameters above by inserting them to the shortcode:<br/>');?>
          <?php print __('<code>[zednatq tweet="This is my quote." username="myname" utm_campaign="othercampaign" utm_medium="othermedium" utm_source="othersource"]</code>');?>
          </p>
        </div>
      </div>

    </div>
  <?php
    submit_button(); ?>
  </form>
</div>
<p><?php print __('If you like this plugin, please donate us for faster upgrade','zedna-twitter-quotes');?></p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
  <input type="hidden" name="cmd" value="_s-xclick">
  <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
  <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit"
    alt="PayPal - The safer, easier way to pay online!">
  <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<?php
}

function zednatq_stylesheet() {
  $plugin_url = plugin_dir_url( __FILE__ );

wp_enqueue_style( 'zedna-twitter-quotes',  $plugin_url . "/zedna-twitter-quotes.css");
}

add_action( 'wp_enqueue_scripts', 'zednatq_stylesheet' );

/*-----------------------------------------------------------------------------------*/
/*	Do stuff
/*	Shortcode [zednatq tweet="This is my quote."]
/*-----------------------------------------------------------------------------------*/
function zednatq_shortcode( $atts ) {
  $zednatq_share_text = get_option('zednatq_share_text');

	$atts = shortcode_atts( apply_filters( 'zednatq_atts', array(
    'tweet'    => '',
		'via'      => 'yes',
		'username' => '',
		'url'      => 'yes',
    'nofollow' => 'no',
    'utm_campaign'   => '',
    'utm_medium'   => '',
    'utm_source'   => '',
    'class'   => '',
    'prompt'   => $zednatq_share_text
	) ), $atts, 'zednatq' );

	if ( $atts['username'] ) {

		$input = $atts['username'];

	} else {

		$input = get_option('zednatq_username');

  }
  
  if ( $atts['utm_campaign'] ) {

		$utm_campaign = $atts['utm_campaign'];

	} else {

		$utm_campaign = get_option('zednatq_utm_campaign');

  }
  
  if ( $atts['utm_medium'] ) {

		$utm_medium = $atts['utm_medium'];

	} else {

		$utm_medium = get_option('zednatq_utm_medium');

  }
  
  if ( $atts['utm_source'] ) {

		$utm_source = $atts['utm_source'];

	} else {

		$utm_source = get_option('zednatq_utm_source');

	}

	if ( function_exists( 'zednatq_trimmer' ) ) {

		$input_length = ( 6 + zednatq_strlen( $input ) );

	} else {

		$input_length = ( 6 + strlen( $input ) );

	}

	if ( ! empty( $input ) && $atts['via'] != 'no' ) {

		$via = $input;
		$related = $input;
	} else {

		$via = null;
		$related = '';

	}

	if ( $atts['via'] != 'yes' ) {
		$via = null;
		$input_length = 0;

	}

  $text = $atts['tweet'];
  
  $class = $atts['class'];

	if ( filter_var( $atts['url'], FILTER_VALIDATE_URL ) ) {

		$zednatqURL = apply_filters( 'zednatqurl', $atts['url'], $atts );

	} elseif ( $atts['url'] != 'no' ) {

		if ( get_option( 'zednatq-short-url' ) != false ) {

			$zednatqURL  = apply_filters( 'zednatqurl', wp_get_shortlink(), $atts );

		} else {

			$zednatqURL = apply_filters( 'zednatqurl', get_permalink(), $atts);

		}

	} else {

		$zednatqURL = null;

	}

	if ( $atts['url'] != 'no' ) {

		$short = zednatq_shorten( $text, ( 253 - ( $input_length ) ) );

	} else {

		$short = zednatq_shorten( $text, ( 280 - ( $input_length ) ) );

	}

	if ( $atts['nofollow'] != 'no' ) {

		$rel = 'rel="noopener noreferrer nofollow"';

	} else {

		$rel = 'rel="noopener noreferrer"';

	}

	$zednatq_span_class        = apply_filters( 'zednatq_span_class', 'zednatq-tweet' );
	$zednatq_text_span_class   = apply_filters( 'zednatq_text_span_class', 'zednatq-tweet-text' );
	$zednatq_button_span_class = apply_filters( 'zednatq_button_span_class', 'zednatq-tweet-btn' );


	$href  = add_query_arg(  array(
		'url'     => $zednatqURL,
		'text'    => rawurlencode( html_entity_decode( $short ) ),
		'via'     => $via,
		'related' => $related,
		'utm_campaign' => $utm_campaign,
		'utm_medium' => $utm_medium,
		'utm_source' => $utm_source
	), 'https://twitter.com/intent/tweet' );

	if ( ! is_feed() ) {

		$output = "<span class='" . esc_attr( $zednatq_span_class ) ." ". esc_attr( $class ) . "'><span class='" . esc_attr( $zednatq_text_span_class ) . "'><a href='" . esc_url( $href ) . "' target='_blank'" . $rel . ">" . esc_html( $short ) . " </a></span><a href='" . esc_url( $href ) . "' target='_blank' class='" . esc_attr( $zednatq_button_span_class ) . "'" . $rel . ">" . esc_html( $atts['prompt'] ) . "</a></span>";
	} else {

		$output = "<hr /><p><em>" . esc_html( $short ) . "</em><br /><a href='" . esc_url( $href ) . "' target='_blank' " . $rel . " >" . esc_html( $atts['prompt'] ) . "</a><br /><hr />";

	}
	return apply_filters( 'zednatq_output', $output, $short, $zednatq_button_span_class, $zednatq_span_class, $zednatq_text_span_class, $href, $rel, $atts );
}

function zednatq_shorten( $input, $length, $ellipsis = true, $strip_html = true ) {

	if ( $strip_html ) {
		$input = strip_tags( $input );
	}

	/*
	/* 	Checks to see if the mbstring php extension is loaded, for optimal truncation.
	/*	If it's not, it bails and counts the characters based on utf-8.
	/*	What this means for users is that non-Roman characters will only be counted
	/*	correctly if that extension is loaded. Contact your server admin to enable the extension.
	*/

	if ( function_exists( 'zednatq_trimmer' ) ) {
		if ( zednatq_strlen( $input ) <= $length ) {
			return $input;
		}

		$last_space   = zednatq_strrpos( zednatq_substr( $input, 0, $length ), ' ' );
		$trimmed_text = zednatq_substr( $input, 0, $last_space );

		if ( $ellipsis ) {
			$trimmed_text .= "…";
		}

		return $trimmed_text;

	} else {

		if ( strlen( $input ) <= $length ) {
			return $input;
		}

		$last_space   = strrpos( substr( $input, 0, $length ), ' ' );
		$trimmed_text = substr( $input, 0, $last_space );

		if ( $ellipsis ) {
			$trimmed_text .= "…";
		}

		return $trimmed_text;
	}
}
add_shortcode( 'zednatq', 'zednatq_shortcode' );
?>
