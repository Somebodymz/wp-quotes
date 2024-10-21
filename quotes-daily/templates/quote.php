<?php
/**
 * @var string $quote
 * @var string $author
 * @var bool $showAuthor
 */
?>

<div class="quotes-daily qd-daily">
	<blockquote><?= esc_html( $quote ); ?></blockquote>
	<?php if ( $showAuthor ): ?>
		<small><?= esc_html( $author ); ?></small>
	<?php endif; ?>
</div>
