<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
];


foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

$user_favorite_files = get_user_meta(wp_get_current_user()->ID,'favorite_files',true);

function get_post_hearts($post_id){
  return get_post_meta($post_id,'_hearts',true);
}

function get_post_downloads($post_id){
  return get_post_meta($post_id,'_downloads',true);
}

add_filter('woocommerce_product_add_to_cart_text', 'PD_Add_cart_button_text');    // 2.1 +
function PD_Add_cart_button_text() {
        $html='<span class="add-to-cart"></span>';
        return __( $html , 'woocommerce' );
}

add_filter('bundle_add_to_cart_text', 'PD_bundle_add_to_cart_text');
function PD_bundle_add_to_cart_text(){
        $html='<span class="add-to-cart"></span>';
        return __( $html , 'woocommerce' );
}

add_filter('woocommerce_archive_description','PD_topic_category_list');

function PD_topic_category_list(  ){
    $parent_cat = get_queried_object();
    $cat_id = $parent_cat->parent;
    $dog_id = end(get_ancestors($parent_cat->term_id,'product_cat'));
    $dog = get_term($dog_id,'product_cat');

    $rents = get_ancestors($parent_cat->term_id,'product_cat');

    $parent_args = array(
      'parent'      => $dog_id,
      'depth'       => '1',
      'hierarchical'=> true,
      'orderby'     => 'Name',
      'order'       => 'DESC',
      'taxonomy'    => 'product_cat',
      'title_li'    => ''
      );

    $categories = get_categories( $parent_args );

    if (count($rents) > 1){
      $x = get_term($parent_cat->parent,'product_cat');
      $scaid = $x->id;
    } else {
      $scaid = $parent_cat->term_id;
    }

    $subcategory_args = array(
      'parent'      => $scaid,
      'depth'       => 2,
      'hierarchical'=> true,
      'orderby'     => 'Name',
      'order'       => 'ASC',
      'taxonomy'    => 'product_cat',
      'title_li'    => ''
      );

    $subcategories = get_categories( $subcategory_args );
    $col_value = round(count($subcategories) / 12);
    $col_total = count($subcategories);
    $col_array = ["zero","one","two","three","four","five","six","seven","eight","nine","ten","eleven","twelve"];

/**
 * BEGIN HTML
 */?>
  <div class="topic-area">
    <div class="topic-dropdown dropdown row text-center">
      <button class="btn btn-default dropdown-toggle oswald" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php if ( $parent_cat->taxonomy == 'product_cat') {
          if ($dog->slug == 'policy') {
            echo preg_filter('/^[\d\-]+[\s]/', '', $parent_cat->name );
          } else {
            echo($parent_cat->name);
          }
          ?>
        <i class="fa fa-chevron-circle-down grey" aria-hidden="true"></i>
      </button>
      <ul class="dropdown-menu topic-dropdown-menu text-left" aria-labelledby="dropdownMenu2">
        <?php
          foreach ($categories as $category) {
          if ($dog->slug == 'policy') {
            $name = preg_filter('/^[\d\-]+[\s]/', '', $category->name );
            } else {
            $name = $category->name;
            }
          $html = '<li class="text-left cat-item cat-item-' . $category->term_id . '"><a href="' . get_bloginfo('url') . '/product-category/' . $category->slug . '">' . $name . '</a></li>';
          echo $html;
          }
        ?>
      </ul>
      <?php
         } else {
         echo $parent_cat->name;
         ?></button><?php
       }?>
      </div>
      <div class="topic-subcategories container">


      <?php
      if ($col_total % 2 != 0){
        echo '<div class="'. $col_array[$col_total] .'-cols">';
      }else{
        echo '<div>';
      }

      foreach ($subcategories as $category) {
/**
 * BEGIN HTML
 */?>
        <div class="col-md-<?php echo $col_value ?> scl-container" style="cursor:pointer;">
          <a class="subcategory-link" id="<?php echo $category->term_id ?>">
          <div class="tsc-circle"><?php echo $category->name[0] ?> </div>
          <?php echo $category->name; ?>
          </a>
        </div>
<?php
/**
 * END HTML
 */}
        ?>
        </div>
      </div>
    </div>
  </div>
<?php
/**
 * END HTML
 */
}

add_action('wp_ajax_pd_subcategory_link_clicked', 'pd_subcategory_link_clicked' );
add_action('wp_ajax_nopriv_pd_subcategory_link_clicked', 'pd_subcategory_link_clicked' );
function pd_subcategory_link_clicked(){
  global $product, $woocommerce, $woocommerce_loop;

  $sclid = json_decode( stripslashes( $_POST['sclid'] ), true );

  $args = array(
    'post_type' => 'product',
    'tax_query' => array(
      array(
        'taxonomy' => 'product_cat',
        'terms'    => $sclid,
        ),
      ),
    );
  $posts = new WP_Query( $args );
  while ( $posts->have_posts() ) {
    $posts->the_post();

    woocommerce_get_template_part( 'content', 'product');
  }

}

