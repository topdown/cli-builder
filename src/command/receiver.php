<?php

namespace cli_builder\command;

/**
 * receiver is specific service with its own contract and can be only concrete.
 */
class receiver {

	/**
	 * @property bool $enable_date
	 */
	private $_enable_date = false;

	/**
	 * @property array $output
	 */
	private $_output = [];

	/**
	 * @property string $build_path
	 */
	public $build_path = 'build';

	/**
	 * Set custom build path on the fly via your base CLI fine.
	 * If not $build_path is set build/ will be created.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-04-18, 12:27
	 *
	 * @param $build_path
	 */
	public function set_build_path( $build_path = '' ) {
		$this->build_path = $build_path;
	}

	/**
	 * Write out a string/strings once the command has completed.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-04-18, 11:04
	 *
	 * @param string $str
	 */
	public function write( string $str ) {
		if ( $this->_enable_date ) {
			$str .= ' [' . date( 'm-d-Y h:m:s' ) . ']';
		}

		$this->_output[] = $str;
	}

	/**
	 * Allows us to build a log of what happened while the command ran.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-04-18, 13:39
	 *
	 * @param string      $str
	 * @param string|null $custom_log_path
	 */
	public function log( string $str, string $custom_log_path = null ) {

		$time = '[' . date( 'm-d-Y h:m:s' ) . ']';

		$log = "$time $str\n";

		if ( ! is_null( $custom_log_path ) ) {
			file_put_contents( $custom_log_path, $log, FILE_APPEND );
		} else {
			file_put_contents( 'logs/cli.log', $log, FILE_APPEND );
		}
	}

	/**
	 * Get the entire output.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-04-18, 11:03
	 *
	 * @return string
	 */
	public function get_output(): string {
		return join( "\n", $this->_output );
	}


	/**
	 * Enable receiver to display message date.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-04-18, 11:04
	 *
	 */
	public function enable_date() {
		$this->_enable_date = true;
	}

	/**
	 * Disable receiver to display message date.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-04-18, 11:04
	 *
	 */
	public function disable_date() {
		$this->_enable_date = false;
	}
}
