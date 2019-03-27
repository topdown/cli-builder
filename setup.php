<?php

/**
 * This file sets up the includes and requirements for the core system.
 *
 * PHP version 7.
 *
 * Created: 2019-03-27, 12:31
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2019 ValidWebs.com
 * @package        cli-builder - setup.php
 * @license        https://raw.githubusercontent.com/topdown/cli-builder/master/LICENSE
 * @version        0.0.1
 *
 */

$start = microtime();

ini_set( 'xdebug.var_display_max_depth', 10 );
ini_set( 'xdebug.var_display_max_children', 256 );
ini_set( 'xdebug.var_display_max_data', 1024 );
// Higher settings needed locally for running big development tasks
ini_set( 'memory_limit', '1536M' ); // 1.5 GB
ini_set( 'max_execution_time', 18000 ); // 5 hours

// PHP settings
ini_set( "log_errors", 1 );
ini_set( "error_log", __DIR__ . '/logs/error.log' );

date_default_timezone_set( 'America/Chicago' );

// Gives us a constant for the root directory for the CLI Builder.
define( 'CLIB_PATH', __DIR__ );

// Helpers - Mostly for visual decorating.
include_once "src/helpers/Console_Table.php";
include_once "src/helpers/cli_table.php";
include_once "src/helpers/cli_colors.php";

// Interfaces and Cammand package to encapsulate, invocation and decoupling of future commands.
// These are required.
include_once "src/command/command_interface.php";
include_once "src/command/undoable_command_interface.php";
include_once "src/command/receiver.php";
include_once "src/command/invoker.php";

// The instance of the CLI.
// Required to use the built in simplicity, IE output, arg handling, progress bar, etc..
include_once "src/cli.php";


// End setup.php