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

}

// End command.php
