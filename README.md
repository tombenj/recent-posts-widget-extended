# Recent Posts Widget Extended

A WordPress plugin to enable a custom, flexible and advanced recent posts, you can display it via shortcode or widget. Allows you to display a list of the most recent posts with thumbnail, excerpt and post date, also you can display it from all or specific or multiple taxonomy, post type and much more!

> If you are enjoying this plugin. I would appreciate a cup of coffee to help me keep coding and supporting the project! [Support & Donate Now](https://www.buymeacoffee.com/gasatrya).

## Features Include

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

## Links

* Translate to [your language](https://translate.wordpress.org/projects/wp-plugins/recent-posts-widget-extended/).
* Contribute or submit issues on [Github](https://github.com/gasatrya/recent-posts-widget-extended/issues).

## Frequently Asked Questions

<details>
  <summary>Shortcode explanation</summary>

  Basic shortcode
  ```
  [rpwe]
  ```

  Display 10 recent posts
  ```
  [rpwe limit="10"]
  ```

  Display 10 recent posts without thumbnail
  ```
  [rpwe limit="10" thumb="false"]
  ```

  Open post link in new tab
  ```
  [rpwe link_target="true"]
  ```

  Disable default style
  ```
  [rpwe styles_default="false"]
  ```
</details>

<details>
  <summary>Full shortcode arguments</summary>

  ```
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
  ```
</details>

<details> 
  <summary>How to filter the post query?</summary>
  
  You can use `rpwe_default_query_arguments` to filter it. Example:
  ```php
  add_filter( 'rpwe_default_query_arguments', 'your_custom_function' );
  function your_custom_function( $args ) {
      $args['posts_per_page'] = 10; // Changing the number of posts to show.
      return $args;
  }
  ```
</details>

## Changelog

<details>
  <summary>2.0.2</summary>
  
  *Release Date: Oct 05, 2022*

  **Bug fixes:**

  - Prevent double slash when loading the php file.
  - Use `display: block` for the list, `inline-block` causing issue for some websites.

  **Enhancements:**

  - Minor issue with the auto generate thumbnail function.
  - Fix translation issue. Thanks [Alex Lion](https://github.com/alexclassroom).
  - CSS tweak.
</details>

<details>
  <summary>2.0.1</summary>
  
  *Release Date: Sept 28, 2022*

  **Bug fixes:**

  - Compatibility issue with Siteorigin Page Builder.

  **Enhancements:**

  - Re-enable custom CSS setting.
  - Full support Siteorigin Page Builder.
  - Adds `display: inline-block;` to the default style, to make sure each list align properly. Thank you [outrospective](https://wordpress.org/support/users/outrospective/)!
</details>

<details>
  <summary>2.0 - Major Changes</summary>

  *Release Date: Sept 23, 2022*

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
</details>
