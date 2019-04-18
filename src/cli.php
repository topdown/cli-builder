<?php

/**
 *
 * PHP version 7.
 *
 * Created: 3/26/19, 1:06 PM
 *
 * LICENSE: https://raw.githubusercontent.com/topdown/cli-builder/master/LICENSE
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2019 ValidWebs.com
 *
 * cli.php
 */

namespace cli_builder;

use cli_builder\helpers\cli_colors;
use cli_builder\helpers\cli_table;

/**
 *
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2019 ValidWebs.com
 *
 * Class cli
 * @package        cli_builder
 */
class cli {

	/**
	 * The number of columns in the console window.
	 *
	 * @property  $cols
	 */
	private $_cols = 30;

	/**
	 * @property array $args
	 */
	protected $args = [];

	/**
	 * cli constructor.
	 *
	 * @param array $arguments
	 */
	public function __construct( $arguments = array() ) {
		// Set the command line arguments.
		$this->args = $arguments;

		// Set the current window columns.
		$this->_cols = (int) exec( "tput cols" );

		// Make sure we always have columns.
		if ( $this->_cols <= 0 ) {
			$this->_cols = 30;
		}
	}

	/**
	 * Get the command line passed arguments array.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-04-18, 16:30
	 *
	 * @return array
	 */
	public function get_args() {
		return $this->args;
	}

	/**
	 * Get the columns of the current window.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 * Created:    3/27/19, 11:26 AM
	 *
	 * @return string
	 */
	protected function get_columns() {
		return $this->_cols;
	}

	/**
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 *
	 * Created:    3/27/19, 9:06 AM
	 *
	 * @param string $custom
	 */
	public function separator( $custom = '' ) {
		if ( ! empty( $custom ) ) {
			echo str_repeat( "$custom", $this->_cols ) . "\n";
		} else {
			echo str_repeat( "-", $this->_cols ) . "\n";
		}
	}


	/**
	 * A progress bar for long running processing.
	 *
	 *<code>
	 * for($x=1;$x<=100;$x++){
	 *
	 *     show_status($x, 100);
	 *
	 *     usleep(100000);
	 *
	 * }
	 * </code>
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:    3/27/19, 9:07 AM
	 *
	 * @param        $done
	 * @param        $total
	 * @param int    $size
	 * @param string $char
	 * @param string $arrow
	 */
	public function progress_bar( $done, $total, $size = 30, $char = '█', $arrow = '' ) {

		static $start_time;

		// if we go over our bound, just ignore it
		if ( $done > $total ) {
			return;
		}

		if ( empty( $start_time ) ) {
			$start_time = time();
		}

		$now  = time();
		$perc = (double) ( $done / $total );
		$bar  = floor( $perc * $size );

		$status_bar = "\r[";
		$status_bar .= str_repeat( "$char", $bar );
		if ( $bar < $size ) {
			$status_bar .= "$arrow";
			$status_bar .= str_repeat( " ", $size - $bar );
		} else {
			$status_bar .= "$char";
		}

		$disp = number_format( $perc * 100, 0 );

		$status_bar .= "] $disp%  $done/$total";

		if ( $done > 0 ) {
			$rate = ( $now - $start_time ) / $done;
		} else {
			$rate = 0;
		}

		$left = $total - $done;
		$eta  = round( $rate * $left, 2 );

		$elapsed = $now - $start_time;

		$status_bar .= " remaining: " . number_format( $eta ) . " sec.  elapsed: " . number_format( $elapsed ) . " sec.";

		echo "$status_bar  ";

		flush();

		// when done, send a newline
		if ( $done == $total ) {
			echo "\n";
		}

	}

	/**
	 * Simple text method that adds a line break to the end.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:    3/27/19, 9:08 AM
	 *
	 * @param      $string
	 * @param bool $center
	 */
	public function text( $string, $center = false ) {

		if ( $center ) {
			$pad = ( $this->_cols - strlen( $string ) ) / 2;

			echo str_repeat( "\x20", $pad ) . "$string\n";
		} else {
			echo "$string\n";
		}
	}

	/**
	 * Create a new line.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009-19 ValidWebs.com
	 *
	 * Created:    2/8/18, 10:09 AM
	 *
	 */
	public function nl() {
		echo "\n";
	}

	/**
	 * Create a new line separator with dashes.
	 * If a string is incuded another line with be below.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009-19 ValidWebs.com
	 *
	 * Created:    2/8/18, 10:08 AM
	 *
	 * @param string $words
	 */
	public function lines( $words = '' ) {
		echo str_repeat( "-", $this->_cols ) . "\n";
		if ( ! empty( $words ) ) {
			fwrite( STDOUT, $words );
			$this->nl();
			echo str_repeat( "-", $this->_cols ) . "\n";
		}
	}


