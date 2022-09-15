<?php
/**
 * Defauls
 *
 * @package Recent Posts Extended
 */

/**
 * Sets default value.
 *
 * @return array
 */
function rposts_get_defaults() {
	$defaults = array(
		'id'                    => wp_unique_id( 'rposts' ),

		// Markup.
		'title'                 => '',
		'title_url'             => '',
		'title_tag'             => 'h3',
		'title_class'           => '',
		'container_tag'         => 'div',
		'container_class'       => '',
		'container_id'          => '',
		'items_tag'             => 'div',
		'items_class'           => '',
		'item_tag'              => 'article',
		'item_class'            => '',
		'content_title_tag'     => 'h3',
		'content_title_link'    => true,
		'content_title_class'   => '',

		// The query.
		'posts_per_page'        => 5,
		'posts_order'           => 'DESC',
		'posts_orderby'         => 'date',
		'posts_password'        => 'null',
		'posts_offset'          => '',
		'ignore_sticky_posts'   => 0,
		'post_types'            => array( 'post' ),
		'include_post_ids'      => array(),
		'exclude_post_ids'      => array(),
		'include_authors'       => array(),
		'exclude_authors'       => array(),
		'include_categories'    => array(),
		'exclude_categories'    => array(),
		'include_tags'          => array(),
		'exclude_tags'          => array(),
		'include_status'        => array(),
		'keyword'               => '',
		'comment_count'         => '',
		'comment_count_compare' => '=',
		'custom_fields'         => '',

		// Extras.
		'excerpt'               => false,
		'excerpt_length'        => 10,
		'thumbnail'             => true,
		'thumbnail_link'        => true,
		'thumbnail_link_class'  => '',
		'thumbnail_size'        => 'thumbnail',
		'thumbnail_width'       => '',
		'thumbnail_height'      => '',
		'thumbnail_align'       => 'left',
		'date'                  => true,
		'date_relative'         => false,
		'date_modified'         => false,
		'read_more'             => false,
		'read_more_text'        => __( 'Read More &raquo;', 'recent-posts-widget-extended' ),
		'comment_count'         => false,
		'before'                => '',
		'after'                 => '',
	);

	// Allows developer to filter the default arguments.
	return apply_filters( 'rposts_get_defaults', $defaults );
}
