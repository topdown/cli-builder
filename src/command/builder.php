<?php

/**
 *
 * PHP version 7.
 *
 * Created: 2019-04-18, 10:43
 *
 * LICENSE: MIT
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2019 ValidWebs.com
 * @package        mormvc - builder.php
 * @license
 * @version        1.0.2
 * cli-builder
 * builder.php
 */

namespace cli_builder\command;

/**
 * Basic tooling methods for building commands.
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2019 ValidWebs.com
 *
 * Class builder
 * @package        cli_builder\command
 */
final class builder {

	// fwrite( STDOUT, "Version: $this->version \n" );
	// fwrite( STDERR, "[ ERROR ]: Specify version with --version= \n" );

	/**
	 * Create fules on the fly.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-04-18, 11:02
	 *
	 * @param      $file_path_name
	 * @param bool $overwrite
	 */
	public function create_file( $file_path_name, $overwrite = false ) {

		if ( ! file_exists( $file_path_name ) || $overwrite === true ) {
			touch( $file_path_name );
			fwrite( STDOUT, "Created file $file_path_name \n\n" );
		}
	}

	/**
	 * Write to file that makes sure we have a file in the path first.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-04-18, 14:05
	 *
	 * @param      $file_path_name
	 * @param      $content
	 * @param bool $overwrite
	 */
	public function write_file( $file_path_name, $content, $overwrite = false ) {
		if ( ! file_exists( $file_path_name ) || $overwrite === true ) {
			$this->create_file( $file_path_name );
		}

		file_put_contents( $file_path_name, $content );
	}

	/**
	 * Copy a files content's to a new file and path.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-05-20, 12:28
	 *
	 * @param $file_to_copy
	 * @param $new_file_path
	 */
	public function copy_file( $file_to_copy, $new_file_path ) {

		if ( file_exists( $file_to_copy ) ) {
			$content = file_get_contents( $file_to_copy );
		} else {
			die( "$file_to_copy does not exist." );
		}

		if ( ! file_exists( $new_file_path ) ) {
			$this->create_file( $new_file_path );
		}

		file_put_contents( $new_file_path, $content );
	}

	/**
	 * Recursivly create a directory tree.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-04-18, 11:02
	 *
	 * @param $path
	 */
	public function create_directory( $path ) {

		if ( ! is_dir( $path ) ) {
			shell_exec( "mkdir -p $path" );
			fwrite( STDOUT, "Created directory $path \n" );
		}

		// Add an index file.
		$this->create_file( $path . '/' . 'index.php' );
	}

	//	/**
	//	 * Help docs.
	//	 *
	//	 * @author         Jeff Behnke <jeff@validwebs.com>
	//	 * @copyright  (c) 2018 Validwebs.com
	//	 *
	//	 * Created:    9/21/18, 1:22 PM
	//	 *
	//	 */
	//	public function help() {
	//		echo '
	//Usage: php cli.php [command] [options] [-f] <file> [--] [args...]
	//   php cli.php find -h
	//   php cli.php debug "Is used as a appended command and outputs all args."
	//   php cli.php mod OR module -h
	//   php cli.php convert -h
	//';
	//	}

	/**
	 * Function to make titles in some spots singular, like buttons.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009-18 Validwebs.com
	 *
	 * Created:    9/21/18, 1:22 PM
	 *
	 * @param $str
	 *
	 * @return bool|string
	 */
	public function singular( $str ) {
		if ( substr( $str, - 1 ) == 's' ) {
			$str = substr( $str, 0, - 1 );
		}

		return $str;
	}

	/**
	 * Make a human name with upper case words.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009-18 Validwebs.com
	 *
	 * Created:    1/24/18, 11:51 AM
	 *
	 * @param $name
	 *
	 * @return string
	 */
	public function singular_name( $name ) {
		return ucwords( str_replace( array( '_', '-' ), ' ', singular( $name ) ) );
	}

}

// End builder.php
