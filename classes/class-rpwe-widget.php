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
		?>
		<div class="rpwe-options">

			<div class="rpwe-tabs">

				<ul id="rpwe-tabs-nav">
					<li><a href="#tab1"><?php esc_html_e( 'General', 'recent-posts-widget-extended' ); ?></a></li>
					<li><a href="#tab2"><?php esc_html_e( 'Posts', 'recent-posts-widget-extended' ); ?></a></li>
					<li><a href="#tab3"><?php esc_html_e( 'Image', 'recent-posts-widget-extended' ); ?></a></li>
					<li><a href="#tab4"><?php esc_html_e( 'Excerpt', 'recent-posts-widget-extended' ); ?></a></li>
					<li><a href="#tab5"><?php esc_html_e( 'Control', 'recent-posts-widget-extended' ); ?></a></li>
					<li><a href="#tab6"><?php esc_html_e( 'Style', 'recent-posts-widget-extended' ); ?></a></li>
					<li><a href="#tab7"><?php esc_html_e( 'Support', 'recent-posts-widget-extended' ); ?></a></li>
				</ul>

				<div id="rpwe-tabs-content">

					<div id="tab1" class="rpwe-tab-content">
						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
								<?php esc_attr_e( 'Title', 'recent-posts-widget-extended' ); ?>
							</label>
							<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
						</p>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'title_url' ) ); ?>">
								<?php esc_attr_e( 'Title URL', 'recent-posts-widget-extended' ); ?>
							</label>
							<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_url' ) ); ?>" type="text" value="<?php echo esc_url( $instance['title_url'] ); ?>" />
						</p>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'css_id' ) ); ?>">
								<?php esc_attr_e( 'Container ID', 'recent-posts-widget-extended' ); ?>
							</label>
							<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'css_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'css_id' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['css_id'] ); ?>" />
						</p>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'css_class' ) ); ?>">
								<?php esc_attr_e( 'Container Class', 'recent-posts-widget-extended' ); ?>
							</label>
							<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'css_class' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'css_class' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['css_class'] ); ?>" />
						</p>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'before' ) ); ?>">
								<?php esc_attr_e( 'HTML or text before the recent posts', 'recent-posts-widget-extended' ); ?>
							</label>
							<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'before' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'before' ) ); ?>" rows="5"><?php echo wp_kses_post( htmlspecialchars( stripslashes( $instance['before'] ) ) ); ?></textarea>
						</p>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'after' ) ); ?>">
								<?php esc_attr_e( 'HTML or text after the recent posts', 'recent-posts-widget-extended' ); ?>
							</label>
							<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'after' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'after' ) ); ?>" rows="5"><?php echo wp_kses_post( htmlspecialchars( stripslashes( $instance['after'] ) ) ); ?></textarea>
						</p>
					</div>

					<div id="tab2" class="rpwe-tab-content">

						<p>
							<input class="checkbox" type="checkbox" <?php checked( $instance['ignore_sticky'], 1 ); ?> id="<?php echo esc_attr( $this->get_field_id( 'ignore_sticky' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ignore_sticky' ) ); ?>" />
							<label for="<?php echo esc_attr( $this->get_field_id( 'ignore_sticky' ) ); ?>">
								<?php esc_attr_e( 'Ignore sticky posts', 'recent-posts-widget-extended' ); ?>
							</label>
						</p>

						<p>
							<input class="checkbox" type="checkbox" <?php checked( $instance['exclude_current'], 1 ); ?> id="<?php echo esc_attr( $this->get_field_id( 'exclude_current' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude_current' ) ); ?>" />
							<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_current' ) ); ?>">
								<?php esc_attr_e( 'Exclude current post', 'recent-posts-widget-extended' ); ?>
							</label>
						</p>

						<div class="rpwe-multiple-check-form">
							<label>
								<?php esc_attr_e( 'Post Types', 'recent-posts-widget-extended' ); ?>
							</label>
							<?php foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $posttype ) : ?>
								<p>
									<input type="checkbox" value="<?php echo esc_attr( $posttype->name ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ) . '-' . esc_attr( $posttype->name ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>[]" <?php checked( is_array( $instance['post_type'] ) && in_array( $posttype->name, $instance['post_type'], true ) ); ?> />
									<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ) . '-' . esc_attr( $posttype->name ); ?>">
										<?php echo esc_html( $posttype->labels->name ); ?>
									</label>
								</p>
							<?php endforeach; ?>
						</div>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'post_status' ) ); ?>">
								<?php esc_attr_e( 'Post Status', 'recent-posts-widget-extended' ); ?>
							</label>
							<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_status' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_status' ) ); ?>" style="width:100%;">
								<?php foreach ( array_keys( get_object_vars( wp_count_posts( 'post' ) ) ) as $status_value => $status_label ) { ?>
									<option value="<?php echo esc_attr( $status_label ); ?>" <?php selected( $instance['post_status'], $status_label ); ?>><?php echo esc_html( ucfirst( $status_label ) ); ?></option>
								<?php } ?>
							</select>
						</p>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
								<?php esc_attr_e( 'Order', 'recent-posts-widget-extended' ); ?>
							</label>
							<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" style="width:100%;">
								<option value="DESC" <?php selected( $instance['order'], 'DESC' ); ?>><?php esc_attr_e( 'Descending', 'recent-posts-widget-extended' ); ?></option>
								<option value="ASC" <?php selected( $instance['order'], 'ASC' ); ?>><?php esc_attr_e( 'Ascending', 'recent-posts-widget-extended' ); ?></option>
							</select>
						</p>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>">
								<?php esc_attr_e( 'Orderby', 'recent-posts-widget-extended' ); ?>
							</label>
							<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" style="width:100%;">
								<option value="ID" <?php selected( $instance['orderby'], 'ID' ); ?>><?php esc_attr_e( 'ID', 'recent-posts-widget-extended' ); ?></option>
								<option value="author" <?php selected( $instance['orderby'], 'author' ); ?>><?php esc_attr_e( 'Author', 'recent-posts-widget-extended' ); ?></option>
								<option value="title" <?php selected( $instance['orderby'], 'title' ); ?>><?php esc_attr_e( 'Title', 'recent-posts-widget-extended' ); ?></option>
								<option value="date" <?php selected( $instance['orderby'], 'date' ); ?>><?php esc_attr_e( 'Date', 'recent-posts-widget-extended' ); ?></option>
								<option value="modified" <?php selected( $instance['orderby'], 'modified' ); ?>><?php esc_attr_e( 'Modified', 'recent-posts-widget-extended' ); ?></option>
								<option value="rand" <?php selected( $instance['orderby'], 'rand' ); ?>><?php esc_attr_e( 'Random', 'recent-posts-widget-extended' ); ?></option>
								<option value="comment_count" <?php selected( $instance['orderby'], 'comment_count' ); ?>><?php esc_attr_e( 'Comment Count', 'recent-posts-widget-extended' ); ?></option>
								<option value="menu_order" <?php selected( $instance['orderby'], 'menu_order' ); ?>><?php esc_attr_e( 'Menu Order', 'recent-posts-widget-extended' ); ?></option>
							</select>
						</p>

						<div class="rpwe-multiple-check-form">
							<label>
								<?php esc_attr_e( 'Limit to Category', 'recent-posts-widget-extended' ); ?>
							</label>

							<?php foreach ( rpwe_cats_list() as $category ) : ?>
								<p>
									<input type="checkbox" value="<?php echo (int) $category->term_id; ?>" id="<?php echo esc_attr( $this->get_field_id( 'cat' ) ) . '-' . (int) $category->term_id; ?>" name="<?php echo esc_attr( $this->get_field_name( 'cat' ) ); ?>[]" <?php checked( is_array( $instance['cat'] ) && in_array( $category->term_id, $instance['cat'], true ) ); ?> />
									<label for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ) . '-' . (int) $category->term_id; ?>">
										<?php echo esc_html( $category->name ); ?>
									</label>
								</p>
							<?php endforeach; ?>
						</div>

						<div class="rpwe-multiple-check-form">
							<label>
								<?php esc_attr_e( 'Limit to Tag', 'recent-posts-widget-extended' ); ?>
							</label>
							<?php foreach ( rpwe_tags_list() as $post_tag ) : ?>
								<p>
									<input type="checkbox" value="<?php echo (int) $post_tag->term_id; ?>" id="<?php echo esc_attr( $this->get_field_id( 'tag' ) ) . '-' . (int) $post_tag->term_id; ?>" name="<?php echo esc_attr( $this->get_field_name( 'tag' ) ); ?>[]" <?php checked( is_array( $instance['tag'] ) && in_array( $post_tag->term_id, $instance['tag'], true ) ); ?> />
									<label for="<?php echo esc_attr( $this->get_field_id( 'tag' ) ) . '-' . (int) $post_tag->term_id; ?>">
										<?php echo esc_html( $post_tag->name ); ?>
									</label>
								</p>
							<?php endforeach; ?>
						</div>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>">
								<?php esc_attr_e( 'Limit to Taxonomy', 'recent-posts-widget-extended' ); ?>
							</label>
							<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>" value="<?php echo esc_attr( $instance['taxonomy'] ); ?>" />
							<small>
								<?php esc_attr_e( 'Ex: category=1,2,4&amp;post_tag=6,12. ', 'recent-posts-widget-extended' ); ?>
								<?php
								esc_attr_e( 'Available: ', 'recent-posts-widget-extended' );
								echo implode( ', ', get_taxonomies( array( 'public' => true ) ) );
								?>
							</small>
						</p>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>">
								<?php esc_attr_e( 'Number of posts to show', 'recent-posts-widget-extended' ); ?>
							</label>
							<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="number" step="1" min="-1" value="<?php echo (int) ( $instance['limit'] ); ?>" />
						</p>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>">
								<?php esc_attr_e( 'Offset', 'recent-posts-widget-extended' ); ?>
							</label>
							<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" step="1" min="0" value="<?php echo (int) ( $instance['offset'] ); ?>" />
							<small><?php esc_attr_e( 'The number of posts to skip', 'recent-posts-widget-extended' ); ?></small>
						</p>
					</div>

					<div id="tab3" class="rpwe-tab-content">
						<?php if ( current_theme_supports( 'post-thumbnails' ) ) { ?>

							<p>
								<input id="<?php echo esc_attr( $this->get_field_id( 'thumb' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb' ) ); ?>" type="checkbox" <?php checked( $instance['thumb'] ); ?> />
								<label for="<?php echo esc_attr( $this->get_field_id( 'thumb' ) ); ?>">
										<?php esc_attr_e( 'Display Thumbnail', 'recent-posts-widget-extended' ); ?>
								</label>
							</p>

							<p>
								<label class="rpwe-block" for="<?php echo esc_attr( $this->get_field_id( 'thumb_height' ) ); ?>">
										<?php esc_attr_e( 'Thumbnail (height,width,align)', 'recent-posts-widget-extended' ); ?>
								</label>

								<input class="small-input" id="<?php echo esc_attr( $this->get_field_id( 'thumb_height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_height' ) ); ?>" type="number" step="1" min="0" value="<?php echo (int) ( $instance['thumb_height'] ); ?>" />

								<input class="small-input" id="<?php echo esc_attr( $this->get_field_id( 'thumb_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_width' ) ); ?>" type="number" step="1" min="0" value="<?php echo (int) ( $instance['thumb_width'] ); ?>" />

								<select class="small-input" id="<?php echo esc_attr( $this->get_field_id( 'thumb_align' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_align' ) ); ?>">
									<option value="rpwe-alignleft" <?php selected( $instance['thumb_align'], 'rpwe-alignleft' ); ?>><?php esc_attr_e( 'Left', 'recent-posts-widget-extended' ); ?></option>
									<option value="rpwe-alignright" <?php selected( $instance['thumb_align'], 'rpwe-alignright' ); ?>><?php esc_attr_e( 'Right', 'recent-posts-widget-extended' ); ?></option>
									<option value="rpwe-aligncenter" <?php selected( $instance['thumb_align'], 'rpwe-aligncenter' ); ?>><?php esc_attr_e( 'Center', 'recent-posts-widget-extended' ); ?></option>
								</select>
							</p>

							<p>
								<label for="<?php echo esc_attr( $this->get_field_id( 'thumb_default' ) ); ?>">
										<?php esc_attr_e( 'Default Thumbnail', 'recent-posts-widget-extended' ); ?>
								</label>
								<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'thumb_default' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_default' ) ); ?>" type="text" value="<?php echo esc_url( $instance['thumb_default'] ); ?>" />
								<small><?php esc_attr_e( 'Leave it blank to disable.', 'recent-posts-widget-extended' ); ?></small>
							</p>

						<?php } ?>
					</div>

					<div id="tab4" class="rpwe-tab-content">
						<p>
							<input id="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt' ) ); ?>" type="checkbox" <?php checked( $instance['excerpt'] ); ?> />
							<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>">
								<?php esc_attr_e( 'Display Excerpt', 'recent-posts-widget-extended' ); ?>
							</label>
						</p>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>">
								<?php esc_attr_e( 'Excerpt Length', 'recent-posts-widget-extended' ); ?>
							</label>
							<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'length' ) ); ?>" type="number" step="1" min="0" value="<?php echo (int) ( $instance['length'] ); ?>" />
						</p>

						<p>
							<input id="<?php echo esc_attr( $this->get_field_id( 'readmore' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'readmore' ) ); ?>" type="checkbox" <?php checked( $instance['readmore'] ); ?> />
							<label for="<?php echo esc_attr( $this->get_field_id( 'readmore' ) ); ?>">
								<?php esc_attr_e( 'Display Readmore', 'recent-posts-widget-extended' ); ?>
							</label>
						</p>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'readmore_text' ) ); ?>">
								<?php esc_attr_e( 'Readmore Text', 'recent-posts-widget-extended' ); ?>
							</label>
							<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'readmore_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'readmore_text' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['readmore_text'] ); ?>" />
						</p>
					</div>

					<div id="tab5" class="rpwe-tab-content">
						<p>
							<input id="<?php echo esc_attr( $this->get_field_id( 'post_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_title' ) ); ?>" type="checkbox" <?php checked( $instance['post_title'] ); ?> />
							<label for="<?php echo esc_attr( $this->get_field_id( 'post_title' ) ); ?>">
								<?php esc_attr_e( 'Display post title', 'recent-posts-widget-extended' ); ?>
							</label>
						</p>
						<p>
							<input id="<?php echo esc_attr( $this->get_field_id( 'comment_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comment_count' ) ); ?>" type="checkbox" <?php checked( $instance['comment_count'] ); ?> />
							<label for="<?php echo esc_attr( $this->get_field_id( 'comment_count' ) ); ?>">
								<?php esc_attr_e( 'Display comment count', 'recent-posts-widget-extended' ); ?>
							</label>
						</p>

						<p>
							<input id="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date' ) ); ?>" type="checkbox" <?php checked( $instance['date'] ); ?> />
							<label for="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>">
								<?php esc_attr_e( 'Display date', 'recent-posts-widget-extended' ); ?>
							</label>
						</p>

						<p>
							<input id="<?php echo esc_attr( $this->get_field_id( 'date_modified' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_modified' ) ); ?>" type="checkbox" <?php checked( $instance['date_modified'] ); ?> />
							<label for="<?php echo esc_attr( $this->get_field_id( 'date_modified' ) ); ?>">
								<?php esc_attr_e( 'Use a modification date', 'recent-posts-widget-extended' ); ?>
							</label>
						</p>

						<p>
							<input id="<?php echo esc_attr( $this->get_field_id( 'date_relative' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_relative' ) ); ?>" type="checkbox" <?php checked( $instance['date_relative'] ); ?> />
							<label for="<?php echo esc_attr( $this->get_field_id( 'date_relative' ) ); ?>">
								<?php esc_attr_e( 'Use relative date. eg: 5 days ago', 'recent-posts-widget-extended' ); ?>
							</label>
						</p>

						<p>
							<input id="<?php echo esc_attr( $this->get_field_id( 'link_target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_target' ) ); ?>" type="checkbox" <?php checked( $instance['link_target'] ); ?> />
							<label for="<?php echo esc_attr( $this->get_field_id( 'link_target' ) ); ?>">
								<?php esc_attr_e( 'Open links in new tab', 'recent-posts-widget-extended' ); ?>
							</label>
						</p>
					</div>

					<div id="tab6" class="rpwe-tab-content">
						<p>
							<input id="<?php echo esc_attr( $this->get_field_id( 'styles_default' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'styles_default' ) ); ?>" type="checkbox" <?php checked( $instance['styles_default'] ); ?> />
							<label for="<?php echo esc_attr( $this->get_field_id( 'styles_default' ) ); ?>">
								<?php esc_attr_e( 'Use Default Styles', 'recent-posts-widget-extended' ); ?>
							</label>
						</p>

						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'css' ) ); ?>">
								<?php esc_attr_e( 'Custom CSS', 'recent-posts-widget-extended' ); ?>
							</label>
							<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'css' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'css' ) ); ?>" style="height:180px;"><?php echo esc_attr( $instance['css'] ); ?></textarea>
							<small><?php esc_attr_e( 'If you turn off the default styles, you can use these css code to customize the recent posts style.', 'recent-posts-widget-extended' ); ?></small>
						</p>
					</div>

					<div id="tab7" class="rpwe-tab-content">
						<p>
							<?php esc_html_e( 'If you are enjoying this plugin. I would appreciate a donation to help me keep coding and supporting this project!', 'recent-posts-widget-extende' ); ?>
						</p>
						<p><a class="button" href="https://paypal.me/satrya" target="_blank"><?php esc_html_e( 'Donate Now', 'recent-posts-widget-extended' ); ?></a></p>
					</div>

				</div>
			</div>
		</div>
		<?php
	}
}
