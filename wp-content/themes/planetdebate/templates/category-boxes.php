<?php global $parent_id;
	if (is_front_page()): ?>
	<div id="front-page-category-boxes" class="category-boxes container oswald">
			<div class="row">
			  <div class="col-md-3 text-center"><span class="cateogry-box-link-span"><a class="front-page-link" data-category="policy" href="<?php echo get_bloginfo('url'); ?>/product-category/policy-china/">Policy</a></span></div>
			  <div class="col-md-3 text-center"><span class="cateogry-box-link-span"><a href="<?php echo get_bloginfo('url'); ?>/product-category/l-d-2016-17/">Lincoln-Douglas</a></span></div>
			  <div class="col-md-3 text-center"><span class="cateogry-box-link-span"><a href="<?php echo get_bloginfo('url'); ?>/product-category/product-category/2016-7-files/">Public Forum</a></span></div>
			  <div class="col-md-3 text-center"><span class="cateogry-box-link-span"><a href="<?php echo get_bloginfo('url') ?>/free">Free Files</a></span></div>
			</div>
	</div>

<?php else: ?>
  <div id="archive-page-category-boxes" class="category-boxes container oswald">
      <div class="row">
        <div class="col-md-3 text-center"><span class="cateogry-box-link-span"><a class="<?php echo (($parent_id == 3944) ? "cateogry-box-link active" : "cateogry-box-link"); ?>" data-category="policy" href="<?php echo get_bloginfo('url') ?>product-category/policy-china/">Policy</a></span></div>
        <div class="col-md-3 text-center"><span class="cateogry-box-link-span"><a class="<?php echo (($parent_id == 4721) ? "cateogry-box-link active" : "cateogry-box-link"); ?>" href="<?php echo get_bloginfo('url') ?>/product-category/l-d-2016-17/">Lincoln-Douglas</a></span></div>
        <div class="col-md-3 text-center"><span class="cateogry-box-link-span"><a class="<?php echo (($parent_id == 4427) ? "cateogry-box-link active" : "cateogry-box-link"); ?>" href="<?php echo get_bloginfo('url') ?>/product-category/2016-7-files/">Public Forum</a></span></div>
        <div class="col-md-3 text-center"><span class="cateogry-box-link-span"><a class="<?php echo (is_page('free') ? "cateogry-box-link active" : "cateogry-box-link"); ?>" href="<?php echo get_bloginfo('url') ?>/free">Free Files</a></span></div>
      </div>
  </div>

  <?php endif; ?>