<?php 
/*
Plugin Name: Creative News Ticker
Plugin URI: http://learn-with-mnaopu.blogspot.com
Description: This plugin will add a news ticker in your wordpress pages and posts with shortcode.
Version: 1.2
Author URI: http://profiles.wordpress.org/mnaopu
Author: Md. Naeem Ahmed Opu
*/

//Admin Notice
function cn_ticker_notice() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( 'Thanks! For Using <strong>Creative News Ticker</strong> Plugin', '' ); ?></p>
    </div>
    <?php
}

/* Adding Latest jQuery from Wordpress */
function creative_news_ticker_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'creative_news_ticker_jquery');

/* Adding Plugin javascript file */
function creative_news_ticker_jquery_files() {
	wp_register_script( 'js-script', plugins_url('js/creative-news-ticker.js',__FILE__));
    wp_enqueue_script( 'js-script' );
}
add_action( 'init', 'creative_news_ticker_jquery_files' );

/* Adding Plugin custm CSS file */
function creative_news_ticker_styles() {
	wp_register_style( 'css-style', plugins_url('css/creative-news-ticker.css', __FILE__) );
    wp_enqueue_style( 'css-style' );
}
add_action( 'wp_enqueue_scripts', 'creative_news_ticker_styles' );

function creative_news_ticker_shortcode($atts){
	extract( shortcode_atts( array(
		'id' => 'cnticker',
		'category' => '',
		'count' => '10',
		'category_slug' => 'category_ID',
		'speed' => '5000',
		'typespeed' => '80',
		'color' => '#3498db',
		'text' => 'Breaking News',
	), $atts, 'projects' ) );
	
    $q = new WP_Query(
        array('posts_per_page' => $count, 'post_type' => 'post', $category_slug => $category)
        );		
		
		
	$list = '
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#cnticker'.$id.'").ticker({
				itemSpeed: '.$speed.',
				cursorSpeed: '.$typespeed.',
			});
		}); 	
	</script>	
	<div id="cnticker'.$id.'" class="ticker"><strong style="background-color:'.$color.'">'.$text.'</strong><ul>';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$list .= '
		
			<li>'.get_the_title().'</li>
		
		';        
	endwhile;
	$list.= '</ul></div>';
	wp_reset_query();
	return $list;
}
add_shortcode('cn-ticker', 'creative_news_ticker_shortcode');	


?>