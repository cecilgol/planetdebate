<header class="banner navbar navbar-default navbar-static-top oswald" role="banner">
  <div id="primary-navbar" class="container-fluid ">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only"><?= __('Toggle navigation', 'sage'); ?></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a id="navbar-brand-text" class="navbar-brand" href="<?= esc_url(home_url('/')); ?>" alt="<?php bloginfo('name'); ?>">Planet Debate</a>
    </div>
    <nav class="collapse navbar-collapse" role="navigation">
        <ul class="nav navbar-nav">
          <li><a href="/contact-us" data-toggle='modal'><i class="fa fa-envelope"></i> Contact Us</a></li>
          <li><a href="/news"><i class="fa fa-info-circle "></i> PD News <span class="new-blog-post-count"><?php echo wp_count_posts('post')->publish; ?></span></a> </li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
      <?php if (is_user_logged_in()){ ?>
        <li><a href="/my-account"><i class="fa fa-lock"></i> <?php $user = wp_get_current_user(); echo $user->user_login; ?></a></li> <li><a href="/cart"><i class="fa fa-shopping-bag"></i> cart (<?php echo sprintf (_n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() );  ?>)</a></li>
      <?php } else { ?>
        <li><a href="/my-account"><i class="fa fa-lock"></i> login</a></li> <li><a href="/my-account"><i class="fa fa-plus-circle"></i> create account</a></li>
      <?php } ?>
        </ul>
    </nav>
  </div>
  <div class="searchbar"><?php get_search_form() ?></div>

</header>
