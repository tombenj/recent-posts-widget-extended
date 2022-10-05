<?php
/**
 * Various functions used by the plugin.
 *
 * @package Recent Posts Extended
 */

/**
 * Function to display the recent posts.
 *
 * @param array $args the arguments.
 * @return void
 */
function rpwe_recent_posts( $args = array() ) {
	echo wp_kses_post( rpwe_get_recent_posts( $args ) );
}

/**
 * Generates the posts markup.
 *
 * @param  array $args the arguments.
 * @return string|array The HTML for the posts.
 */
function rpwe_get_recent_posts( $args = array() ) {

	// Set up a default, empty variable.
	$html = '';

	// Merge the input arguments and the defaults.
	$args = wp_parse_args( $args, rpwe_get_default_args() );

	// Allow devs to hook in stuff before the loop.
	do_action( 'rpwe_before_loop' );

	// Get the posts query.
	$posts = rpwe_get_posts( $args );

	if ( $posts->have_posts() ) {

		// Link target.
		$link_target = $args['link_target'] ? '_blank' : '_self';

		// Recent posts wrapper.
		$wrapper_id    = $args['css_id'] ? ' id="' . esc_attr( $args['css_id'] ) . '"' : '';
		$wrapper_class = $args['css_class'] ? ' class="rpwe-block ' . esc_attr( $args['css_class'] ) . '"' : ' class="rpwe-block"';
		$html         .= '<div ' . $wrapper_id . $wrapper_class . '>';

		// Text or HTML before the posts.
		$html .= apply_filters( 'rpwe_before', wp_kses_post( $args['before'] ) );

		// List wrapper.
		$html .= '<ul class="rpwe-ul">';

		// Start the query.
		while ( $posts->have_posts() ) {
			$posts->the_post();

			// Start recent posts markup.
			$html .= '<li class="rpwe-li rpwe-clearfix">';

			if ( $args['thumb'] ) {

				// Thumbnails.
				$thumb_id = get_post_thumbnail_id(); // Get the featured image id.
				$img_url  = wp_get_attachment_url( $thumb_id ); // Get img URL.
				$image    = rpwe_image_resize( $img_url, $args['thumb_width'], $args['thumb_height'], true ); // Rezize image on the fly.

				// Check if post has post thumbnail.
				if ( has_post_thumbnail() ) {

					// Thumbnail link.
					$html .= '<a class="rpwe-img" href="' . esc_url( get_permalink() ) . '" target="' . $link_target . '">';

					// Display the image.
					if ( $image ) {
						$html .= '<img class="' . esc_attr( $args['thumb_align'] ) . ' rpwe-thumb" src="' . esc_url( $image ) . '" alt="' . esc_attr( get_the_title() ) . '" height="' . absint( $args['thumb_height'] ) . '" width="' . absint( $args['thumb_width'] ) . '" loading="lazy" decoding="async">';
					} else {
						$html .= get_the_post_thumbnail(
							get_the_ID(),
							array( $args['thumb_width'], $args['thumb_height'] ),
							array(
								'class' => $args['thumb_align'] . ' rpwe-thumb the-post-thumbnail',
								'alt'   => esc_attr( get_the_title() ),
							)
						);
					}

					// Thumbnail link close.
					$html .= '</a>';

					// If no post thumbnail found, check if Get The Image plugin exist and display the image.
				} elseif ( function_exists( 'get_the_image' ) ) {
					$html .= get_the_image(
						array(
							'height'        => (int) $args['thumb_height'],
							'width'         => (int) $args['thumb_width'],
							'image_class'   => esc_attr( $args['thumb_align'] ) . ' rpwe-thumb get-the-image',
							'image_scan'    => true,
							'echo'          => false,
							'default_image' => esc_url( $args['thumb_default'] ),
						)
					);

					// Display default image.
				} elseif ( ! empty( $args['thumb_default'] ) ) {
					$html .= sprintf(
						'<a class="rpwe-img" href="%1$s" rel="bookmark"><img class="%2$s rpwe-thumb rpwe-default-thumb" src="%3$s" alt="%4$s" width="%5$s" height="%6$s"></a>',
						esc_url( get_permalink() ),
						esc_attr( $args['thumb_align'] ),
						esc_url( $args['thumb_default'] ),
						esc_attr( get_the_title() ),
						(int) $args['thumb_width'],
						(int) $args['thumb_height']
					);

				}
			}

			// The title.
			if ( $args['post_title'] ) {
				$html .= apply_filters( 'rpwe_post_title_wrap_open', '<h3 class="rpwe-title">' );
				$html .= '<a href="' . esc_url( get_permalink() ) . '" target="' . $link_target . '">' . esc_attr( get_the_title() ) . '</a>';
				$html .= apply_filters( 'rpwe_post_title_wrap_close', '</h3>' );
			}

			if ( $args['date'] ) {
				$date = get_the_date();
				if ( $args['date_relative'] ) {
					/* translators: %s: current time */
					$date = sprintf( __( '%s ago', 'recent-posts-widget-extended' ), human_time_diff( get_the_date( 'U' ), strtotime( wp_date( 'Y-m-d H:i:s' ) ) ) );
				}
				$html .= '<time class="rpwe-time published" datetime="' . esc_html( get_the_date( 'c' ) ) . '">' . esc_html( $date ) . '</time>';
			} elseif ( $args['date_modified'] ) { // if both date functions are provided, we use date to be backwards compatible.
				$date = get_the_modified_date();
				if ( $args['date_relative'] ) {
					/* translators: %s: current time */
					$date = sprintf( __( '%s ago', 'recent-posts-widget-extended' ), human_time_diff( get_the_modified_date( 'U' ), strtotime( wp_date( 'Y-m-d H:i:s' ) ) ) );
				}
				$html .= '<time class="rpwe-time modified" datetime="' . esc_html( get_the_modified_date( 'c' ) ) . '">' . esc_html( $date ) . '</time>';
			}

			if ( $args['comment_count'] ) {
				if ( get_comments_number() === 0 ) {
					$comments = __( 'No Comments', 'recent-posts-widget-extended' );
				} elseif ( get_comments_number() > 1 ) {
					/* translators: %s: comment count */
					$comments = sprintf( __( '%s Comments', 'recent-posts-widget-extended' ), get_comments_number() );
				} else {
					$comments = __( '1 Comment', 'recent-posts-widget-extended' );
				}
				$html .= '<a class="rpwe-comment comment-count" href="' . get_comments_link() . '">' . $comments . '</a>';
			}

			if ( $args['excerpt'] ) {
				$html .= '<div class="rpwe-summary">';
				$html .= wp_trim_words( apply_filters( 'rpwe_excerpt', get_the_excerpt() ), $args['length'], ' &hellip;' );
				if ( $args['readmore'] ) {
					$html .= '<a href="' . esc_url( get_permalink() ) . '" class="more-link">' . $args['readmore_text'] . '</a>';
				}
				$html .= '</div>';
			}

			$html .= '</li>';

		}

		$html .= '</ul>';

		$html .= apply_filters( 'rpwe_after', wp_kses_post( $args['after'] ) );

		$html .= '</div><!-- Generated by http://wordpress.org/plugins/recent-posts-widget-extended/ -->';

	}

	// Restore original Post Data.
	wp_reset_postdata();

	// Allow devs to hook in stuff after the loop.
	do_action( 'rpwe_after_loop' );

	// Return the  posts markup.
	return apply_filters( 'rpwe_markup', $html, $args );
}
