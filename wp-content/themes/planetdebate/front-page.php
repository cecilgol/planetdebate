<div id="homepage-jumbotron" class="jumbotron oswald">
	<div class="container">
		<h1 id="welcome" class="text-center">Welcome back to the planet</h1>
		<div class="row">
			<p class="text-center grey arial">Planet Debate houses the world's largest collection of scholastic debate evidence</p>
		</div>
		<div class="row">
		  <div class="col-md-3 text-center"><span class="number">3,367</span><br /><span class="small grey arial">free files</span></div>
		  <div class="col-md-1 text-center"><span class="front-page-plus">+</span></div>

		  <div class="col-md-4 text-center"><span class="number">86,827</span><br /><span class="small grey arial">card database</span></div>
		  <div class="col-md-1 text-center"><span class="front-page-plus">+</span></div>
		  <div class="col-md-3 text-center"><span class="number">2,519</span><br /><span class="small grey arial">files for sale</span></div>
		</div>
	</div>

</div>
<?php get_template_part('templates/category-boxes'); ?>

    <div class="wrap container" role="document">
      <div class="content">
        <main class="main">
				<?php
					$args = array( 'post_type' => 'product', 'stock' => 1, 'posts_per_page' => 10, 'orderby' =>'menu_order','order' => 'ASC' );
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ){ $loop->the_post(); global $product; woocommerce_get_template_part( 'content', 'product'); }
/*

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
								<span class="i-heart-this"  id="<?php echo the_id(); ?>"></span>
								<?php woocommerce_template_loop_add_to_cart( $loop->post, $product );?>
								<span class="price oswald"><?php echo $product->get_price_html(); ?></span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="product-card-bottom">
							<div class="metadata pull-left">
								<span class="pages"> 46</span>
								<span class="hearts"> <?php echo get_post_hearts(get_the_id()); ?></span>
								<span class="downloads"> <?php echo get_post_downloads(get_the_id()); ?></span>
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
*/?>				<?php wp_reset_query(); ?>

				<!-- OTHER CONTENTS -->
				<?php while (have_posts()) : the_post(); ?>
				  <?php get_template_part('templates/page', 'header'); ?>
				  <?php get_template_part('templates/content', 'page'); ?>
				<?php endwhile; ?>

			</main><!-- /.main -->
      </div><!-- /.content -->
    </div><!-- /.wrap -->




