<?php
/**
 * Extends MP_CORE_Widget to create custom widget class.
 */
class MP_JPLAYER_Widget extends MP_CORE_Widget {
		
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'mp_jplayer_widget', // Base ID
			'MP jPlayer', // Name
			array( 'description' => __( 'Display jPlayer.', 'mp_jplayer' ), ) // Args
		);
		
		//enqueue scripts defined in MP_CORE_Widget
		add_action( 'admin_enqueue_scripts', array( $this, 'mp_widget_enqueue_scripts' ) );
				
		$this->_form = array (
			"field1" => array(
				'field_id' 			=> 'title',
				'field_title' 	=> __('Title:', 'mp_jplayer'),
				'field_description' 	=> NULL,
				'field_type' 	=> 'textbox',
			),
			"field2" => array(
				'field_id' 			=> 'jplayer_id',
				'field_title' 	=> __('Select the jPlayer to use:', 'mp_jplayer'),
				'field_description' 	=> NULL,
				'field_type' 	=> 'select',
				'field_select_values' => mp_core_get_all_posts_by_type('mp_jplayer'),
			),
		);
		
		//Filter for addons
		$this->_form = has_filter( 'mp_jplayer_widget_form' ) ? apply_filters( 'mp_jplayer_widget_form', $this->_form) : $this->_form;
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		//Load the current number of the slider 
		global $global_slider_num;
		
		//Extract the args
		extract( $args );
		$title = apply_filters( 'mp_jplayer_widget_title', isset($instance['title']) ? $instance['title'] : '' );
		
		/**
		 * Links Before Hook
		 */
		 do_action('mp_jplayer_before_widget');
		
		/**
		 * Widget Start and Title
		 */
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
			
		/**
		 * Widget Body
		 */
		
					
		//Display the jPlayer
		echo mp_jplayer($instance['jplayer_id']);
			
		/**
		 * Widget End
		 */
		echo $after_widget;
		
		/**
		 * Links After Hook
		 */
		 do_action('mp_jplayer_after_widget');
	}
}

add_action( 'register_sidebar', create_function( '', 'register_widget( "MP_JPLAYER_Widget" );' ) );