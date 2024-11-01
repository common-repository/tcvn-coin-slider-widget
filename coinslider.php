<?php
/*
Plugin Name: TCVN Coin Slider Widget
Plugin URI: http://VinaThemes.biz
Description: Free Wordpress Slider to display featured posts with amazing transition effects.
Version: 1.0
Author: VinaThemes
Author URI: http://VinaThemes.biz
Author email: mr_hiennc@yahoo.com
Demo URI: http://VinaDemo.biz
Forum URI: http://VinaForum.biz
License: GPLv3+
*/

//Defined global variables
if(!defined('TCVN_COINSLIDER_DIRECTORY')) 		define('TCVN_COINSLIDER_DIRECTORY', dirname(__FILE__));
if(!defined('TCVN_COINSLIDER_INC_DIRECTORY')) 	define('TCVN_COINSLIDER_INC_DIRECTORY', TCVN_COINSLIDER_DIRECTORY . '/includes');
if(!defined('TCVN_COINSLIDER_URI')) 			define('TCVN_COINSLIDER_URI', get_bloginfo('url') . '/wp-content/plugins/tcvn-coinslider-widget');
if(!defined('TCVN_COINSLIDER_INC_URI')) 		define('TCVN_COINSLIDER_INC_URI', TCVN_COINSLIDER_URI . '/includes');

//Include library
if(!defined('TCVN_FUNCTIONS')) {
    include_once TCVN_COINSLIDER_INC_DIRECTORY . '/functions.php';
    define('TCVN_FUNCTIONS', 1);
}
if(!defined('TCVN_FIELDS')) {
    include_once TCVN_COINSLIDER_INC_DIRECTORY . '/fields.php';
    define('TCVN_FIELDS', 1);
}

class CoinSlider_Widget extends WP_Widget 
{
	function CoinSlider_Widget()
	{
		$widget_ops = array(
			'classname' => 'coinslider_widget',
			'description' => __('Display featured posts with amazing transition effects.')
		);
		$this->WP_Widget('coinslider_widget', __('TCVN Coin Slider'), $widget_ops);
	}
	
	function form($instance)
	{
		$instance = wp_parse_args( 
			(array) $instance, 
			array( 
				'title' 		=> '',
				'categoryId' 	=> '',
				'noItem' 		=> '5',
				'width' 		=> '565',
				'height' 		=> '290',
				'spw'			=> '7',
				'sph'			=> '5',
				'delay'			=> '3000',
				'sDelay'		=> '30',
				'opacity'		=> '0.7',
				'titleSpeed'	=> '500',
				'effect'		=> 'random',
				'navigation'	=> 'yes',
				'links'			=> 'yes',
				'hoverPause'	=> 'yes',
			)
		);

		$title		= esc_attr($instance['title']);
		$categoryId = esc_attr($instance['categoryId']);
		$noItem 	= esc_attr($instance['noItem']);
		$width 		= esc_attr($instance['width']);
		$height 	= esc_attr($instance['height']);
		$spw 		= esc_attr($instance['spw']);
		$sph 		= esc_attr($instance['sph']);
		$delay 		= esc_attr($instance['delay']);
		$sDelay 	= esc_attr($instance['sDelay']);
		$opacity 	= esc_attr($instance['opacity']);
		$titleSpeed = esc_attr($instance['titleSpeed']);
		$effect 	= esc_attr($instance['effect']);
		$navigation = esc_attr($instance['navigation']);
		$links 		= esc_attr($instance['links']);
		$hoverPause = esc_attr($instance['hoverPause']);
		?>
		<p><?php echo eTextField($this, 'title', 'Title', $title); ?></p>
        <p><?php echo _e('======== SOURCE SETTING ========'); ?></p>
        <p><?php echo eSelectOption($this, 'categoryId', 'Category', buildCategoriesList(), $categoryId); ?></p>
        <p><?php echo eTextField($this, 'noItem', 'Number of Post', $noItem, 'Number of posts to show. Default is: 5.'); ?></p>
        <p><?php echo _e('======== EFFECT SETTING ========'); ?></p>
        <p><?php echo eTextField($this, 'width', 'Width (px)', $width, 'Width of slider panel.'); ?></p>
        <p><?php echo eTextField($this, 'height', 'Height (px)', $height, 'Height of slider panel.'); ?></p>
        <p><?php echo eTextField($this, 'spw', 'Squares per Width', $spw, 'Squares per Width.'); ?></p>
        <p><?php echo eTextField($this, 'sph', 'Squares per Height', $sph, 'Squares per Height.'); ?></p>
        <p><?php echo eTextField($this, 'delay', 'Delay (ms)', $delay, 'Delay between images in ms.'); ?></p>
        <p><?php echo eTextField($this, 'sDelay', 'Squares Delay (ms)', $sDelay, 'Delay beetwen squares in ms.'); ?></p>
        <p><?php echo eTextField($this, 'opacity', 'Opacity', $opacity, 'Opacity of title and navigation.'); ?></p>
        <p><?php echo eTextField($this, 'titleSpeed', 'Title Speed', $titleSpeed, 'Speed of title appereance in ms.'); ?></p>
        <p><?php echo eSelectOption($this, 'effect', 'Effect', array('random'=>'Random', 'swirl'=>'Swirl', 'rain'=>'Rain', 'straight'=>'Straight'), $effect); ?></p>
        <p><?php echo eRadioButton($this, 'navigation', 'Navigation', array('yes'=>'Yes', 'no'=>'No'), $navigation, 'Prev next and buttons'); ?></p>
        <p><?php echo eRadioButton($this, 'links', 'Links', array('yes'=>'Yes', 'no'=>'No'), $links, 'Show images as links'); ?></p>
        <p><?php echo eRadioButton($this, 'hoverPause', 'Hover Pause', array('yes'=>'Yes', 'no'=>'No'), $hoverPause, 'Pause on hover'); ?></p>
		<?php
	}
	
