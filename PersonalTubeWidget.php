<?php
/**
 * Plugin Name: PersonalTube Video Widget
 * Plugin URI: http://www.personaltube.com/publisher/install/wordpress_video_widget
 * Description: A personalized video widget that gives you precise control over its videos, style and appearance. Requires PersonalTube signup: http://www.personaltube.com/publisher/signup
 * Version: 2.0
 * Author: PersonalTube
 * Author URI: http://www.personaltube.com/publisher/install/wordpress_video_widget
 *
 */

 /*  Copyright 2009-2011 PersonalTube  (email: support@personaltube.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'load_PersonalTube_widgets' );

/**
 * Register our widget.
 * 'PersonalTube_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function load_PersonalTube_widgets() {
	register_widget( 'PersonalTube_Widget' );
}


class PersonalTube_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function PersonalTube_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'PersonalTube', 'description' => __('A video widget that is always refreshed with the latest videos personalized just for your blog. Requires PersonalTube signup (http://www.personaltube.com/publisher/signup)', 'PersonalTube') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'personaltube-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'personaltube-widget', __('PersonalTube Video Widget', 'personaltube'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		//$title = apply_filters('widget_title', $instance['title'] );
		$content= $instance['content'];

                 $array_split = explode('#@#',$content);

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		//if ( $title )
			echo $before_title . $after_title;
            echo '<link media="screen" type="text/css" rel="stylesheet" '.
		         'href="http://app.personaltube.com/style/personaltubeStyles.css"/>'.
                 '<div id="PersonalTube_DivId">  </div>'.
                 '<script src="http://app.personaltube.com/script/personaltubeUtils.js">'. '</script>'.
				 '<script language="JavaScript" type="text/javascript" '.
                 'src="http://app.personaltube.com/script/widgetType/carousel/ptContentflow.js" '.
				 'load="fancyScrollbar">'.'</script>'.
                 '<script type="text/javascript">'.
                 'var PersonalTube_Organization_Name = "'.$array_split[0].'";'.
			 'var PersonalTube_Organization_ID = "'.$array_split[1].'";'.
			 'var PersonalTube_Feed_ID = "'.$array_split[2].'";'.
			 'var PersonalTube_DivId = "PersonalTube_DivId";'.
			 'var PersonalTube_AppServerPath = "http://app.personaltube.com";'.
	          '</script>'.
                  '<script src="http://app.personaltube.com/script/personaltube.js">'.
	          '</script>';             

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['content'] = strip_tags( $new_instance['content'] );

		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('', ''), 'content' => __('', '') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		

		<!-- Your Content: TextArea Input -->
                <p>
                   Enter the WordPress Configuration String from your PersonalTube account, and then click Save.
                   To obtain this string, <a href="http://www.personaltube.com/publisher/login">login to your PersonalTube account</a> to personalize the widget. Select "Install Widget," from the left menu and then select "WordPress.org Blog Sidebar."
                </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e('Configuration String:', 'PersonalTube'); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" style="width:100%;"><?php echo $instance['content']; ?></textarea>
		</p>
<p> If you do not have a PersonalTube account, please <a href="http://www.personaltube.com/publisher/signup">sign up</a>.</p>

	<?php
	}
}

?>