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
 * @package        cli-builder - gen.php
 * @license        https://raw.githubusercontent.com/topdown/cli-builder/master/LICENSE
 * @version        0.0.1
 * cli-builder
 * gen.php
 */

// Only command line
if ( php_sapi_name() === 'cli' ) {

	if ( is_array( $argv ) && sizeof( $argv ) ) {
		array_shift( $argv );
	}

	$commands = array();

	foreach ( $argv as $arg ) {
		$command = explode( '=', $arg );

		if ( isset( $command[0] ) && isset( $command[1] ) ) {
			$commands[ $command[0] ] = $command[1];
		}
	}
	//print_r( $commands );

	$command_name = '';
	$namespace    = '';

	if ( isset( $commands['command'] ) ) {
		$command_name = $commands['command'];
	}

	if ( isset( $commands['namespace'] ) ) {
		$namespace = $commands['namespace'];
	}

	if ( ! empty( $command_name ) ) {

		if ( file_exists( 'commands/' . $command_name . '.php' ) ) {
			die( "Command ({$command_name}) already exists in commands!\n" );
		}

		$generate = new generate( $command_name, $namespace );

		if ( $generate->status() !== false ) {

			echo "\nYour new command ({$command_name}) was saved in commands/{$command_name}.php\n\n";
		} else {
			die( "Something went wrong. \nMake sure the commands/ directory exists and has write permissions.\n" );
		}
	} else {
		//		echo "To generate a command you must enter a command name with no spaces.\n";
		//		echo "Example\n";
		//		echo "php gen.php command=testing namespace=foo_bar\n";
	}

} else {
	die( 'This is a command line tool only.' );
}

/**
 * Generates a standard command class.
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2019 ValidWebs.com
 *
 * Class gen_command
 */
class generate {

	/**
	 * @property  $_command_name
	 */
	private $_command_name;

	/**
	 * @property string $_namespace
	 */
	private $_namespace = '';

	/**
	 * @property bool $_status
	 */
	private $_status = false;

	/**
	 * gen_command constructor.
	 *
	 * @param        $command_name
	 * @param string $namespace
	 */
	public function __construct( $command_name, $namespace = '' ) {
		$this->_command_name = $command_name;
		$this->_namespace    = $namespace;

		$this->save( $this->_command_name, $this->template() );
	}

	/**
	 * Returns the status of generating.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-03-27, 16:11
	 *
	 * @return bool
	 */
	public function status() {
		return $this->_status;
	}

	/**
	 * The template for the command we are building.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-03-27, 16:08
	 *
	 * @return string
	 */
	protected function template() {

		$template = "<?php 

/**
 *
 * PHP version 7.
 *
 * Generated with cli-builder gen.php
 *
 * Created: " . date( 'm-d-Y' ) . "
 *
 *
 * @author     Your Name <email>
 * @copyright  (c) " . date( 'Y' ) . "
 * @package    $this->_namespace - {$this->_command_name}.php
 * @license
 * @version    0.0.1
 *
 */

";
		if ( ! empty( $this->_namespace ) ) {
			$template .= "namespace cli_builder\\commands\\$this->_namespace;";
		} else {
			$template .= "namespace cli_builder\\commands;";
		}

		$template .= "

use cli_builder\\cli;
use cli_builder\\command\\builder;
use cli_builder\\command\\command_interface;
use cli_builder\\command\\receiver;

/**
 * This concrete command calls \"print\" on the receiver, but an external.
 * invoker just knows that it can call \"execute\"
 */
class {$this->_command_name} implements command_interface {

	/**
	 * @property receiver \$_command
	 */
	private \$_command;

	/**
	 * @property builder \$_builder
	 */
	private \$_builder;
	
	/**
	 * @property cli \$_cli 
	 */
	private \$_cli;
	
	/**
	 * Each concrete command is built with different receivers.
	 * There can be one, many or completely no receivers, but there can be other commands in the parameters.
	 *
	 * @param receiver \$console
	 * @param builder  \$builder
	 * @param cli      \$cli
	 */
	public function __construct( receiver \$console, builder \$builder, cli \$cli ) {
		\$this->_command = \$console;
		\$this->_builder = \$builder;
		\$this->_cli     = \$cli;
	}


	/**
	 * Execute and output \"$this->_command_name\".
	 *
	 * @return mixed|void
	 */
	public function execute() {
	
		// Get the args that were used in the command line input.
		\$args = \$this->_cli->get_args();
	
		// Create the build directory tree. It will be 'build/' if \$receiver->set_build_path() is not set in your root cli.php.
		if ( ! is_dir( \$this->_command->build_path ) ) {
			\$this->_builder->create_directory( \$this->_command->build_path );
		}

		\$this->_cli->pretty_dump( \$args );

		
		// Will output all content sent to the write method at the end even if it was set in the beginning.
		\$this->_command->write( __CLASS__ . ' completed run.' );

		// Adding completion of the command run to the log.
		\$this->_command->log(__CLASS__ . ' completed run.');
	}
}
";

		return $template;
	}

	/**
	 * Save the command file.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-03-27, 16:08
	 *
	 * @param $file_name
	 * @param $data
	 *
	 * @return bool|int
	 */
	protected function save( $file_name, $data ) {

		if ( ! dir( 'commands' ) ) {
			die( 'Please create the directory commands' );
		} else {
			// We need to add directory creation.
			if ( ! empty( $this->_namespace ) ) {
				$this->_status = file_put_contents( "commands/{$file_name}.php", $data );
			} else {
				$this->_status = file_put_contents( "commands/{$file_name}.php", $data );
			}

		}

		return $this->_status;
	}
}




// End gen.php
