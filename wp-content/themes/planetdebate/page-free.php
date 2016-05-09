
  <div id="archive-page-category-boxes" class="category-boxes container oswald">
      <div class="row">
        <div class="col-md-3 text-center"><span class="cateogry-box-link-span"><a class="<?php echo (($parent_id == 3944) ? "cateogry-box-link active" : "cateogry-box-link"); ?>" data-category="policy" href="<?php echo get_bloginfo(url) ?>/product-category/2015-2016-surveillance-topic/">Policy</a></span></div>
        <div class="col-md-3 text-center"><span class="cateogry-box-link-span"><a class="<?php echo (($parent_id == 4721) ? "cateogry-box-link active" : "cateogry-box-link"); ?>" href="<?php echo get_bloginfo(url) ?>/product-category/l-d-2016-17/">Lincoln-Douglas</a></span></div>
        <div class="col-md-3 text-center"><span class="cateogry-box-link-span"><a class="<?php echo (($parent_id == 4427) ? "cateogry-box-link active" : "cateogry-box-link"); ?>" href="<?php echo get_bloginfo(url) ?>/product-category/2014-15-public-forum/">Public Forum</a></span></div>
        <div class="col-md-3 text-center"><span class="cateogry-box-link-span"><a class="<?php echo (($parent_id == 6887) ? "cateogry-box-link active" : "cateogry-box-link"); ?>" href="<?php echo get_bloginfo(url) ?>/free">Free Files</a></span></div>
      </div>
  </div>

<?php
	$args = array( 'post_type' => 'product','posts_per_page' => 10, 'orderby' =>'SKU','order' => 'DESC','meta_query' => array(
		array(
			'key' => '_regular_price',
			'value' => 0
		)),
	'paged'=>get_query_var( 'paged', 1 ),
	);
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ){ $loop->the_post(); global $product; woocommerce_get_template_part( 'content', 'product'); }
?>