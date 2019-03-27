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
	 * @var command_interface
	 */
	private $command;

	/**
	 * in the invoker we find this kind of method for subscribing the command
	 * There can be also a stack, a list, a fixed set ...
	 *
	 * @param command_interface $cmd
	 */
	public function set_command( command_interface $cmd ) {
		$this->command = $cmd;
	}

	/**
	 * executes the command; the invoker is the same whatever is the command
	 */
	public function run() {
		$this->command->execute();
	}
}
