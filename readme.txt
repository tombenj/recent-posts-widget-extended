=== Recent Posts Widget Extended ===
Contributors: satrya
Donate link: https://paypal.me/satrya
Tags: recent posts, random posts, popular posts, thumbnails, widget, widgets, sidebar, excerpt, category, post tag, taxonomy, post type, post status, shortcode, multiple widgets
Requires at least: 5.8
Tested up to: 6.0
Requires PHP: 7.2
Stable tag: 2.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Provides flexible and advanced recent posts. Display it via shortcode or widget with thumbnails, post excerpt, taxonomy and more.

== Description ==

= Support this project =

If you are enjoying this plugin. I would appreciate a cup of coffee to help me keep coding and supporting the project! [Support & donate](https://paypal.me/satrya).

= Plugin description =

This plugin will enable a custom, flexible and advanced recent posts, you can display it via shortcode or widget. Allows you to display a list of the most recent posts with thumbnail, excerpt and post date, also you can display it from all or specific or multiple taxonomy, post type and much more!

= Features Include =

* Display by date, comment count or random.
* Enable thumbnails, with customizable size and alignment.
* Enable excerpt, with customizable length.
* Display from all, specific or multiple category or tag.
* Enable post date.
* Display modification date.
* Display comment count.
* Post type support.
* Taxonomy support.
* Post status.
* Custom HTML or text before and/or after recent posts.
* **Shortcode feature**.
* Crop image on the fly.
* Enable Read more.
* Custom CSS.
* Multiple widgets.
* Available filter for developer.

= Links =

* Translate to [your language](https://translate.wordpress.org/projects/wp-plugins/recent-posts-widget-extended/).
* Contribute or submit issues on [Github](https://github.com/gasatrya/recent-posts-widget-extended).

== Installation ==

**Through Dashboard**

1. Log in to your WordPress admin panel and go to Plugins -> Add New
2. Type **recent posts widget extended** in the search box and click on search button.
3. Find Recent Posts Widget Extended plugin.
4. Then click on Install Now after that activate the plugin.
5. Go to the widgets page **Appearance -> Widgets**.
6. Find **Recent Posts Extended** widget.

**Installing Via FTP**

1. Download the plugin to your hardisk.
2. Unzip.
3. Upload the **recent-posts-widget-extended** folder into your plugins directory.
4. Log in to your WordPress admin panel and click the Plugins menu.
5. Then activate the plugin.
6. Go to the widgets page **Appearance -> Widgets**.
7. Find **Recent Posts Extended** widget.

== Frequently Asked Questions ==

= Shortcode Explanation =

Explanation of shortcode options:

Basic shortcode
`
[rpwe]
`

Display 10 recent posts
`
[rpwe limit="10"]
`

Display 10 recent posts without thumbnail
`
[rpwe limit="10" thumb="false"]
`

Open post link in new tab
`
[rpwe link_target="true"]
`

Disable default style
`
[rpwe styles_default="false"]
`

= Shortcode Arguments =

**Here are the full default shortcode arguments**
`
limit="5"
offset=""
order="DESC"
orderby="date"
post_type="post"
cat=""
tag=""
taxonomy=""
post_type="post"
post_status="publish"
ignore_sticky="1"
taxonomy=""

post_title="true"
link_target="false"
excerpt="false"
length="10"
thumb="true"
thumb_height="45"
thumb_width="45"
thumb_default="https://via.placeholder.com/45x45/f0f0f0/ccc"
thumb_align="rpwe-alignleft"
date="true"
readmore="false"
readmore_text="Read More &raquo;"

styles_default="true"
css_id=""
css_class=""
before=""
after=""
`

= How to filter the post query? =
You can use `rpwe_default_query_arguments` to filter it. Example:
`
add_filter( 'rpwe_default_query_arguments', 'your_custom_function' );
function your_custom_function( $args ) {
	$args['posts_per_page'] = 10; // Changing the number of posts to show.
	return $args;
}
`

= How to filter the post excerpt? =
Post excerpt now comes with filter to easily dev to change/customize it. `apply_filters( 'rpwe_excerpt', get_the_excerpt() )`

= Ordering not working! =
Did you installed any Post or Post Type Order? Please try to deactivate it and try again the ordering. [(related question)](http://wordpress.org/support/topic/ordering-set-to-descending-not-working)

= No image options =
Your theme needs to support Post Thumbnail, please go to http://codex.wordpress.org/Post_Thumbnails to read more info and how to activate it in your theme.

= How to add custom style? =
First, please uncheck the **Use Default Style** option then place the css code below on the Additional CSS panel on Customizer, then you can customize it to fit your needs
`
.rpwe-block ul {
	list-style: none !important;
	margin-left: 0 !important;
	padding-left: 0 !important;
}
.rpwe-block li {
	border-bottom: 1px solid #eee;
	margin-bottom: 10px;
	padding-bottom: 10px;
	list-style-type: none;
}
.rpwe-block a {
	display: inline !important;
	text-decoration: none;
}
.rpwe-block h3 {
	background: none !important;
	clear: none;
	margin-bottom: 0 !important;
	margin-top: 0 !important;
	font-weight: 400;
	font-size: 12px !important;
	line-height: 1.5em;
}
.rpwe-thumb {
	border: 1px solid #eee !important;
	box-shadow: none !important;
	margin: 2px 10px 2px 0;
	padding: 3px !important;
}
.rpwe-summary {
	font-size: 12px;
}
.rpwe-time {
	color: #bbb;
	font-size: 11px;
}
.rpwe-alignleft {
	display: inline;
	float: left;
}
.rpwe-alignright {
	display: inline;
	float: right;
}
.rpwe-aligncenter {
	display: block;
	margin-left: auto;
	margin-right: auto;
}
.rpwe-clearfix:before,.rpwe-clearfix:after {
	content: "";
	display: table !important;
}
.rpwe-clearfix:after {
	clear: both;
}
.rpwe-clearfix {
	zoom: 1;
}
`

= Why so many !important in the css code? =
I know it's not good but I have a good reason, the `!important` is to make sure the built-in style compatible with all themes. But if you don't like it, you can turn of the **Use Default Styles** and remove all custom css code in the **Custom CSS** box then create your own style.

= Available filters =
Default arguments
`
rpwe_default_args
`

Post excerpt
`
rpwe_excerpt
`

Post markup
`
rpwe_markup
`

Post query arguments
`
rpwe_default_query_arguments
`

== Screenshots ==

1. Classic widget
2. Block widget
3. Shortcode

== Changelog ==

**2.0 - Major Changes**   
*Release Date: Sept 22, 2022*

This release comes major changes to the codebase, several fixes and enhancements. The reason was to follow the latest WordPress coding standard, more secure. **Classic widget and block widget is now supported!**

**Breaking Changes:**

- **CSS ID** shortcode attribute for the container was `cssID` or `cssid`, please use `css_id` instead.
- **CSS ID** widget, please re-added your ID to the input field.
- `before` and `after` shortcode attribute move to inside the recent posts container.
- Widget **custom style** location change. If your style is not loaded, please re-save the widget.
- **Custom CSS** no longer editable, please move your custom CSS to the Additional CSS panel on Customizer.

**Enhancements:**

- Classic & blocks widget supported!
- Support **lazy** loading for the thumbnail.
- No more inline CSS, by default `rpwe-frontend.css` will be loaded if shortcode or widget present.
- No more `extract()`. [ref](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/#dont-extract)
- **New** show hide the post title.

**Bug fixes:**

- Default image wasn't working correctly.
- `true` or `false` shortcode value.
