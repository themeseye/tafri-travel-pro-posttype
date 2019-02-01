<?php 
/*
 Plugin Name: Tafri Travel Pro Posttype
 lugin URI: https://www.themeseye.com/
 Description: Creating new post type for Tafri Travel Pro Theme.
 Author: Themeseye
 Version: 1.0
 Author URI: https://www.themeseye.com/
*/

define( 'TAFRI_TRAVEL_PRO_POSTTYPE_VERSION', '1.0' );

add_action( 'init', 'tafri_travel_pro_posttype_create_post_type' );
add_action( 'init', 'tourcategory');

function tafri_travel_pro_posttype_create_post_type() {

  register_post_type( 'populartour',
    array(
      'labels' => array(
        'name' => __( 'Popular tour','tafri-travel-pro-posttype' ),
        'singular_name' => __( 'Popular tour','tafri-travel-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-location',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );
  register_post_type( 'offers',
    array(
      'labels' => array(
        'name' => __( 'Special Offers','tafri-travel-pro-posttype' ),
        'singular_name' => __( 'Special Offers','tafri-travel-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-palmtree',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );  
  register_post_type( 'deals',
    array(
      'labels' => array(
        'name' => __( 'Hot Deals','tafri-travel-pro-posttype' ),
        'singular_name' => __( 'Hot Deals','tafri-travel-pro-posttype' )
      ),
        'capability_type' => 'post',
        'menu_icon'  => 'dashicons-format-gallery',
        'public' => true,
        'supports' => array( 
          'title',
          'editor',
          'thumbnail'
      )
    )
  );
  register_post_type( 'testimonials',
    array(
      'labels' => array(
        'name' => __( 'Testimonials','tafri-travel-pro-posttype' ),
        'singular_name' => __( 'Testimonials','tafri-travel-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-businessman',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );
  register_post_type( 'team',
    array(
      'labels' => array(
        'name' => __( 'Team','tafri-travel-pro-posttype' ),
        'singular_name' => __( 'Team','tafri-travel-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-businessman',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );
}
/*--------------------------Tour Category-----------------------------*/
function tourcategory() {
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name'              => __( 'Tour Category', 'tafri-travel-pro-posttype' ),
    'singular_name'     => __( 'Tour Category', 'tafri-travel-pro-posttype' ),
    'search_items'      => __( 'Search cats', 'tafri-travel-pro-posttype' ),
    'all_items'         => __( 'All Categories', 'tafri-travel-pro-posttype' ),
    'parent_item'       => __( 'Parent Categories', 'tafri-travel-pro-posttype' ),
    'parent_item_colon' => __( 'Parent Categories:', 'tafri-travel-pro-posttype' ),
    'edit_item'         => __( 'Edit Categories', 'tafri-travel-pro-posttype' ),
    'update_item'       => __( 'Update Categories', 'tafri-travel-pro-posttype' ),
    'add_new_item'      => __( 'Add New Categories', 'tafri-travel-pro-posttype' ),
    'new_item_name'     => __( 'New Categories Name', 'tafri-travel-pro-posttype' ),
    'menu_name'         => __( 'Tour Category', 'tafri-travel-pro-posttype' ),
  );
  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'tour-category' ),
  );
  register_taxonomy( 'tourcategory', array( 'populartour' ), $args );
}

// Adding an image upload option in custom Taxonomy
if( ! class_exists( 'Showcase_Taxonomy_Images' ) ) {
  class Showcase_Taxonomy_Images {
    
    public function __construct() {
     //
    }

    /**
     * Initialize the class and start calling our hooks and filters
     */
     public function init() {
     // Image actions
     add_action( 'tourcategory_add_form_fields', array( $this, 'add_category_image' ), 10, 2 );
     add_action( 'created_tourcategory', array( $this, 'save_category_image' ), 10, 2 );
     add_action( 'tourcategory_edit_form_fields', array( $this, 'update_category_image' ), 10, 2 );
     add_action( 'edited_tourcategory', array( $this, 'updated_category_image' ), 10, 2 );
     add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
     add_action( 'admin_footer', array( $this, 'add_script' ) );
   }

   public function load_media() {
     if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'tourcategory' ) {
       return;
     }
     wp_enqueue_media();
   }
  
   /**
    * Add a form field in the new category page
    * @since 1.0.0
    */
  
   public function add_category_image( $taxonomy ) { ?>
     <div class="form-field term-group">
       <label for="showcase-taxonomy-image-id"><?php _e( 'Image', 'showcase' ); ?></label>
       <input type="hidden" id="showcase-taxonomy-image-id" name="showcase-taxonomy-image-id" class="custom_media_url" value="">
       <div id="category-image-wrapper"></div>
       <p>
         <input type="button" class="button button-secondary showcase_tax_media_button" id="showcase_tax_media_button" name="showcase_tax_media_button" value="<?php _e( 'Add Image', 'showcase' ); ?>" />
         <input type="button" class="button button-secondary showcase_tax_media_remove" id="showcase_tax_media_remove" name="showcase_tax_media_remove" value="<?php _e( 'Remove Image', 'showcase' ); ?>" />
       </p>
     </div>
   <?php }

   /**
    * Save the form field
    * @since 1.0.0
    */
   public function save_category_image( $term_id, $tt_id ) {
     if( isset( $_POST['showcase-taxonomy-image-id'] ) && '' !== $_POST['showcase-taxonomy-image-id'] ){
       add_term_meta( $term_id, 'showcase-taxonomy-image-id', absint( $_POST['showcase-taxonomy-image-id'] ), true );
     }
    }

    /**
     * Edit the form field
     * @since 1.0.0
     */
    public function update_category_image( $term, $taxonomy ) { ?>
      <tr class="form-field term-group-wrap">
        <th scope="row">
          <label for="showcase-taxonomy-image-id"><?php _e( 'Image', 'showcase' ); ?></label>
        </th>
        <td>
          <?php $image_id = get_term_meta( $term->term_id, 'showcase-taxonomy-image-id', true ); ?>
          <input type="hidden" id="showcase-taxonomy-image-id" name="showcase-taxonomy-image-id" value="<?php echo esc_attr( $image_id ); ?>">
          <div id="category-image-wrapper">
            <?php if( $image_id ) { ?>
              <?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
            <?php } ?>
          </div>
          <p>
            <input type="button" class="button button-secondary showcase_tax_media_button" id="showcase_tax_media_button" name="showcase_tax_media_button" value="<?php _e( 'Add Image', 'showcase' ); ?>" />
            <input type="button" class="button button-secondary showcase_tax_media_remove" id="showcase_tax_media_remove" name="showcase_tax_media_remove" value="<?php _e( 'Remove Image', 'showcase' ); ?>" />
          </p>
        </td>
      </tr>
   <?php }

   /**
    * Update the form field value
    * @since 1.0.0
    */
   public function updated_category_image( $term_id, $tt_id ) {
     if( isset( $_POST['showcase-taxonomy-image-id'] ) && '' !== $_POST['showcase-taxonomy-image-id'] ){
       update_term_meta( $term_id, 'showcase-taxonomy-image-id', absint( $_POST['showcase-taxonomy-image-id'] ) );
     } else {
       update_term_meta( $term_id, 'showcase-taxonomy-image-id', '' );
     }
   }
 
   /**
    * Enqueue styles and scripts
    * @since 1.0.0
    */
   public function add_script() {
     if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'tourcategory' ) {
       return;
     } ?>
     <script> jQuery(document).ready( function($) {
       _wpMediaViewsL10n.insertIntoPost = '<?php _e( "Insert", "showcase" ); ?>';
       function ct_media_upload(button_class) {
         var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
         $('body').on('click', button_class, function(e) {
           var button_id = '#'+$(this).attr('id');
           var send_attachment_bkp = wp.media.editor.send.attachment;
           var button = $(button_id);
           _custom_media = true;
           wp.media.editor.send.attachment = function(props, attachment){
             if( _custom_media ) {
               $('#showcase-taxonomy-image-id').val(attachment.id);
               $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $( '#category-image-wrapper .custom_media_image' ).attr( 'src',attachment.url ).css( 'display','block' );
             } else {
               return _orig_send_attachment.apply( button_id, [props, attachment] );
             }
           }
           wp.media.editor.open(button); return false;
         });
       }
       ct_media_upload('.showcase_tax_media_button.button');
       $('body').on('click','.showcase_tax_media_remove',function(){
         $('#showcase-taxonomy-image-id').val('');
         $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
       });
       // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
       $(document).ajaxComplete(function(event, xhr, settings) {
         var queryStringArr = settings.data.split('&');
         if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
           var xml = xhr.responseXML;
           $response = $(xml).find('term_id').text();
           if($response!=""){
             // Clear the thumb image
             $('#category-image-wrapper').html('');
           }
          }
        });
      });
    </script>
   <?php }
  }
$Showcase_Taxonomy_Images = new Showcase_Taxonomy_Images();
$Showcase_Taxonomy_Images->init(); }

// Testimonial section
function testimonial_posttype_images_metabox_enqueue($hook) {
  if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
    wp_enqueue_script('testimonial-posttype-images-metabox', plugin_dir_url( __FILE__ ) . '/js/img-metabox.js', array('jquery', 'jquery-ui-sortable'));

    global $post;
    if ( $post ) {
      wp_enqueue_media( array(
          'post' => $post->ID,
        )
      );
    }

  }
}
add_action('admin_enqueue_scripts', 'testimonial_posttype_images_metabox_enqueue');

// Testimonial Meta
function coaching_posttype_bn_custom_meta_services() {

    add_meta_box( 'bn_meta', __( 'Testimonial Meta', 'testimonial-posttype-pro' ), 'testimonial_posttype_bn_meta_callback_services', 'testimonials', 'normal', 'high' );
}
/* Hook things in for admin*/
if (is_admin()){
  add_action('admin_menu', 'coaching_posttype_bn_custom_meta_services');
}
function testimonial_posttype_bn_meta_callback_services( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'bn_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );
    $meta_image = get_post_meta( $post->ID, 'meta-image', true );
    ?>
  <div id="property_stuff">
    <table id="list-table">     
      <tbody id="the-list" data-wp-lists="list:meta">
        <tr id="meta-1">
          <p>
            <label for="meta-image"><?php echo esc_html('Icon Image'); ?></label><br>
            <input type="text" name="meta-image" id="meta-image" class="meta-image regular-text" value="<?php echo esc_attr($meta_image); ?>">
            <input type="button" class="button image-upload" value="Browse">
          </p>
          <div class="image-preview"><img src="<?php echo $bn_stored_meta['meta-image'][0]; ?>" style="max-width: 250px;"></div>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
}

function testimonial_posttype_bn_meta_save_services( $post_id ) {

  if (!isset($_POST['bn_nonce']) || !wp_verify_nonce($_POST['bn_nonce'], basename(__FILE__))) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  // Save Image
  if( isset( $_POST[ 'meta-image' ] ) ) {
      update_post_meta( $post_id, 'meta-image', esc_url_raw($_POST[ 'meta-image' ]) );
  }
 
}
add_action( 'save_post', 'testimonial_posttype_bn_meta_save_services' );
/*--------------- Popular Tours section ----------------*/
/* Adds a meta box to the populartour editing screen */
function tafri_travel_pro_posttype_bn_populartour_meta_box() {
  add_meta_box( 'tafri-travel-pro-posttype-populartour-meta', __( 'Enter Details', 'tafri-travel-pro-posttype' ), 'tafri_travel_pro_posttype_bn_populartour_meta_callback', 'populartour', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'tafri_travel_pro_posttype_bn_populartour_meta_box');
}
/* Adds a meta box for custom post */
function tafri_travel_pro_posttype_bn_populartour_meta_callback( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'tafri_travel_pro_posttype_posttype_populartour_meta_nonce' );
  $bn_stored_meta = get_post_meta( $post->ID );
  $package = get_post_meta( $post->ID, 'populartour_package', true );
  $days = get_post_meta( $post->ID, 'populartour_days', true );
  $starate = get_post_meta( $post->ID, 'meta-rating', true );
  $itinerary = get_post_meta( $post->ID, 'meta-itinerary', true );
  $main = get_post_meta( $post->ID, 'populartour_main', true );
  $disc = get_post_meta( $post->ID, 'populartour_disc', true );
  ?>
  <div id="populartours_custom_stuff">
    <table id="list">
      <tbody id="the-list" data-wp-lists="list:meta">
        <tr id="meta-1">
          <td class="left">
            <?php _e( 'Package', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="populartour_package" id="populartour_package" value="<?php echo esc_attr( $package ); ?>" />
          </td>
        </tr>
        <tr id="meta-2">
          <td class="left">
            <?php _e( 'Days', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="populartour_days" id="populartour_days" value="<?php echo esc_attr( $days ); ?>" />
          </td>
        </tr>
        <tr id="meta-3">
          <td class="left">
            <?php _e( 'Star Rating', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="meta-rating" id="meta-rating" value="<?php echo esc_attr( $starate ); ?>" />
          </td>
        </tr>
        <tr id="meta-4">
          <td class="left">
            <?php _e( 'Itinerary', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="meta-itinerary" id="meta-itinerary" value="<?php echo esc_attr( $itinerary ); ?>" />
          </td>
        </tr>
        <tr id="meta-5">
          <td class="left">
            <?php _e( 'Main Attraction', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="populartour_main" id="populartour_main" value="<?php echo esc_attr( $main ); ?>" />
          </td>
        </tr>
        <tr id="meta-6">
          <td class="left">
            <?php _e( 'Discount Price', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="populartour_disc" id="populartour_disc" value="<?php echo esc_attr( $disc ); ?>" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
}

/* Saves the custom meta input */
function tafri_travel_pro_posttype_bn_metadesigp_save( $post_id ) {
  if (!isset($_POST['tafri_travel_pro_posttype_posttype_populartour_meta_nonce']) || !wp_verify_nonce($_POST['tafri_travel_pro_posttype_posttype_populartour_meta_nonce'], basename(__FILE__))) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  // Save desig.
  if( isset( $_POST[ 'populartour_package' ] ) ) {
    update_post_meta( $post_id, 'populartour_package', sanitize_text_field($_POST[ 'populartour_package']) );
  }
  if( isset( $_POST[ 'populartour_days' ] ) ) {
    update_post_meta( $post_id, 'populartour_days', sanitize_text_field($_POST[ 'populartour_days']) );
  }
  if( isset( $_POST[ 'meta-rating' ] ) ) {
    update_post_meta( $post_id, 'meta-rating', sanitize_text_field($_POST[ 'meta-rating']) );
  }
  if( isset( $_POST[ 'meta-itinerary' ] ) ) {
    update_post_meta( $post_id, 'meta-itinerary', sanitize_text_field($_POST[ 'meta-itinerary']) );
  }
  if( isset( $_POST[ 'populartour_main' ] ) ) {
    update_post_meta( $post_id, 'populartour_main', sanitize_text_field($_POST[ 'populartour_main']) );
  }
  if( isset( $_POST[ 'populartour_disc' ] ) ) {
    update_post_meta( $post_id, 'populartour_disc', sanitize_text_field($_POST[ 'populartour_disc']) );
  }
}

add_action( 'save_post', 'tafri_travel_pro_posttype_bn_metadesigp_save' );

/*--------------------- Last Minute Offer ----------------------*/

//Last Minute Offer Meta
function tafri_travel_pro_posttype_bn_custom_meta_offers() {

  add_meta_box( 'tafri-travel-pro-posttype-offer-meta', __( 'Enter Details', 'tafri-travel-pro-posttype-posttype' ), 'tafri_travel_pro_posttype_bn_meta_callback_offers', 'offers', 'normal', 'high' );
}
/* Hook things in for admin*/
if (is_admin()){
  add_action('admin_menu', 'tafri_travel_pro_posttype_bn_custom_meta_offers');
}

function tafri_travel_pro_posttype_bn_meta_callback_offers( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'bn_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );
    $package = get_post_meta( $post->ID, 'offer_package', true );
    $days = get_post_meta( $post->ID, 'offer_days', true );
    $starate = get_post_meta( $post->ID, 'star_rating', true );
    $itinerary = get_post_meta( $post->ID, 'offer_itinerary', true );
    $main = get_post_meta( $post->ID, 'offer_main', true );
    $disc = get_post_meta( $post->ID, 'offer_disc', true );
    ?>
  <div id="property_stuff">
    <table id="list-table">     
      <tbody id="the-list" data-wp-lists="list:meta">
        <tr id="meta-1">
          <td class="left">
            <?php _e( 'Package', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="offer_package" id="offer_package" value="<?php echo esc_attr( $package ); ?>" />
          </td>
        </tr>
        <tr id="meta-2">
          <td class="left">
            <?php _e( 'Days', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="offer_days" id="offer_days" value="<?php echo esc_attr( $days ); ?>" />
          </td>
        </tr>
        <tr id="meta-3">
          <td class="left">
            <?php _e( 'Star Rating', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="star_rating" id="star_rating" value="<?php echo esc_attr( $starate ); ?>" />
          </td>
        </tr>
        <tr id="meta-4">
          <td class="left">
            <?php _e( 'Itinerary', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="offer_itinerary" id="offer_itinerary" value="<?php echo esc_attr( $itinerary ); ?>" />
          </td>
        </tr>
        <tr id="meta-5">
          <td class="left">
            <?php _e( 'Main Attraction', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="offer_main" id="offer_main" value="<?php echo esc_attr( $main ); ?>" />
          </td>
        </tr>
        <tr id="meta-6">
          <td class="left">
            <?php _e( 'Discount Price', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="offer_disc" id="offer_disc" value="<?php echo esc_attr( $disc ); ?>" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
}

function tafri_travel_pro_posttype_bn_meta_save_offers( $post_id ) {

  if (!isset($_POST['bn_nonce']) || !wp_verify_nonce($_POST['bn_nonce'], basename(__FILE__))) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  // Save Meta
  if( isset( $_POST[ 'offer_package' ] ) ) {
    update_post_meta( $post_id, 'offer_package', sanitize_text_field($_POST[ 'offer_package']) );
  }
  if( isset( $_POST[ 'offer_days' ] ) ) {
    update_post_meta( $post_id, 'offer_days', sanitize_text_field($_POST[ 'offer_days']) );
  }
  if( isset( $_POST[ 'star_rating' ] ) ) {
    update_post_meta( $post_id, 'star_rating', sanitize_text_field($_POST[ 'star_rating']) );
  }
  if( isset( $_POST[ 'offer_itinerary' ] ) ) {
    update_post_meta( $post_id, 'offer_itinerary', sanitize_text_field($_POST[ 'offer_itinerary']) );
  }
  if( isset( $_POST[ 'offer_main' ] ) ) {
    update_post_meta( $post_id, 'offer_main', sanitize_text_field($_POST[ 'offer_main']) );
  }
  if( isset( $_POST[ 'offer_disc' ] ) ) {
    update_post_meta( $post_id, 'offer_disc', sanitize_text_field($_POST[ 'offer_disc']) );
  }
}
add_action( 'save_post', 'tafri_travel_pro_posttype_bn_meta_save_offers' );

/*----------------------Testimonial section ----------------------*/
/* Adds a meta box to the Testimonial editing screen */
function tafri_travel_pro_posttype_bn_testimonial_meta_box() {
	add_meta_box( 'tafri-travel-pro-posttype-testimonial-meta', __( 'Enter Details', 'tafri-travel-pro-posttype' ), 'tafri_travel_pro_posttype_bn_testimonial_meta_callback', 'testimonials', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'tafri_travel_pro_posttype_bn_testimonial_meta_box');
}
/* Adds a meta box for custom post */
function tafri_travel_pro_posttype_bn_testimonial_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'tafri_travel_pro_posttype_posttype_testimonial_meta_nonce' );
  $bn_stored_meta = get_post_meta( $post->ID );
	$desigstory = get_post_meta( $post->ID, 'tafri_travel_pro_posttype_testimonial_desigstory', true );
	?>
	<div id="testimonials_custom_stuff">
		<table id="list">
			<tbody id="the-list" data-wp-lists="list:meta">
				<tr id="meta-1">
					<td class="left">
						<?php _e( 'Designation', 'tafri-travel-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="text" name="tafri_travel_pro_posttype_testimonial_desigstory" id="tafri_travel_pro_posttype_testimonial_desigstory" value="<?php echo esc_attr( $desigstory ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
}

/* Saves the custom meta input */
function tafri_travel_pro_posttype_bn_metadesig_save( $post_id ) {
	if (!isset($_POST['tafri_travel_pro_posttype_posttype_testimonial_meta_nonce']) || !wp_verify_nonce($_POST['tafri_travel_pro_posttype_posttype_testimonial_meta_nonce'], basename(__FILE__))) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Save desig.
	if( isset( $_POST[ 'tafri_travel_pro_posttype_testimonial_desigstory' ] ) ) {
		update_post_meta( $post_id, 'tafri_travel_pro_posttype_testimonial_desigstory', sanitize_text_field($_POST[ 'tafri_travel_pro_posttype_testimonial_desigstory']) );
	}
}

add_action( 'save_post', 'tafri_travel_pro_posttype_bn_metadesig_save' );

/*------------------------- Hot Deals Section -----------------------------*/
/* Adds a meta box for Designation */
function tafri_travel_pro_posttype_bn_deals_meta() {
    add_meta_box( 'tafri_travel_pro_posttype_bn_meta', __( 'Enter Details','tafri-travel-pro-posttype' ), 'tafri_travel_pro_posttype_ex_bn_meta_callback', 'deals', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'tafri_travel_pro_posttype_bn_deals_meta');
}
/* Adds a meta box for custom post */
function tafri_travel_pro_posttype_ex_bn_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'tafri_travel_pro_posttype_bn_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );
    $package = get_post_meta( $post->ID, 'place_package', true );
    $days = get_post_meta( $post->ID, 'deals_days', true );
    $starate = get_post_meta( $post->ID, 'deals_rating', true );
    $itinerary = get_post_meta( $post->ID, 'place_itinerary', true );
    $main = get_post_meta( $post->ID, 'place_main', true );
    $disc = get_post_meta( $post->ID, 'place_disc', true );
    ?>
    <div id="property_stuff">
    <table id="list-table">     
      <tbody id="the-list" data-wp-lists="list:meta">
        <tr id="meta-1">
          <td class="left">
            <?php _e( 'Package', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="place_package" id="place_package" value="<?php echo esc_attr( $package ); ?>" />
          </td>
        </tr>
        <tr id="meta-2">
          <td class="left">
            <?php _e( 'Days', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="deals_days" id="deals_days" value="<?php echo esc_attr( $days ); ?>" />
          </td>
        </tr>
        <tr id="meta-3">
          <td class="left">
            <?php _e( 'Star Rating', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="deals_rating" id="deals_rating" value="<?php echo esc_attr( $starate ); ?>" />
          </td>
        </tr>
        <tr id="meta-4">
          <td class="left">
            <?php _e( 'Itinerary', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="place_itinerary" id="place_itinerary" value="<?php echo esc_attr( $itinerary ); ?>" />
          </td>
        </tr>
        <tr id="meta-5">
          <td class="left">
            <?php _e( 'Main Attraction', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="place_main" id="place_main" value="<?php echo esc_attr( $main ); ?>" />
          </td>
        </tr>
        <tr id="meta-6">
          <td class="left">
            <?php _e( 'Discount Price', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="place_disc" id="place_disc" value="<?php echo esc_attr( $disc ); ?>" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
}
/* Saves the custom Designation meta input */
function tafri_travel_pro_posttype_ex_bn_metadesig_save( $post_id ) {
    if( isset( $_POST[ 'place_package' ] ) ) {
        update_post_meta( $post_id, 'place_package', sanitize_text_field($_POST[ 'place_package' ]) );
    }
    if( isset( $_POST[ 'deals_days' ] ) ) {
        update_post_meta( $post_id, 'deals_days',sanitize_text_field($_POST[ 'deals_days' ]) );
    }
    
    if( isset( $_POST[ 'place_itinerary' ] ) ) {
        update_post_meta( $post_id, 'place_itinerary', sanitize_text_field($_POST[ 'place_itinerary' ]) );
    }
   
    if( isset( $_POST[ 'deals_rating' ] ) ) {
        update_post_meta( $post_id, 'deals_rating', sanitize_text_field($_POST[ 'deals_rating' ]) );
    }
    if( isset( $_POST[ 'place_main' ] ) ) {
        update_post_meta( $post_id, 'place_main', sanitize_text_field($_POST[ 'place_main' ]) );
    }
    if( isset( $_POST[ 'place_disc' ] ) ) {
        update_post_meta( $post_id, 'place_disc', sanitize_text_field($_POST[ 'place_disc' ]) );
    }
}
add_action( 'save_post', 'tafri_travel_pro_posttype_ex_bn_metadesig_save' );

add_action( 'save_post', 'bn_meta_save' );
/* Saves the custom meta input */
function bn_meta_save( $post_id ) {
  if( isset( $_POST[ 'tafri_travel_pro_posttype_deals_featured' ] )) {
      update_post_meta( $post_id, 'tafri_travel_pro_posttype_deals_featured', esc_attr(1));
  }else{
    update_post_meta( $post_id, 'tafri_travel_pro_posttype_deals_featured', esc_attr(0));
  }
}

// Team Meta
function team_posttype_bn_custom_meta_services() {

    add_meta_box( 'bn_meta', __( 'Team Meta', 'team-posttype-pro' ), 'team_posttype_bn_meta_callback_services', 'team', 'normal', 'high' );
}
/* Hook things in for admin*/
if (is_admin()){
  add_action('admin_menu', 'team_posttype_bn_custom_meta_services');
}
function team_posttype_bn_meta_callback_services( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'bn_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );
    ?>
  <div id="property_stuff">
    <table id="list-table">     
      <tbody id="the-list" data-wp-lists="list:meta">
        <tr id="meta-1">
          <p>
            <label for="meta-image"><?php echo esc_html('Icon Image'); ?></label><br>
            <input type="text" name="meta-image" id="meta-image" class="meta-image regular-text" value="<?php echo $bn_stored_meta['meta-image'][0]; ?>">
            <input type="button" class="button image-upload" value="Browse">
          </p>
          <div class="image-preview"><img src="<?php echo $bn_stored_meta['meta-image'][0]; ?>" style="max-width: 250px;"></div>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
}

function team_posttype_bn_meta_save_services( $post_id ) {

  if (!isset($_POST['bn_nonce']) || !wp_verify_nonce($_POST['bn_nonce'], basename(__FILE__))) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  // Save Image
  if( isset( $_POST[ 'meta-image' ] ) ) {
      update_post_meta( $post_id, 'meta-image', esc_url_raw($_POST[ 'meta-image' ]) );
  }
 
}
add_action( 'save_post', 'team_posttype_bn_meta_save_services' );
/*----------------------Team section ----------------------*/
/* Adds a meta box to the Team editing screen */
function tafri_travel_pro_posttype_bn_team_meta_box() {
  add_meta_box( 'tafri-travel-pro-posttype-team-meta', __( 'Enter Details', 'tafri-travel-pro-posttype' ), 'tafri_travel_pro_posttype_bn_team_meta_callback', 'team', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'tafri_travel_pro_posttype_bn_team_meta_box');
}
/* Adds a meta box for custom post */
function tafri_travel_pro_posttype_bn_team_meta_callback( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'tafri_travel_pro_posttype_posttype_team_meta_nonce' );
  $bn_stored_meta = get_post_meta( $post->ID );
  $desigstory = get_post_meta( $post->ID, 'tafri_travel_pro_posttype_team_desigstory', true );
  $phoneno = get_post_meta( $post->ID, 'phone_no', true );
  $emailaddress = get_post_meta( $post->ID, 'email_address', true );
  $pricetime = get_post_meta( $post->ID, 'price_time', true );
  ?>
  <div id="testimonials_custom_stuff">
    <table id="list">
      <tbody id="the-list" data-wp-lists="list:meta">
        <tr id="meta-1">
          <td class="left">
            <?php _e( 'Designation', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="tafri_travel_pro_posttype_team_desigstory" id="tafri_travel_pro_posttype_team_desigstory" value="<?php echo esc_attr( $desigstory ); ?>" />
          </td>
        </tr>
        <tr id="meta-2">
          <td class="left">
            <?php _e( 'Phone', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="phone_no" id="phone_no" value="<?php echo esc_attr( $phoneno ); ?>" />
          </td>
        </tr>
         <tr id="meta-2">
          <td class="left">
            <?php _e( 'Email', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="email_address" id="email_address" value="<?php echo esc_attr( $emailaddress ); ?>" />
          </td>
        </tr>
        <tr id="meta-2">
          <td class="left">
            <?php _e( 'Price', 'tafri-travel-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="text" name="price_time" id="price_time" value="<?php echo esc_attr( $pricetime ); ?>" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
}

/* Saves the custom meta input */
function tafri_travel_pro_posttype_bn_metadesig_team_save( $post_id ) {
  if (!isset($_POST['tafri_travel_pro_posttype_posttype_team_meta_nonce']) || !wp_verify_nonce($_POST['tafri_travel_pro_posttype_posttype_team_meta_nonce'], basename(__FILE__))) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  // Save desig.
  if( isset( $_POST[ 'tafri_travel_pro_posttype_team_desigstory' ] ) ) {
    update_post_meta( $post_id, 'tafri_travel_pro_posttype_team_desigstory', sanitize_text_field($_POST[ 'tafri_travel_pro_posttype_team_desigstory']) );
  }
  // Save phone no
  if( isset( $_POST[ 'phone_no' ] ) ) {
    update_post_meta( $post_id, 'phone_no', sanitize_text_field($_POST[ 'phone_no']) );
  }
  // Save email
  if( isset( $_POST[ 'email_address' ] ) ) {
    update_post_meta( $post_id, 'email_address', sanitize_text_field($_POST[ 'email_address']) );
  }
   // Save phone
  if( isset( $_POST[ 'price_time' ] ) ) {
    update_post_meta( $post_id, 'price_time', sanitize_text_field($_POST[ 'price_time']) );
  }
}

add_action( 'save_post', 'tafri_travel_pro_posttype_bn_metadesig_team_save' );
/*------------------------Hot Deals Shortcode --------------------------*/
function tafri_travel_pro_posttype_deals_func( $atts ) {
    $deals = ''; 
    $deals = '<div id="deals" class="row pb-3">';
      $new = new WP_Query( array( 'post_type' => 'deals') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = tafri_travel_pro_string_limit_words(get_the_excerpt(),20);
          $days = get_post_meta($post_id,'deals_days',true);
          $itinerary = get_post_meta($post_id,'place_itinerary',true);
          $package = get_post_meta($post_id,'place_package',true);
          $starate = get_post_meta($post_id,'deals_rating',true);
          $deals .= '<div class="col-lg-6 col-sm-12 col-md-12 mt-4">';        
                if (has_post_thumbnail()){
                  $deals .= '<div class="row deals-img">
                    <div class="col-md-4 col-lg-5 pr-lg-0 pr-sm-0 col-sm-5 img-deals col-12">
                    <img class=" eplace w-100" src="'.esc_url($url).'" >
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 border-deal">
                    <h4 class="deals-title m-0"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
                    <div class="deals-packgage">'.esc_html($days).'</div>
                    <div class="deals-iternary">'.esc_html($itinerary).'</div>
                    <span class="dels-package">'.esc_html($package).'</span>
                    <span>'.esc_html($starate).'</span>
                    <span class="deals-icons">
                      <i class="fa fa-globe"></i>
                      <i class="fa fa-road"></i>
                      <i class="fa fa-plane"></i>
                      <i class="fa fa-building"></i>
                  </span>
                  <div class="deals_test">'.$excerpt.'</div>
                    </div>
                  </div>';  
                }                    
              $deals .='</div>';
            if($k%4 == 0){
            $deals.= '<div class="clearfix"></div>'; 
          } 
          $k++;         
        endwhile; 
        wp_reset_postdata();
        $deals.= '</div>';
      else :
        $deals = '<div id="deals" class="deals_wrap col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','tafri-travel-pro-posttype').'</h2></div>';
      endif;
    return $deals;
}
add_shortcode( 'tafri-travel-pro-deals', 'tafri_travel_pro_posttype_deals_func' );

/*------------------- Testimonial Shortcode -------------------------*/
function tafri_travel_pro_posttype_testimonials_func( $atts ) {
    $testimonial = ''; 
    $testimonial = '<div id="testimonials"><div class="row pb-3 inner-test-bg">';
      $new = new WP_Query( array( 'post_type' => 'testimonials') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = tafri_travel_pro_string_limit_words(get_the_excerpt(),20);
          $designation = get_post_meta($post_id,'tafri_travel_pro_posttype_testimonial_desigstory',true);
          $testicon=get_post_meta(get_the_ID(), 'meta-image', true);
          $testimonial .= '<div class="col-lg-6 col-md-6 mt-4"> 
                <div class="row m-0 shrtcod-pg">
                  <div class="test-shrtpg w-100">
                    <div class="content_box pl-3 pr-3 w-100">
                        <div class="fronts">
                          <div class="testimonial_icon">
                          <img class="text-center" src="'.esc_url($testicon).'">
                          </div>
                       </div>
                        <div class="short_test">'.$excerpt.'</div>
                    </div>
                  </div>
                  <ul class="testimonial-img-des">
                    <li class="textimonial-img">'; 
                      if (has_post_thumbnail()){
                      $testimonial.= '<img src="'.esc_url($url).'">';
                      }
                      $testimonial.= '
                    </li>  
                  <li class="des-title">
                    <h4><a href="'.get_the_permalink().'">'.get_the_title().'</a> <cite>'.esc_html($designation).'</cite></h4>
                  </li>
                  </ul>
                </div>
              </div><div class="clearfix"></div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
        $testimonial.= '</div>';
      else :
        $testimonial = '<div id="testimonial" class="testimonial_wrap col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','tafri-travel-pro-posttype').'</h2></div></div></div>';
      endif;
    return $testimonial;
}
add_shortcode( 'tafri-travel-pro-testimonials', 'tafri_travel_pro_posttype_testimonials_func' );
/*------------------- Team Shortcode -------------------------*/
function tafri_travel_pro_posttype_team_func( $atts ) {
    $team = ''; 
    $team = '<div id="team"><div class="row pb-3 inner-test-bg">';
      $new = new WP_Query( array( 'post_type' => 'team') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = tafri_travel_pro_string_limit_words(get_the_excerpt(),20);
          $designation = get_post_meta($post_id,'tafri_travel_pro_posttype_team_desigstory',true);
          $phoneno = get_post_meta($post_id,'phone_no',true);
          $emailaddress = get_post_meta($post_id,'email_address',true);
          $pricetime = get_post_meta($post_id,'price_time',true); 
          $teamicon=get_post_meta(get_the_ID(), 'meta-image', true);
          $team .= '<div class="col-lg-6 col-md-6 mt-4"> 
                <div class="row m-0 shrtcod-pg p-2">
                  <div class="test-shrtpg w-100">
                    <div class="content_box pl-3 pr-3 w-100">
                        <div class="fronts">
                          <div class="teams_icon">
                          <img class="text-center" src="'.esc_url($teamicon).'">
                          </div>
                       </div>
                    </div>
                  </div>
                  <ul class="team-img-des">
                    <li class="team-img">'; 
                      if (has_post_thumbnail()){
                      $team.= '<img src="'.esc_url($url).'">';
                      }
                      $team.= '
                    </li>  
                  <li class="des-title">
                    <h4><a href="'.get_the_permalink().'">'.get_the_title().'</a> <cite>'.esc_html($designation).'</cite></h4>
                  </li>
                  </ul>
                  <div class="team-meta-filed">
                  <span>'.esc_html($emailaddress).'</span>
                  <span>'.esc_html($phoneno).'</span>
                  <span class="price-titles">'.esc_html($pricetime).'</span>
                  </div>
                  <div class="short_team">'.$excerpt.'</div>
                </div>
              </div><div class="clearfix"></div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
        $team.= '</div>';
      else :
        $team = '<div id="team" class="team_wrap col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','tafri-travel-pro-posttype').'</h2></div></div></div>';
      endif;
    return $team;
}
add_shortcode( 'tafri-travel-pro-team', 'tafri_travel_pro_posttype_team_func' );
/*------------------- offer Shortcode -------------------------*/
function tafri_travel_pro_posttype_offer_func( $atts ) {
    $offer = ''; 
    $offer = '<div id="offer"><div class="row pb-3">';
      $new = new WP_Query( array( 'post_type' => 'offers') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = tafri_travel_pro_string_limit_words(get_the_excerpt(),20);
          $offerpackage = get_post_meta($post_id,'offer_package',true);
          $offerdays = get_post_meta($post_id,'offer_days',true);
          $main = get_post_meta($post_id,'offer_main',true);
          $disc = get_post_meta($post_id,'offer_disc',true);  
          $offerating = get_post_meta($post_id,'star_rating',true);
          $itinerary = get_post_meta($post_id,'offer_itinerary',true);
          $offer .= '<div class="col-lg-12 col-md-12 mt-4"> 
                <div class="offer-box row">
                  <div class="col-md-4 col-lg-4 col-sm-4 offers-image pr-lg-0">';
                    if (has_post_thumbnail()){
                    $offer.= '<img src="'.esc_url($url).'">';
                    }
                    $offer.= '<span class="offer-packager">'.esc_html($offerpackage).'</span> </div>
                  <div class="col-md-5 col-lg-5 col-sm-5 offers-boxs-content">
                    <h4 class="special-offer-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
                    <span class="special-offerdays">'.esc_html($offerdays).'</span>
                    <span class="special-offeritinery">'.esc_html($itinerary).'</span>
                    <span class="special-offer-rating">'.esc_html($offerating).'</span>
                    
                    <div class="short_textes pt-lg-3">'.$excerpt.'</div>
                  </div>
                    <div class="col-md-3 col-sm-3 col-lg-3 contents_box w-100">
                      <div class="offers-icon">
                      <i class="fa fa-globe"></i>
                      <i class="fa fa-road"></i>
                      <i class="fa fa-plane"></i>
                      <i class="fa fa-building"></i>
                      </div>
                      <hr class="offerhr">
                      <span class="packages-offers">'.esc_html($offerpackage).'</span>
                                 
                      <div class="iconss mt-3"> 
                        <a class="view-details-btns" href="'.get_the_permalink().'">'. __('View Details','tafri-travel-pro-posttype').'</a>
                      </div>
                     
                    </div>
                </div>
              </div><div class="clearfix"></div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
        $offer.= '</div>';
      else :
        $offer = '<div id="offer" class="col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','tafri-travel-pro-posttype').'</h2></div></div></div>';
      endif;
    return $offer;
}
add_shortcode( 'tafri-travel-pro-offer', 'tafri_travel_pro_posttype_offer_func' );

/*---------------- populartour Shortcode ---------------------*/
function tafri_travel_pro_posttype_populartour_func( $atts ) {
    $populartour = ''; 
    $populartour = '<div class="row">';
      $new = new WP_Query( array( 'post_type' => 'populartour') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = tafri_travel_pro_string_limit_words(get_the_excerpt(),20);
          $tourpackage = get_post_meta($post_id,'populartour_package',true);
          $tourdays = get_post_meta($post_id,'populartour_days',true); 
          $starate = get_post_meta($post_id,'meta-rating',true);
          
          $populartour .= '<div class="col-lg-4 col-md-6 mt-4 mb-4">'; 
                          if (has_post_thumbnail()){
          $populartour.='  <div class="populartour-image">'; 
          $populartour.= '<img class="w-100" src="'.esc_url($url).'">';}
          
          $populartour.= '</div>
                      <div class="poptour-contents">
                        <h4><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>';
          $populartour .= '<span class="tour-packages">'.esc_html($tourpackage).'</span>';
          $starate .= '<span class="tour-packages">'.esc_html($starate).'</span>';
          $populartour.= '<div class="tour-days"> 
                          <span>'.esc_html($tourdays).'</span>
                        </div>         
                        <div class="content_box w-100">
                          <div class="short_texts">'.$excerpt.'</div>
                        </div>
                        
                      </div>
              </div><div class="clearfix"></div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
        $populartour.= '</div>';
      else :
        $populartour = '<div id="populartour" class="col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','tafri-travel-pro-posttype').'</h2></div></div>';
      endif;
    return $populartour;
}
add_shortcode( 'tafri-travel-pro-populartour', 'tafri_travel_pro_posttype_populartour_func' );