add_filter('woocommerce_before_main_content','PD_type_category_list');
function PD_type_category_list( ){

    global $parent_id;
    $page_cat   = get_queried_object();
    $parent_id  = $page_cat->parent;

 /**
 * BEGIN HTML
 */?>

  <?php get_template_part('templates/category-boxes'); ?>


<?php
/**
 * END HTML

remove_action('woocommerce_before_shop_loop_item','woocommerce_before_shop_loop_item',10);
add_action('woocommerce_before_shop_loop_item', 'PD_before_shop_loop_item');
remove_action('woocommerce_before_shop_loop_item_title','woocommerce_before_shop_loop_item_title');
remove_action( 'woocommerce_shop_loop_item_title','woocommerce_before_shop_loop_item' );
do_action( 'woocommerce_after_shop_loop_item_title' );
do_action( 'woocommerce_after_shop_loop_item' );

function PD_before_shop_loop_item(){
?>
          <!-- FONTAWESOME REQUIRES SPACES IN THE HTML, NOT CSS -->
          <div class="product-card">
            <div class="product-card-top">
              <div class="product-title pull-left">
                <a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <h3 class="oswald"><?php the_title(); ?></h3>
                </a>
                <div class="product-date"><?php the_time('F j, Y') ?></div>
              </div>
              <div class="product-utilities pull-right">
                <span class="i-heart-this"  id="<?php the_id(); ?>"></span>
                <?php woocommerce_template_loop_add_to_cart();?>
                <span class="price oswald"><?php woocommerce_template_single_price(); ?></span>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="product-card-bottom">
              <div class="metadata pull-left">
                <span class="pages"> 46</span>
                <span class="hearts"> <?php get_post_hearts(the_id()); ?></span>
                <span class="downloads"> 197</span>
              </div>
              <div class="categories pull-right">
                <?php
                 $terms = wp_get_post_terms( $product->id, 'product_tag');
                    foreach($terms as $term) {
                      echo '<a href="/product-tag/'. $term->slug .'" class="category btn btn-default btn-square btn-xs" role="button">'.$term->name.'</a>';
                    }
                ?>

              </div>
            </div>
          </div>


        }


<?php MOVE THIS LINE UP LATER  */ }

// THIS IS ALL SUBSCRIBER JUNK
if ( get_user_meta( wp_get_current_user()->ID )['subscriptions'][0] == 'everything'){
  add_filter('woocommerce_loop_add_to_cart_link','pd_subscriber_add_to_cart',1,1);
  add_action('wp_ajax_pd_subscriber_download', 'pd_subscriber_ajax_callback' );
  add_action( 'woocommerce_email', 'unhook_those_pesky_emails' );

}


function pd_subscriber_add_to_cart(){
  global $product;

  $all_meta_for_user = get_user_meta( wp_get_current_user()->ID );
    $downloads = $product->get_files();

    foreach( $downloads as $key => $each_download ) {
//      WC_AJAX::grant_access_to_download($each_download[$key],$product->id);
      echo '<a class="btn btn-default subscriber-download-button" id="'.$key.'" data-product-id="'.$product->id.'" data-link="'.$each_download["file"].'"><i class="fa fa-download" aria-hidden="true"></i></a>';
    }
}

function pd_subscriber_ajax_callback(){
  $download_id = $_POST['dlid'];
  $product_id = $_POST['dlpk'];
  global $wpdb;

  $wpdb->hide_errors();




  $order = wc_create_order(array(
        'status'        => '',
        'customer_id'   => wp_get_current_user()->ID,
        'customer_note' => null,
        'order_id'      => 0,
        'created_via'   => '',
        'parent'        => 0));

  $order->update_status('wc-processing');
  wc_downloadable_file_permission( $download_id, $product_id, $order, $qty = 1 );

  echo "Download file from Your Account";
  die();
}