	/**
	 * Find command wrapper.
	 *
	 * Usage: find [args] [flags]
	 * [args] file=index.php  ( File to search for. )
	 * [args] path=../../     ( defult value )
	 * [args] depth=1         ( How deap to search into subdirectories. )
	 *
	 * [flags] -h ( for this help list )
	 *
	 * [command] debug ( outputs the full command array )
	 *
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:    3/27/19, 9:09 AM
	 *
	 * @param        $file
	 * @param        $depth
	 * @param string $path
	 */
	public function find( $file, $depth, $path = '../../' ) {

		if ( $file && ! empty( $file ) ) {

			//	$color = new cli_colors();
			$cmd = "find $path -maxdepth $depth -type f -name '$file'";
			echo "Running command.\n$cmd\n\n";

			$output = shell_exec( $cmd );
			$output = explode( "\n", trim( $output ) );
			$output = array_filter( $output );
			$count  = count( $output );

			$this->lines( "Found: $count files." );

			if ( $count > 0 ) {

				$tbl = new cli_table();
				$tbl->set_headers(
					array( 'File Path', 'Size' )
				);

				foreach ( $output as $file ) {
					$size      = filesize( $file );
					$file_path = str_replace( '../../', '', $file );
					$tbl->add_row( array( $file_path, $size ) );
				}

				echo $tbl->get_table();

				$this->lines();
			}

		} else {
			// Empty arguments
			fwrite( STDERR, "No arguments set.\n" );
		}
	}

	/**
	 * The CLI Builder Help content.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-03-27, 12:58
	 *
	 */
	public function help() {
		echo "
php cli.php your_command                    | basic command.
php cli.php debug                           | adds print_r for the \$argv.
php cli.php --option_no_val                 | will have empty value.
php cli.php --option_with_val='Hello World' | basic use of options.
php cli.php myarg='foo bar'                 | basic use of arguments.
php cli.php -m                              | custom flags.

You can add your own help commands like 
php cli.php my_command -h 
Then watch for the -h in your command code.  
		";
	}

	/**
	 * Makes it so we can have nice formatted and colored dumps in the command line.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:    3/13/19, 10:58 AM
	 *
	 * @param      $input
	 */
	public function pretty_dump( $input ) {

		$recursive = function ( $data, $level = 0 ) use ( &$recursive ) {

			$colors      = new cli_colors();
			$type        = ! is_string( $data ) && is_callable( $data ) ? "Callable" : ucfirst( gettype( $data ) );
			$type_data   = null;
			$type_color  = 'red';
			$type_length = null;

			switch ( $type ) {
				case "String":
					$type_color  = "red";
					$type_length = strlen( $data ) - 11; // @bug getting an extra 11 added to the string length
					$type_data   = "\"" . htmlentities( $data ) . "\"";
				break;

				case "Double":
				case "Float":
					$type        = "Float";
					$type_color  = "darkblue";
					$type_length = strlen( $data );
					$type_data   = htmlentities( $data );
				break;

				case "Integer":
					$type_color  = "green";
					$type_length = strlen( $data );
					$type_data   = htmlentities( $data );
				break;

				case "Boolean":
					$type_color  = "blue";
					$type_length = strlen( $data );
					$type_data   = $data ? "TRUE" : "FALSE";
				break;

				case "NULL":
					$type_color  = "black";
					$type_length = 0;
					$type_data   = 'NULL';
				break;

				case "Array":
					$type_length = count( (array) $data );
			}

			if ( in_array( $type, array( "Object", "Array" ) ) ) {

				$not_empty = false;

				foreach ( $data as $key => $value ) {
					if ( ! $not_empty ) {

						$not_empty = true;

						echo $type . ( $type_length !== null ? "(" . $type_length . ")" : "" ) . "\n";

						for ( $i = 0; $i <= $level; $i ++ ) {
							echo "|   ";
						}

						echo "\n";
					}

					for ( $i = 0; $i <= $level; $i ++ ) {
						echo "|   ";
					}

					echo $colors->get_colored( "[" . $key . "]", 'blue' ) . " => ";

					// Make sure we only color strings.
					$value_string = ( is_array( $value ) ) ? $value : $colors->get_colored( $value, $type_color );
					call_user_func( $recursive, $value_string, $level + 1 );
				}

				if ( $not_empty ) {
					for ( $i = 0; $i <= $level; $i ++ ) {
						echo "|   ";
					}
				} else {
					echo $type . ( $type_length !== null ? $colors->get_colored( "(" . $type_length . ")", 'green' ) : "" ) . " ";
				}

			} else {
				echo $type . ( $type_length !== null ? $colors->get_colored( "(" . $type_length . ")", 'green' ) : "" ) . " ";

				if ( $type_data != null ) {
					echo $type_data;
				}
			}

			echo "\n";
		};

		call_user_func( $recursive, $input );
	}

	/**
	 * Shut down.
	 */
	public function __destruct() {
		// shutdown
		die( "\nFinished\n" );
	}

}
// End cli.php
