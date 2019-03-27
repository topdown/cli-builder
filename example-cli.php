<?php

/**
 *
 * PHP version 7.
 *
 * Created: 2019-03-27, 13:46
 *
 * LICENSE:
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2019 ValidWebs.com
 * @package        cli-builder - example-cli.php
 * @license
 * @version
 * cli-builder
 * example-cli.php
 */

// Only command line
if ( php_sapi_name() !== 'cli' ) {
	die( 'This is a command line tool only.' );
}

include_once 'setup.php';

$cli = new \cli_builder\cli();
// Our header output. (optional)
$cli->header();

// Required to load our custom commands.
$invoker  = new Invoker();
$receiver = new Receiver();

// Your Custom commands.

// End example-cli.php