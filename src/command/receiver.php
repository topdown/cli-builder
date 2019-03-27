<?php

namespace cli_builder\command;

/**
 * receiver is specific service with its own contract and can be only concrete.
 */
class receiver {
	/**
	 * @var bool
	 */
	private $enable_date = false;

	/**
	 * @var string[]
	 */
	private $output = [];

	/**
	 * @param string $str
	 */
	public function write( string $str ) {
		if ( $this->enable_date ) {
			$str .= ' [' . date( 'm-d-Y h:m:s' ) . ']';
		}

		$this->output[] = $str;
	}

	public function get_output(): string {
		return join( "\n", $this->output ) . "\n";
	}

	/**
	 * Enable receiver to display message date
	 */
	public function enable_date() {
		$this->enable_date = true;
	}

	/**
	 * Disable receiver to display message date
	 */
	public function disable_date() {
		$this->enable_date = false;
	}
}
