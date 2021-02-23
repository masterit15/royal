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
		</div>
		<div class="cophyright">RoyalPrint © 2020. Все права защищены </div>
	</footer>
	<div id="toTop">
		<i class="fa fa-rocket"></i>
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
