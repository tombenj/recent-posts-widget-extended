<?php
/**
 * Widget forms.
 *
 * @package Recent Posts Extended
 */

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
						<option value="DESC" <?php selected( $instance['order'], 'DESC' ); ?>><?php esc_attr_e( 'Descending', 'rpwe' ); ?></option>
						<option value="ASC" <?php selected( $instance['order'], 'ASC' ); ?>><?php esc_attr_e( 'Ascending', 'rpwe' ); ?></option>
					</select>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>">
						<?php esc_attr_e( 'Orderby', 'recent-posts-widget-extended' ); ?>
					</label>
					<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" style="width:100%;">
						<option value="ID" <?php selected( $instance['orderby'], 'ID' ); ?>><?php esc_attr_e( 'ID', 'rpwe' ); ?></option>
						<option value="author" <?php selected( $instance['orderby'], 'author' ); ?>><?php esc_attr_e( 'Author', 'rpwe' ); ?></option>
						<option value="title" <?php selected( $instance['orderby'], 'title' ); ?>><?php esc_attr_e( 'Title', 'rpwe' ); ?></option>
						<option value="date" <?php selected( $instance['orderby'], 'date' ); ?>><?php esc_attr_e( 'Date', 'rpwe' ); ?></option>
						<option value="modified" <?php selected( $instance['orderby'], 'modified' ); ?>><?php esc_attr_e( 'Modified', 'rpwe' ); ?></option>
						<option value="rand" <?php selected( $instance['orderby'], 'rand' ); ?>><?php esc_attr_e( 'Random', 'rpwe' ); ?></option>
						<option value="comment_count" <?php selected( $instance['orderby'], 'comment_count' ); ?>><?php esc_attr_e( 'Comment Count', 'rpwe' ); ?></option>
						<option value="menu_order" <?php selected( $instance['orderby'], 'menu_order' ); ?>><?php esc_attr_e( 'Menu Order', 'rpwe' ); ?></option>
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
						<?php esc_attr_e( 'Ex: category=1,2,4&amp;post_tag=6,12. ', 'rpwe' ); ?>
						<?php
						esc_attr_e( 'Available: ', 'rpwe' );
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
					<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'css' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'css' ) ); ?>" style="height:180px;" readonly><?php echo esc_attr( $instance['css'] ); ?></textarea>
					<small><?php esc_attr_e( 'Custom CSS is no longer editable, please copy and paste your custom CSS to', 'recent-posts-widget-extended' ); ?></small>
					<small>
						<?php
							printf(
								'<a href="%1$s">%2$s</a>.',
								esc_url(
									add_query_arg(
										array(
											array( 'autofocus' => array( 'section' => 'custom_css' ) ),
											'return' => rawurlencode( remove_query_arg( wp_removable_query_args(), wp_unslash( $_SERVER['REQUEST_URI'] ) ) ),
										),
										admin_url( 'customize.php' )
									)
								),
								__( 'Additional CSS panel' )
							);
							?>
					</small>
				</p>
			</div>

		</div>
	</div>
</div>
