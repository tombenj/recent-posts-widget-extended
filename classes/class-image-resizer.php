<?php
/**
 * Title         : Aqua Resizer
 * Description   : Resizes WordPress images on the fly
 * Version       : 1.2.0
 * Author        : Syamil MJ
 * Author URI    : http://aquagraphite.com
 * License       : WTFPL - http://sam.zoy.org/wtfpl/
 * Documentation : https://github.com/sy4mil/Aqua-Resizer/
 *
 * I changed the function and class name for compatibility purpose. It somtimes conflicted with a theme which uses the same library.
 *
 * @param string  $url      - (required) must be uploaded using wp media uploader
 * @param int     $width    - (required)
 * @param int     $height   - (optional)
 * @param bool    $crop     - (optional) default to soft crop
 * @param bool    $single   - (optional) returns an array if false
 * @param bool    $upscale  - (optional) resizes smaller images
 * @uses  wp_upload_dir()
 * @uses  image_resize_dimensions()
 * @uses  wp_get_image_editor()
 *
 * @return str|array
 * @package Posts Extended
 */

if ( ! class_exists( 'Image_Resizer' ) ) {

	/**
	 * Resize image on the fly.
	 */
	class Image_Resizer {
		/**
		 * The singleton instance.
		 *
		 * @var null
		 */
		private static $instance = null;

		/**
		 * No initialization allowed
		 */
		private function __construct() {
		}

		/**
		 * No cloning allowed
		 */
		private function __clone() {
		}

		/**
		 * For your custom default usage you may want to initialize an Image_Resizer object by yourself and then have own defaults
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Process the image.
		 *
		 * @param string  $url The image url.
		 * @param int     $width the image width.
		 * @param int     $height the image height.
		 * @param boolean $crop Crop the image.
		 * @param boolean $single Return image output.
		 * @param boolean $upscale Upscale the image.
		 *
		 * @return (string|array)[]
		 */
		public function process( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
			// Validate inputs.
			if ( ! $url || ( ! $width && ! $height ) ) {
				return false;
			}

			// Caipt'n, ready to hook.
			if ( true === $upscale ) {
				add_filter( 'image_resize_dimensions', array( $this, 'rpwe_upscale' ), 10, 6 );
			}

			// Define upload path & dir.
			$upload_info = wp_upload_dir();
			$upload_dir  = $upload_info['basedir'];
			$upload_url  = $upload_info['baseurl'];

			$http_prefix  = 'http://';
			$https_prefix = 'https://';

			// if the $url scheme differs from $upload_url scheme, make them match
			// if the schemes differe, images don't show up.
			if ( ! strncmp( $url, $https_prefix, strlen( $https_prefix ) ) ) { // if url begins with https:// make $upload_url begin with https:// as well.
				$upload_url = str_replace( $http_prefix, $https_prefix, $upload_url );
			} elseif ( ! strncmp( $url, $http_prefix, strlen( $http_prefix ) ) ) { // if url begins with http:// make $upload_url begin with http:// as well.
				$upload_url = str_replace( $https_prefix, $http_prefix, $upload_url );
			}

			// Check if $img_url is local.
			if ( false === strpos( $url, $upload_url ) ) {
				return false;
			}

			// Define path of image.
			$rel_path = str_replace( $upload_url, '', $url );
			$img_path = $upload_dir . $rel_path;

			// Check if img path exists, and is an image indeed.
			if ( ! file_exists( $img_path ) || ! getimagesize( $img_path ) ) {
				return false;
			}

			// Get image info.
			$info                  = pathinfo( $img_path );
			$ext                   = $info['extension'];
			list($orig_w, $orig_h) = getimagesize( $img_path );

			// Get image size after cropping.
			$dims = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );

			// Check if $dims is array.
			// https://github.com/gasatrya/recent-posts-widget-extended/issues/7.
			// Thanks to @aadilovic-tfb.
			if ( is_array( $dims ) ) {
				$dst_w = $dims[4];
				$dst_h = $dims[5];
			} else {
				$dst_w = null;
				$dst_h = null;
			}

			// Return the original image only if it exactly fits the needed measures.
			if ( ! $dims && ( ( ( null === $height && $orig_w === $width ) xor ( null === $width && $orig_h === $height ) ) xor ( $height === $orig_h && $width === $orig_w ) ) ) {
				$img_url = $url;
				$dst_w   = $orig_w;
				$dst_h   = $orig_h;
			} else {
				// Use this to check if cropped image already exists, so we can return that instead.
				$suffix       = "{$dst_w}x{$dst_h}";
				$dst_rel_path = str_replace( '.' . $ext, '', $rel_path );
				$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

				if ( ! $dims || ( true === $crop && false === $upscale && ( $dst_w < $width || $dst_h < $height ) ) ) {
					// Can't resize, so return false saying that the action to do could not be processed as planned.
					return false;

					// Else check if cache exists.
				} elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
					$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";

					// Else, we resize the image and return the new resized image url.
				} else {

					$editor = wp_get_image_editor( $img_path );

					if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) ) {
						return false;
					}

					$resized_file = $editor->save();

					if ( ! is_wp_error( $resized_file ) ) {
						$resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
						$img_url          = $upload_url . $resized_rel_path;
					} else {
						return false;
					}
				}
			}

			// Okay, leave the ship.
			if ( true === $upscale ) {
				remove_filter( 'image_resize_dimensions', array( $this, 'rpwe_upscale' ) );
			}

			// Return the output.
			if ( $single ) {
				// str return.
				$image = $img_url;
			} else {
				// array return.
				$image = array(
					0 => $img_url,
					1 => $dst_w,
					2 => $dst_h,
				);
			}

			return $image;
		}

		/**
		 * Callback to overwrite WP computing of thumbnail measures
		 *
		 * @param null|mixed $default Whether to preempt output of the resize dimensions.
		 * @param int        $orig_w Width.
		 * @param int        $orig_h Height.
		 * @param int        $dest_w New width.
		 * @param int        $dest_h New height.
		 * @param boolean    $crop Crop image.
		 *
		 * @return array
		 */
		public function rpwe_upscale( $default, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {
			if ( ! $crop ) {
				return null; // Let the WordPress default function handle this.
			}

			// Here is the point we allow to use larger image size than the original one.
			$aspect_ratio = $orig_w / $orig_h;
			$new_w        = $dest_w;
			$new_h        = $dest_h;

			if ( ! $new_w ) {
				$new_w = intval( $new_h * $aspect_ratio );
			}

			if ( ! $new_h ) {
				$new_h = intval( $new_w / $aspect_ratio );
			}

			$size_ratio = max( $new_w / $orig_w, $new_h / $orig_h );

			$crop_w = round( $new_w / $size_ratio );
			$crop_h = round( $new_h / $size_ratio );

			$s_x = floor( ( $orig_w - $crop_w ) / 2 );
			$s_y = floor( ( $orig_h - $crop_h ) / 2 );

			return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
		}
	}
}

if ( ! function_exists( 'rpwe_image_resize' ) ) {
	/**
	 * Wrapper function
	 *
	 * @param string  $url The image url.
	 * @param int     $width The image width.
	 * @param int     $height The image height.
	 * @param boolean $crop Crop image.
	 * @param boolean $single Image output.
	 * @param boolean $upscale Image upscale.
	 * @return (string|array)[]
	 */
	function rpwe_image_resize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
		$resize_image = Image_Resizer::get_instance();
		return $resize_image->process( $url, $width, $height, $crop, $single, $upscale );
	}
}
