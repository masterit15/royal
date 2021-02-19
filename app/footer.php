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
<?php wp_footer(); ?>

</body>
</html>
