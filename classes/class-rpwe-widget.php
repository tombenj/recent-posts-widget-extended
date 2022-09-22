<?php
/**
 * The custom recent posts widget.
 * This widget gives total control over the output to the user.
 *
 * @package Recent Posts Extended
 */

/**
 * Custom widget.
 */
class RPWE_Widget extends WP_Widget {

	/**
	 * Sets up the widgets.
	 */
	public function __construct() {

		// Set up the widget options.
		$widget_options = array(
			'classname'                   => 'rpwe_widget recent-posts-extended',
			'description'                 => __( 'An advanced widget that gives you total control over the output of your site’s most recent Posts.', 'recent-posts-widget-extended' ),
			'customize_selective_refresh' => true,
		);

		// Widget options.
		$control_options = array(
			'width' => 500,
		);

		// Create the widget.
		parent::__construct(
			'rpwe_widget',
			__( 'Recent Posts Extended', 'recent-posts-widget-extended' ),
			$widget_options,
			$control_options
		);

		$this->alt_option_name = 'rpwe_widget';

		// Action to load custom script.
		add_action( 'load-widgets.php', array( $this, 'rpwe_widget_script' ) );
	}

	/**
	 * Load custom script.
	 */
	public function rpwe_widget_script() {
		add_action( 'admin_print_footer_scripts-widgets.php', array( $this, 'rpwe_custom_script' ) );
	}

