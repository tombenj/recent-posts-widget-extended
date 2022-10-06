<?php
/**
 * Defaults
 *
 * @package Recent Posts Extended
 */

/**
 * Sets up the default arguments.
 */
function rpwe_get_default_args() {

	$css_defaults = ".rpwe-block ul{\nlist-style: none !important;\nmargin-left: 0 !important;\npadding-left: 0 !important;\n}\n\n.rpwe-block li{\nborder-bottom: 1px solid #eee;\nmargin: 0 0 8px !important;\npadding: 5px 0 10px !important;\nlist-style-type: none !important;\ndisplay: block;\n}\n\n.rpwe-block a{\ndisplay: inline !important;\ntext-decoration: none;\n}\n\n.rpwe-block h3{\nbackground: none !important;\nclear: none;\nmargin-bottom: 0 !important;\nmargin-top: 0 !important;\nfont-weight: 400;\nfont-size: 12px !important;\nline-height: 1.5em;\n}\n\n.rpwe-thumb{\nborder: 1px solid #eee !important;\nbox-shadow: none !important;\nmargin: 2px 10px 2px 0 !important;\npadding: 3px !important;\n}\n\n.rpwe-summary{\nfont-size: 12px;\n}\n\n.rpwe-time{\ncolor: #bbb;\nfont-size: 11px;\n}\n\n.rpwe-comment{\ncolor: #bbb;\nfont-size: 11px;\npadding-left: 5px;\n}\n\n.rpwe-alignleft{\ndisplay: inline;\nfloat: left;\n}\n\n.rpwe-alignright{\ndisplay: inline;\nfloat: right;\n}\n\n.rpwe-aligncenter{\ndisplay: block;\nmargin-left: auto;\nmargin-right: auto;\n}\n\n.rpwe-clearfix:before,\n.rpwe-clearfix:after{\ncontent: \"\";\ndisplay: table !important;\n}\n\n.rpwe-clearfix:after{\nclear: both;\n}\n\n.rpwe-clearfix{\nzoom: 1;\n}\n";

	$defaults = array(
		'title'           => esc_attr__( 'Recent Posts', 'recent-posts-widget-extended' ),
		'title_url'       => '',

		'limit'           => 5,
		'offset'          => 0,
		'order'           => 'DESC',
		'orderby'         => 'date',
		'cat'             => array(),
		'tag'             => array(),
		'taxonomy'        => '',
		'post_type'       => array( 'post' ),
		'post_status'     => 'publish',
		'ignore_sticky'   => 1,
		'exclude_current' => 1,

		'excerpt'         => false,
		'length'          => 10,
		'thumb'           => true,
		'thumb_height'    => 45,
		'thumb_width'     => 45,
		'thumb_default'   => 'https://via.placeholder.com/45x45/f0f0f0/ccc',
		'thumb_align'     => 'rpwe-alignleft',
		'date'            => true,
		'date_relative'   => false,
		'date_modified'   => false,
		'readmore'        => false,
		'readmore_text'   => __( 'Read More &raquo;', 'recent-posts-widget-extended' ),
		'comment_count'   => false,

		// New.
		'post_title'      => true,
		'link_target'     => false,

		'styles_default'  => true,
		'css'             => $css_defaults,
		'cssID'           => '', // Deprecated.
		'css_id'          => '',
		'css_class'       => '',
		'before'          => '',
		'after'           => '',
	);

	// Allow plugins/themes developer to filter the default arguments.
	return apply_filters( 'rpwe_default_args', $defaults );
}
