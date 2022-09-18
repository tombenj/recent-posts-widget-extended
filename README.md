# Recent Posts Widget Extended

A WordPress plugin to enable a custom, flexible and advanced recent posts, you can display it via shortcode or widget. Allows you to display a list of the most recent posts with thumbnail, excerpt and post date, also you can display it from all or specific or multiple taxonomy, post type and much more!

> If you are enjoying this plugin. I would appreciate a cup of coffee to help me keep coding and supporting the project! [Support & Donate Now](https://www.buymeacoffee.com/gasatrya)

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

## Frequently Asked Questions

<details> 
  <summary>How to filter the post query?</summary>
  
  You can use `rpwe_default_query_arguments` to filter it. Example:
  `
  add_filter( 'rpwe_default_query_arguments', 'your_custom_function' );
  function your_custom_function( $args ) {
    $args['posts_per_page'] = 10; // Changing the number of posts to show.
    return $args;
  }
  `
</details>
