<?php

/**
 *
 * PHP version 7.
 *
 * Created: 3/24/21, 11:37 AM
 *
 * LICENSE:
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2021 ValidWebs.com
 * @package        mormvc-builder - command.php
 * @license
 * @version
 * mormvc-builder
 * command.php
 */

namespace cli_builder\command;

use cli_builder\cli;
use cli_builder\helpers\cli_table;

/**
 * This class provides the info needed to the custom commands.
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2021 ValidWebs.com
 *
 * Class command
 * @package        cli_builder\command
 */
class command {

	/**
	 * @property receiver $_command
	 */
	protected $_command;

	/**
	 * @property builder $_builder
	 */
	protected $_builder;

	/**
	 * @property cli $_cli
	 */
	protected $_cli;

	/**
	 * @var array|mixed
	 */
	protected $_args;

	/**
	 * @var array|mixed
	 */
	protected $_flags;

	/**
	 * @var array|mixed
	 */
	protected $_options;

	/**
	 * @var array|mixed
	 */
	protected $_arguments;

	/**
	 * @var array
	 */
	private $_help_lines = [];

	protected $_help_request = false;

	/**
	 * Each concrete command is built with different receivers.
	 * There can be one, many or completely no receivers, but there can be other commands in the parameters.
	 *
	 * @param receiver $console
	 * @param builder  $builder
	 * @param cli      $cli
	 */
	public function __construct( receiver $console, builder $builder, cli $cli ) {
		$this->_command = $console;
		$this->_builder = $builder;
		$this->_cli     = $cli;

		// Get the args that were used in the command line input.
		$this->_args = $this->_cli->get_args();

		$this->_flags     = ( isset( $this->_args['flags'] ) ) ? $this->_args['flags'] : array();
		$this->_arguments = ( isset( $this->_args['arguments'] ) ) ? $this->_args['arguments'] : array();
		$this->_options   = ( isset( $this->_args['options'] ) ) ? $this->_args['options'] : array();
	}

	/**
	 * Reminder to add help for the command.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2021 ValidWebs.com
	 *
	 * Created:     3/26/21, 9:28 AM
	 *
	 */
	public function help() {
		if ( empty( $this->_help_lines ) ) {
			$this->_cli->error( "Your command is missing the help info. \nPlease fill in the help method." );
		}
	}

	/**
	 * Add command help lines.
	 *
	 * @param $option
	 * @param $definition
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2021 ValidWebs.com
	 *
	 * Created:     3/26/21, 9:28 AM
	 *
	 */
	public function add_help_line( $option, $definition ) {
		$this->_help_lines[ get_called_class() ][ trim( $option ) ] = trim( $definition );
	}

	/**
	 * Output a table with all the help for the called command.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2021 ValidWebs.com
	 *
	 * Created:     3/26/21, 9:28 AM
	 *
	 */
	public function help_table() {

		$help = $this->get_help();

		if ( ! empty( $help ) && is_array( $help ) ) {

			$help_array = [];
			$i          = 0;

			foreach ( $help as $cmd => $def ) {

				$index = $i ++;

				$help_array[ $index ]['called']     = trim( $cmd );
				$help_array[ $index ]['definition'] = trim( $def );
			}

			$tbl = new cli_table();
			$tbl->set_headers(
				array(
					'Caller',
					'Definition'
				)
			);

			foreach ( $help_array as $item ) {
				$tbl->add_row(
					array(
						$item['called'],
						$item['definition']
					)
				);
			}
			// Output the table.
			echo $tbl->get_table();
		}
	}

	/**
	 * Return a help array for the called command.
	 *
	 * @return array|mixed
	 * @copyright  (c) 2009 - 2021 ValidWebs.com
	 *
	 * Created:     3/26/21, 9:29 AM
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 */
	public function get_help() {
		return ( isset( $this->_help_lines[ get_called_class() ] ) ) ? $this->_help_lines[ get_called_class() ] : array();
	}

	public function __destruct() {
		if ( empty( $this->_help_lines ) ) {
			$this->_cli->error( "Your command is missing the help info. \nPlease fill in the help method." );
		}
	}
}

// End command.php
