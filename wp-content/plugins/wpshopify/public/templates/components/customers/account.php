<?php

get_header('wpshopify');

?>

<section class="wpshopify-page-wrapper wps-container">

   <div class="wpshopify-component-account">
      <?php 

      the_title( '<h1 class="entry-title">', '</h1>' ); ?>

      <a href="<?= wp_logout_url('/login'); ?>">Logout</a>

      <div id="component-customers-account" data-user-id="<?= get_current_user_id(); ?>"></div>

   </div>

</section>

   <?php 

get_footer('wpshopify');