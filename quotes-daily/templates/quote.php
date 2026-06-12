<?php
/**
 * @var string $quote
 * @var string $author
 * @var string $image
 * @var bool $showAuthor
 * @var bool $showImage
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}
?>

<style rel="stylesheet">
	.smz-wp-quotes blockquote {
		overflow: hidden;
	}

	.smz-wp-quotes img {
		float: left;
		margin-right: 1rem;
		margin-bottom: 1rem;
	}
</style>

<div class="smz-wp-quotes">
	<blockquote>
		<?php if ( $showImage ): ?>
			<img src="<?php echo esc_html( $image ); ?>" alt="<?php echo esc_html( $author ); ?>" />
		<?php endif; ?>
		<p>
			<?php echo esc_html( $quote ); ?>
		</p>
		<?php if ( $showAuthor ): ?>
			<small><?php echo esc_html( $author ); ?></small>
		<?php endif; ?>
	</blockquote>
</div>