	/**
	 * The custom script.
	 */
	public function rpwe_custom_script() {
		?>
		<script>
			( function ( $ ) {
				function rpwe_custom_bg_class() {
					$( '.rpwe-options' ).closest( '.widget-inside' ).addClass( 'rpwe-bg' )
					$( '.rpwe-options' ).closest( '.wp-block-legacy-widget__edit-form' ).addClass( 'rpwe-bg' )
				}

				function rpwe_custom_tabs() {
					// Show the first tab and hide the rest.
					$( '#rpwe-tabs-nav li:first-child' ).addClass( 'active' )
					$( '.rpwe-tab-content' ).hide()
					$( '.rpwe-tab-content:first-child' ).show()

					// Click the navigation.
					$( 'body' ).on( 'click', '#rpwe-tabs-nav li', function ( e ) {
						e.preventDefault()

						$( '#rpwe-tabs-nav li' ).removeClass( 'active' )
						$( this ).addClass( 'active' )
						$( '.rpwe-tab-content' ).hide()

						const activeTab = $( this ).find( 'a' ).attr( 'href' )
						$( `${activeTab}.rpwe-tab-content` ).show()
						return false
					})
				}

				rpwe_custom_bg_class()
				rpwe_custom_tabs()

				$( document ).on( 'widget-added', function () {
					rpwe_custom_bg_class()
					rpwe_custom_tabs()
				} );

				$( document ).on( 'widget-updated', function () {
					rpwe_custom_bg_class()
					rpwe_custom_tabs()
				} );
			} )( jQuery )
		</script>
		<?php
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @param array $args the arguments.
	 * @param array $instance form data.
	 * @return void
	 */
	public function widget( $args, $instance ) {

		$recent = rpwe_get_recent_posts( $instance );

		if ( $instance['styles_default'] ) {
			wp_enqueue_style( 'rpwe-style' );
		}

		if ( $recent ) {

			// Output the theme's $before_widget wrapper.
			echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			// If the default style is disabled then use the custom css if it's not empty.
			if ( ! $instance['styles_default'] && ! empty( $instance['css'] ) ) {
				echo '<style>' . esc_attr( $instance['css'] ) . '</style>';
			}

			// If both title and title url is not empty, display it.
			if ( ! empty( $instance['title_url'] ) && ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . '<a href="' . esc_url( $instance['title_url'] ) . '" title="' . esc_attr( $instance['title'] ) . '">' . apply_filters( 'widget_title', esc_attr( $instance['title'] ), $instance, $this->id_base ) . '</a>' . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				// If the title not empty, display it.
			} elseif ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', esc_attr( $instance['title'] ), $instance, $this->id_base ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			// Get the recent posts query.
			echo $recent; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			// Close the theme's widget wrapper.
			echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @param array $new_instance new instance.
	 * @param array $old_instance old instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

		// Validate post_type submissions.
		$name  = get_post_types( array( 'public' => true ), 'names' );
		$types = array();
		foreach ( $new_instance['post_type'] as $type ) {
			if ( in_array( $type, $name, true ) ) {
				$types[] = $type;
			}
		}
		if ( empty( $types ) ) {
			$types[] = 'post';
		}

		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['title_url'] = esc_url_raw( $new_instance['title_url'] );

		$instance['ignore_sticky']   = isset( $new_instance['ignore_sticky'] ) ? (bool) $new_instance['ignore_sticky'] : 0;
		$instance['exclude_current'] = isset( $new_instance['exclude_current'] ) ? (bool) $new_instance['exclude_current'] : 0;
		$instance['limit']           = intval( $new_instance['limit'] );
		$instance['offset']          = intval( $new_instance['offset'] );
		$instance['order']           = stripslashes( $new_instance['order'] );
		$instance['orderby']         = stripslashes( $new_instance['orderby'] );
		$instance['post_type']       = $types;
		$instance['post_status']     = stripslashes( $new_instance['post_status'] );
		$instance['cat']             = $new_instance['cat'];
		$instance['tag']             = $new_instance['tag'];
		$instance['taxonomy']        = esc_attr( $new_instance['taxonomy'] );

		$instance['excerpt']       = isset( $new_instance['excerpt'] ) ? (bool) $new_instance['excerpt'] : false;
		$instance['length']        = intval( $new_instance['length'] );
		$instance['date']          = isset( $new_instance['date'] ) ? (bool) $new_instance['date'] : false;
		$instance['date_relative'] = isset( $new_instance['date_relative'] ) ? (bool) $new_instance['date_relative'] : false;
		$instance['date_modified'] = isset( $new_instance['date_modified'] ) ? (bool) $new_instance['date_modified'] : false;
		$instance['readmore']      = isset( $new_instance['readmore'] ) ? (bool) $new_instance['readmore'] : false;
		$instance['readmore_text'] = sanitize_text_field( $new_instance['readmore_text'] );
		$instance['comment_count'] = isset( $new_instance['comment_count'] ) ? (bool) $new_instance['comment_count'] : false;

		// New.
		$instance['post_title']  = isset( $new_instance['post_title'] ) ? (bool) $new_instance['post_title'] : false;
		$instance['link_target'] = isset( $new_instance['link_target'] ) ? (bool) $new_instance['link_target'] : false;

		$instance['thumb']         = isset( $new_instance['thumb'] ) ? (bool) $new_instance['thumb'] : false;
		$instance['thumb_height']  = intval( $new_instance['thumb_height'] );
		$instance['thumb_width']   = intval( $new_instance['thumb_width'] );
		$instance['thumb_default'] = esc_url_raw( $new_instance['thumb_default'] );
		$instance['thumb_align']   = esc_attr( $new_instance['thumb_align'] );

		$instance['styles_default'] = isset( $new_instance['styles_default'] ) ? (bool) $new_instance['styles_default'] : false;
		$instance['css_id']         = sanitize_html_class( $new_instance['css_id'] );
		$instance['css_class']      = sanitize_html_class( $new_instance['css_class'] );
		$instance['css']            = $new_instance['css'];

		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['before'] = $new_instance['before'];
		} else {
			$instance['before'] = wp_kses_post( $new_instance['before'] );
		}

		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['after'] = $new_instance['after'];
		} else {
			$instance['after'] = wp_kses_post( $new_instance['after'] );
		}

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @param array $instance the widget settings.
	 * @return void
	 */
	public function form( $instance ) {

		// Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, rpwe_get_default_args() );

		// Loads the widget form.
		include RPWE_INCLUDES . '/form.php';
	}
}
