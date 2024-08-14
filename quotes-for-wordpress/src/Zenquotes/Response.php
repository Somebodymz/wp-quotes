<?php

namespace Smz\WpQuotes\Zenquotes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Response {

	/**
	 * Quote text.
	 *
	 * @var string
	 */
	public string $q;

	/**
	 * Author name.
	 *
	 * @var string
	 */
	public string $a;

	/**
	 * Author image (key required).
	 *
	 * @var string
	 */
	public string $i;

	/**
	 * Character count.
	 *
	 * @var string
	 */
	public string $c;

	/**
	 * Pre-formatted HTML quote.
	 *
	 * @var string
	 */
	public string $h;
}
