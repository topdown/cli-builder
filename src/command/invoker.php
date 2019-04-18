<?php

/**
 *
 * PHP version 7.
 *
 * Created: 2019-03-27, 15:30
 *
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2019 ValidWebs.com
 * @package        cli-builder - invoker.php
 * @license        https://raw.githubusercontent.com/topdown/cli-builder/master/LICENSE
 * @version        0.0.1
 */

namespace cli_builder\command;

/**
 * Invoker is using the command given to it.
 * Example : an Application in SF2.
 */
class invoker {

	/**
	 * @property  $_command
	 */
	private $_command;

	/**
	 * In the invoker we find this kind of method for subscribing the command.
	 * There can be also a stack, a list, a fixed set ...
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-04-18, 11:07
	 *
	 * @param command_interface $cmd
	 */
	public function set_command( command_interface $cmd ) {
		$this->_command = $cmd;
	}

	/**
	 *  Executes the command; the invoker is the same whatever is the command.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-04-18, 11:07
	 *
	 */
	public function run() {
		$this->_command->execute();
	}
}