function unhook_those_pesky_emails( $email_class ) {

    /**
     * Hooks for sending emails during store events
     **/
    remove_action( 'woocommerce_low_stock_notification', array( $email_class, 'low_stock' ) );
    remove_action( 'woocommerce_no_stock_notification', array( $email_class, 'no_stock' ) );
    remove_action( 'woocommerce_product_on_backorder_notification', array( $email_class, 'backorder' ) );

    // New order emails
    remove_action( 'woocommerce_order_status_pending_to_processing_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_pending_to_completed_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_failed_to_processing_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_failed_to_completed_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_failed_to_on-hold_notification', array( $email_class->emails['WC_Email_New_Order'], 'trigger' ) );

    // Processing order emails
    remove_action( 'woocommerce_order_status_pending_to_processing_notification', array( $email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger' ) );
    remove_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger' ) );

    // Completed order emails
    remove_action( 'woocommerce_order_status_completed_notification', array( $email_class->emails['WC_Email_Customer_Completed_Order'], 'trigger' ) );

    // Note emails
    remove_action( 'woocommerce_new_customer_note_notification', array( $email_class->emails['WC_Email_Customer_Note'], 'trigger' ) );
}

add_action('wp_ajax_pd_add_or_remove_hearts', 'pd_add_or_remove_hearts');
add_action('wp_ajax_nopriv_pd_add_or_remove_hearts','pd_add_or_remove_hearts');

function pd_add_or_remove_hearts(){
  //sends a post id, we need to get the user_id here
  $post_id = $_POST['pid'];
  $action = $_POST['a'];
  $user_id = wp_get_current_user()->ID;
  $post_hearts = get_post_meta($post_id,'_hearts',true);
  if ($user_id != null) {

    $a = get_user_meta($user_id,'favorite_files',true);

    if(!is_array($a)){
      $aval = $a;
      $a = array($aval);
    }

    switch ($action) {
      case 'a':
        $new_hearts_count = absint($post_hearts) + 1;
        $a[]= $post_id;
        update_user_meta(absint($user_id), 'favorite_files', $a);
        break;
      case 'd':
        $new_hearts_count = absint($post_hearts) - 1;
        delete_user_meta(absint($user_id), 'favorite_files', $a);
        break;
      default:
        $new_hearts_count = absint($post_hearts);
        break;
    }
    update_post_meta(absint($post_id), '_hearts', $new_hearts_count);
    $r = array(
      'hearts' => (string)$new_hearts_count
      );
  } else {
    $r = array(
      'html' => 'You must login to add favorite files.'
      );
  }
  echo json_encode($r);
  die();
}

add_filter('woocommerce_show_page_title','__return_false');
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );


function woocommerce_result_count(){
  return;
}

/*
 * Adding the column
 */
function rd_user_id_column( $columns ) {
  $columns['user_id'] = 'ID';
  return $columns;
}
add_filter('manage_users_columns', 'rd_user_id_column');

/*
 * Column content
 */
function rd_user_id_column_content($value, $column_name, $user_id) {
  if ( 'user_id' == $column_name )
    return $user_id;
  return $value;
}
add_action('manage_users_custom_column',  'rd_user_id_column_content', 10, 3);

/*
 * Column style (you can skip this if you want)
 */
function rd_user_id_column_style(){
  echo '<style>.column-user_id{width: 5%}</style>';
}
add_action('admin_head-users.php',  'rd_user_id_column_style');



add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

add_action('wp_ajax_pd_infinite_scroll', 'pd_infinite_scroll');
add_action('wp_ajax_nopriv_pd_infinite_scroll','pd_infinite_scroll');

function pd_infinite_scroll(){
  global $wordpress, $wpdb, $woocommerce, $woocommerce_loop;

  $p = $_POST['p'];
  $html_to_return = '';
  $args = array( 'post_type' => 'product','posts_per_page' => 10, 'orderby' =>'SKU','order' => 'DESC','meta_query' => array(
    array(
      'key' => '_regular_price',
      'value' => 0
    )),
  'paged'=>$p,
  );
  $loop = new WP_Query( $args );

  while ( $loop->have_posts() ){ $loop->the_post(); global $product; $html_to_return .= woocommerce_get_template_part( 'content', 'product'); }

  die();
}

add_action('wp_ajax_pd_contact_us_submit','pd_contact_us_submit');
add_action('wp_ajax_nopriv_pd_contact_us_submit','pd_contact_us_submit');
function pd_contact_us_submit(){

  $admin_email = 'thorassic5@gmail.com';
  $email = $_POST['e'];
  $name = $_POST['n'];
  $message = $_POST['m'];
  $rr = $_POST['rr'];

  $subject = 'PLANET DEBATE CONTACT FORM - NEW MESSAGE';

  $from="From: $name<$email>\r\nReturn-path: $email";


  if ($rr == 'true'){
    $subject .= ": RESPONSE REQUESTED";
    mail($admin_email, $subject, $message, $from);
  } else {
    mail($admin_email, $subject, $message, $from);
  }


  die();
}


