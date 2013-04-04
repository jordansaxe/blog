<?php

/*-----------------------------------------------------------------------------------*/
/* Twitter Widget
/*-----------------------------------------------------------------------------------*/

add_action( 'widgets_init', 'load_ok_twitter_widget' );

function load_ok_twitter_widget() {
	register_widget( 'okTwitterWidget' );
}

class okTwitterWidget extends WP_Widget {
	function okTwitterWidget() {
	$widget_ops = array( 'classname' => 'ok-twitter', 'description' => __('Grab your latest tweets', 'ok-twitter') );
	$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ok-twitter' );
	$this->WP_Widget( 'ok-twitter', __('Okay Twitter Widget', 'ok-twitter'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		extract( $args );
		$twitter_title = esc_attr( $instance['twitter_title'] );
		$twitter_user = esc_attr( $instance['twitter_user'] );
		$twitter_count = esc_attr( $instance['twitter_count'] );
		
		echo $before_widget;
?>
		
		<div class="twitter-widget">
			<h2 class="twitter-title widgettitle"><?php echo $instance['twitter_title']; ?></h2>			
			<script type="text/javascript">
				
				Chirp({
			      user: '<?php echo $instance['twitter_user']; ?>',
			      max: <?php echo $instance['twitter_count']; ?>,
			      error: twittererror,
			      templates: {
			      	base: '<ul class="chirp">{{tweets}}</ul>',
			      	tweet: '<li><p><a class="chirp-avatar" href="http://twitter.com/{{user.screen_name}}" title="{{user.name}} ? {{user.description}}"><img alt="profile-image" src="{{user.profile_image_url}}"></a> {{html}}</p><span class="meta"><time><a href="http://twitter.com/{{user.screen_name}}/statuses/{{id_str}}">{{time_ago}}</a></time> &mdash; via <a href="http://twitter.com/{{user.screen_name}}" title="{{user.name}} ? {{user.description}}">{{user.name}}</a></span></li>'
			      }
			    })
			    
			    function twittererror(){
				    $errortext = 'Having trouble retreiving tweets. Please stand by.';
				    return $errortext;
				}
			    
		    </script>
	    </div>


<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['twitter_title'] = $new_instance['twitter_title'];
		$instance['twitter_user'] = $new_instance['twitter_user'];
		$instance['twitter_count'] = $new_instance['twitter_count'];		
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'twitter_title' => '', 'twitter_user' => '', 'twitter_count' => '') );
		$instance['twitter_title'] = $instance['twitter_title'];
		$instance['twitter_user'] = $instance['twitter_user'];
		$instance['twitter_count'] = $instance['twitter_count'];
?>
			
	<p>
		<label for="<?php echo $this->get_field_id('twitter_title'); ?>"><?php _e('Title:','okay'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter_title'); ?>" name="<?php echo $this->get_field_name('twitter_title'); ?>" type="text" value="<?php echo $instance['twitter_title']; ?>" />
		</label>
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id('twitter_user'); ?>"><?php _e('Username:','okay'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter_user'); ?>" name="<?php echo $this->get_field_name('twitter_user'); ?>" type="text" value="<?php echo $instance['twitter_user']; ?>" />
		</label>
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id('twitter_count'); ?>"><?php _e('Tweet count:','okay'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter_count'); ?>" name="<?php echo $this->get_field_name('twitter_count'); ?>" type="text" value="<?php echo $instance['twitter_count']; ?>" />
		</label>
	</p>
              
  <?php
	}
}