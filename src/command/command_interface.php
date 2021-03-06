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
 * @package        cli-builder - command_interface.php
 * @license        https://raw.githubusercontent.com/topdown/cli-builder/master/LICENSE
 * @version        0.0.1
 */

namespace cli_builder\command;

/**
 * Interface command_interface
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2019 ValidWebs.com
 *
 * @package        cli_builder\command
 */
interface command_interface {

	/**
	 * This is the most important method in the Command pattern,
	 * The receiver goes in the constructor.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-04-18, 11:32
	 *
	 * @return mixed
	 */
	public function execute();

	/**
	 * Every commend is required to define help output to explain the command.
	 *
	 * @return mixed
	 * @copyright  (c) 2009 - 2021 ValidWebs.com
	 *
	 * Created:     3/26/21, 7:24 AM
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 */
	public function help();
}
