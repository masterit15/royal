<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package RoyalPrint
 */

?>
</div>
<!-- end wrapper -->
	<footer class="footer">
		<div class="footer_items">
			<?php dynamic_sidebar( 'footer' ); ?>
			<div class="footer_item widget_text">
			<h3 class="footer_item_title">Мы в социальныхых сетях:</h3>
				<div class="ofer_soc">
				<?
					wp_nav_menu( [
						'theme_location'  => 'socmenu',
						'menu'            => '', 
						'container'       => '', 
						'container_class' => '', 
						'container_id'    => '',
						'menu_class'      => 'socicon', 
						'menu_id'         => '',
						'echo'            => true,
						'fallback_cb'     => 'wp_page_menu',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 0,
						'walker'          => '',
					] );
					?>
					</div>
				</div>
		</div>
		<div class="cophyright"><?=get_theme_mod('copyright')?></div>
	</footer>
	<div id="toTop">
		<i class="fas fa-rocket"></i>
		<span class="stars">
			<span class="star star-1"></span>
			<span class="star star-2"></span>
			<span class="star star-3"></span>
			<span class="star star-4"></span>
		</span>
	</div>
<?php wp_footer(); ?>

</body>
</html>
