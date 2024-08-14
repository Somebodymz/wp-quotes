<?php
/**
 * @var string $quote
 * @var string $author
 * @var bool $showAuthor
 */
?>

<div class="quotes-for-wordpress quote-daily">
	<blockquote><?= $quote; ?></blockquote>
	<?php if ( $showAuthor ): ?>
		<small><?= $author; ?></small>
	<?php endif; ?>
</div>
