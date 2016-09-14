<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product, $woocommerce_loop, $user_favorite_files;

$file_heart_class = "";
if (is_array($user_favorite_files)){
	$file_heart_class = (in_array($product->id, $user_favorite_files) ? "favorite" : "");
}
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}
?>

	<div class="product-card" id="<?php echo $product->id ?>">
		<div class="product-card-top">
			<div class="product-title pull-left">
				<h3 class="brand-primary oswald"><?php the_title(); ?></h3>
				<div class="product-date"><?php the_time('F j, Y') ?>
					<button id="<?php echo $product->id ?>" class="description-sh-btn btn btn-default btn-xs" style="border:none;">+</button>
				</div>
			</div>
			<div class="product-utilities pull-right">
				<span class="i-heart-this <?php echo $file_heart_class ?>"></span>
				<?php woocommerce_template_loop_add_to_cart( $product );?><span> </span>
				<span class="price oswald"><?php echo $product->get_price_html(); ?></span>
			</div>
			<div id="<?php echo $product->id ?>-description" class="product-description col-xs-10" style="display:none;">
				<small><?php the_content() ?></small>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="product-card-bottom">
			<div class="metadata pull-left">
				<span class="pages"> 46</span>
				<span class="hearts"> <?php echo get_post_meta($product->id,'_hearts',true);  ?></span>
				<span class="downloads"> <?php echo get_post_meta($product->id,'_downloads',true); ?></span>
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

	<?php
	/** MOVE THIS <==========================================================================================================================================================================================================================================
<li <?php post_class( $classes ); ?>>

<==============================================================================      DOWN HERE
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	// do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	// do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	// do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	// do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	UP HERE FROM BELOW <==========================================================================================================================================================================================================================================


	// do_action( 'woocommerce_after_shop_loop_item' );
	?>

</li>	 MOVE THIS ====================================================================================================================================================================================================> */
