<?php
/**
 * Helpers functions
 *
 * @package Recent Posts Extended
 */

/**
 * Display the posts.
 *
 * @param array $args User input.
 * @return mixed
 */
function rposts_get_posts( $args = array() ) {

	// Merge the input arguments and the defaults.
	$defs = rposts_get_defaults();
	$args = wp_parse_args( $args, $defs );
	$id   = $args['id'];

	// Set up a default, empty variable.
	$html = '';

	// Get the posts query.
	$posts = rposts_get_query( $args );

	if ( $posts->have_posts() ) :

		// Container open
		// Filters the list of HTML tags that are valid for use as list containers.
		$allowed_container_tags = apply_filters( 'rposts_container_allowedtags', array( 'div', 'section', 'aside' ) );
		$container_tag          = $args['container_tag'] ? $args['container_tag'] : $defs['container_tag'];
		if ( is_string( $container_tag ) && in_array( $container_tag, $allowed_container_tags, true ) ) {
			$class = $args['container_class'] ? ' class="rposts ' . esc_attr( $args['container_class'] ) . '"' : ' class="rposts"';
			$id    = $args['id'] ? ' id="' . esc_attr( $args['id'] ) . '"' : '';
			$html .= '<' . esc_attr( $container_tag ) . $id . $class . '>';
		}
		$html .= apply_filters( 'rposts_container_open', '<div class="rposts__img">', $args );

		// Title.
		if ( $args['title'] ) {
			// Filters the list of HTML tags that are valid for use as title tags.
			$allowed_title_tags = apply_filters( 'rposts_title_allowedtags', array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'div' ) );
			if ( is_string( $args['title_tag'] ) && in_array( $args['title_tag'], $allowed_title_tags, true ) ) {
				$class = $args['title_class'] ? ' class="rposts__title ' . esc_attr( $args['title_class'] ) . '"' : ' class="rposts__title"';
				$html .= '<' . esc_attr( $args['title_tag'] ) . $class . '>';

				if ( $args['title_url'] ) {
					$html .= '<a href="' . esc_url( $args['title_url'] ) . '">' . esc_attr( $args['title'] ) . '</a>';
				} else {
					$html .= esc_attr( $args['title'] );
				}

				$html .= '</' . esc_attr( $args['title_tag'] ) . '>';
			}
		}

		// Item wrapper open
		// Filters the list of HTML tags that are valid for use as list wrappers.
		$allowed_items_wrap_tags = apply_filters( 'rposts_items_wrap_allowedtags', array( 'div', 'ul', 'ol' ) );
		if ( is_string( $args['items_tag'] ) && in_array( $args['items_tag'], $allowed_items_wrap_tags, true ) ) {
			$class = $args['items_class'] ? ' class="rposts__items ' . esc_attr( $args['items_class'] ) . '"' : ' class="rposts__items"';
			$html .= '<' . esc_attr( $args['items_tag'] ) . $class . '>';
		}

		// Loop through the query.
		while ( $posts->have_posts() ) :
			$posts->the_post();

			// Item open
			// Filters the list of HTML tags that are valid for use as list wrappers.
			$allowed_item_wrap_tags = apply_filters( 'rposts_item_wrap_allowedtags', array( 'li', 'div', 'article' ) );
			if ( is_string( $args['item_tag'] ) && in_array( $args['item_tag'], $allowed_item_wrap_tags, true ) ) {
				$class = $args['item_class'] ? ' class="rposts__item h-entry ' . esc_attr( $args['item_class'] ) . '"' : ' class="rposts__item"';
				$html .= '<' . esc_attr( $args['item_tag'] ) . $class . '>';
			}

			// Check if $['thumbnail'] is true and
			// check if the post has thumbnail.
			if ( $args['thumbnail'] && has_post_thumbnail() ) {

				// The thumbnail wrapper open.
				$html .= apply_filters( 'rposts_thumbnail_wrapper_open', '<div class="rposts__img">', $args );

				// The thumbnail link wrapper open.
				if ( $args['thumbnail_link'] ) {
					$html .= '<a class="rposts__img-link" href="' . esc_url( get_permalink() ) . '">';
				}

				if ( (int) $args['thumbnail_width'] || (int) $args['thumbnail_height'] ) {

					// Resize image.
					$image_url = rposts_image_resize( wp_get_attachment_url( get_post_thumbnail_id() ), (int) $args['thumbnail_width'], (int) $args['thumbnail_height'], true );

					$html .= '<img src="' . $image_url . '" class="rposts__img-image rpost__img-align-' . $args['thumbnail_align'] . '" alt="' . esc_attr( get_the_title() ) . '" loading="lazy" decoding="async">';

				} else {

					$html .= get_the_post_thumbnail(
						get_the_ID(),
						$args['thumbnail_size'],
						array(
							'alt'      => esc_attr( get_the_title() ),
							'class'    => 'rposts__img-image rposts__align-' . $args['thumbnail_align'],
							'loading'  => 'lazy',
							'decoding' => 'async',
						)
					);

				}

				// The thumbnail link wrapper close.
				if ( $args['thumbnail_link'] ) {
					$html .= '</a>';
				}

				// The thumbnail wrapper close.
				$html .= apply_filters( 'rposts_thumbnail_wrapper_close', '</div>', $args );
			}

			$html .= '<div class="rposts__content">';

			// Content title.
			// Filters the list of HTML tags that are valid for use as post title wrappers.
			$allowed_content_title_wrap = apply_filters( 'rposts_content_title_wrap_allowedtags', array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'p', 'span' ) );
			if ( is_string( $args['content_title_tag'] ) && in_array( $args['content_title_tag'], $allowed_content_title_wrap, true ) ) {
				$class = $args['content_title_class'] ? ' class="rposts__content-title ' . esc_attr( $args['content_title_class'] ) . '"' : ' class="rposts__post-title"';
				$html .= '<' . esc_attr( $args['content_title_tag'] ) . $class . '>';
			}

			// The content title link wrapper open.
			if ( $args['content_title_link'] ) {
				$html .= '<a class="rposts__content-link" href="' . esc_url( get_permalink() ) . '">';
			}

				// The content title.
				$html .= esc_attr( get_the_title() );

			// The content title link close.
			if ( $args['content_title_link'] ) {
				$html .= '</a>';
			}

			// Title tag close.
			if ( is_string( $args['content_title_tag'] ) && in_array( $args['content_title_tag'], $allowed_content_title_wrap, true ) ) {
				$html .= '</' . esc_attr( $args['content_title_tag'] ) . '>';
			}

			$html .= '</div>';

			// Item close.
			if ( is_string( $args['item_tag'] ) && in_array( $args['item_tag'], $allowed_item_wrap_tags, true ) ) {
				$html .= '</' . esc_attr( $args['item_tag'] ) . '>';
			}

		endwhile;

		// Items wrapper close.
		if ( is_string( $args['items_tag'] ) && in_array( $args['items_tag'], $allowed_items_wrap_tags, true ) ) {
			$html .= '</' . esc_attr( $args['items_tag'] ) . '>';
		}

		// Container close.
		if ( is_string( $container_tag ) && in_array( $container_tag, $allowed_container_tags, true ) ) {
			$html .= '</' . esc_attr( $container_tag ) . '><!-- Generated by http://wordpress.org/plugins/recent-posts-widget-extended/ -->';
		}

	endif;

	// Restore original Post Data.
	wp_reset_postdata();

	return $html;
}