	function update($new_instance, $old_instance) 
	{
		return $new_instance;
	}
	
	function widget($args, $instance) 
	{
		extract($args);
		
		$title 		= getConfigValue($instance, 'title',	'');
		$categoryId = getConfigValue($instance, 'categoryId',	'');
		$noItem 	= getConfigValue($instance, 'noItem',		'5');
		$width 		= getConfigValue($instance, 'width', 		'565');
		$height 	= getConfigValue($instance, 'height', 		'290');
		$spw 		= getConfigValue($instance, 'spw', 			'7');
		$sph 		= getConfigValue($instance, 'sph', 			'5');
		$delay 		= getConfigValue($instance, 'delay', 		'3000');
		$sDelay 	= getConfigValue($instance, 'sDelay', 		'30');
		$opacity 	= getConfigValue($instance, 'opacity', 		'0.7');
		$titleSpeed = getConfigValue($instance, 'titleSpeed', 	'500');
		$effect 	= getConfigValue($instance, 'effect', 		'random');
		$navigation = getConfigValue($instance, 'navigation', 	'yes');
		$links 		= getConfigValue($instance, 'links', 		'yes');
		$hoverPause = getConfigValue($instance, 'hoverPause', 	'yes');
		
		// get data
		$posts = get_posts('category='.$categoryId.'&numberposts='.$noItem);
		
		echo $before_widget;
		if($title) echo $before_title . $title . $after_title;
		
		if(count($posts)) :
		?>
        <style type="text/css">
		.coin-slider {
			width: <?php echo $width; ?>px;
			height: <?php echo $height + 30; ?>px;
		}
		</style>
        <div id="tcvn-coinslider">
        	<?php
				foreach($posts as $post) :
					
					$thumbnailId 	= get_post_meta($post->ID, '_thumbnail_id', true);
					$fullImage		= wp_get_attachment_url($thumbnailId);
					$text 			= $post->post_content;
					$newImage       = TCVN_COINSLIDER_INC_URI . '/timthumb.php?src=' . $fullImage . '&w=' . $width . '&h=' .$height;
	
					$permalink 	= $post->guid;
					$theTitle	= $post->post_title;
				
					if(wp_attachment_is_image($thumbnailId)) :
						if($fullImage != '') :
							echo '<a href="' . $permalink . '">';
								echo '<img src="' . $newImage . '" />';
								echo '<span><strong>' . $theTitle . '</strong><br />' . $text . '</span>';
							echo '</a>';
						endif;
					endif;
					
				endforeach;
			?>
        </div>
        <div id="tcvn-copyright">
        	<a href="http://vinathemes.biz" title="Free download Wordpress Themes, Wordpress Plugins - VinaThemes.biz">Free download Wordpress Themes, Wordpress Plugins - VinaThemes.biz</a>
        </div>
        <script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#tcvn-coinslider').coinslider({
					effect: 		'<?php echo $effect; ?>',
					width: 			<?php echo $width; ?>, 
					height: 		<?php echo $height; ?>,
					links: 			<?php echo ($links == 'yes') ? 'true' : 'false'; ?>,
					spw: 			<?php echo $spw; ?>, 
					sph: 			<?php echo $sph; ?>, 
					delay: 			<?php echo $delay; ?>,
					sDelay: 		<?php echo $sDelay; ?>,
					opacity: 		<?php echo $opacity; ?>,
					titleSpeed: 	<?php echo $titleSpeed; ?>,
					navigation: 	<?php echo ($navigation == 'yes') ? 'true' : 'false'; ?>,
					hoverPause:		<?php echo ($hoverPause == 'yes') ? 'true' : 'false'; ?>
				});
			});
		</script>
		<?php
		endif;
		echo $after_widget;	
	}
}

add_action('widgets_init', create_function('', 'return register_widget("CoinSlider_Widget");'));
wp_enqueue_style('coinslider-css', TCVN_COINSLIDER_INC_URI . '/css/style.css', '', '1.0', 'screen' );
wp_enqueue_style('coinslider-admin-css', TCVN_COINSLIDER_INC_URI . '/admin/css/style.css', '', '1.0', 'screen' );
wp_enqueue_script('jquery');
wp_enqueue_script('coinslider-javascript', TCVN_COINSLIDER_INC_URI . '/js/jquery.coinslider.js', 'jquery', '1.0', true);
?>