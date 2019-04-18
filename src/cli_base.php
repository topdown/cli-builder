<?php

/**
 *
 * PHP version 7.
 *
 * Created: 2019-04-18, 13:17
 *
 * LICENSE:
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2019 ValidWebs.com
 * @package        cli_builder - cli_base.php
 * @license
 * @version
 * cli_builder
 * cli_base.php
 */

namespace cli_builder;


use cli_builder\helpers\cli_colors;

/**
 * This class setups the main CLI functionallity for command line argument features.
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2019 ValidWebs.com
 *
 * Class cli_base
 * @package        cli_builder
 */
class cli_base extends cli {

	/**
	 * Link to the repository for outputting in the command line.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     2019-03-27, 19:30
	 *
	 */
	public function repo() {
		echo 'https://github.com/topdown/cli-builder/';
	}

	/**
	 * CLI Builder header output.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 *
	 * Created:    3/27/19, 9:06 AM
	 *
	 * @param bool $logo
	 * @param bool $date
	 */
	public function header( $logo = true, $date = true ) {

		if ( $logo === true ) {
			$color = new cli_colors();

			$logo
				= <<<LOGO
                                                                               
   ██████╗██╗     ██╗    ██████╗ ██╗   ██╗██╗██╗     ██████╗ ███████╗██████╗   
  ██╔════╝██║     ██║    ██╔══██╗██║   ██║██║██║     ██╔══██╗██╔════╝██╔══██╗  
  ██║     ██║     ██║    ██████╔╝██║   ██║██║██║     ██║  ██║█████╗  ██████╔╝  
  ██║     ██║     ██║    ██╔══██╗██║   ██║██║██║     ██║  ██║██╔══╝  ██╔══██╗  
  ╚██████╗███████╗██║    ██████╔╝╚██████╔╝██║███████╗██████╔╝███████╗██║  ██║  
   ╚═════╝╚══════╝╚═╝    ╚═════╝  ╚═════╝ ╚═╝╚══════╝╚═════╝ ╚══════╝╚═╝  ╚═╝  
LOGO;
			echo $color->get_colored( "\n$logo\n", "cyan", "black" ) . "\n";
		}

		$this->separator();

		if ( $date === true ) {
			$this->text( '[' . date( 'm-d-Y h:m:s' ) . ']', true );
		}
		$this->separator();

		// If debug is a command output the argument array.
		if ( in_array( 'debug', $this->args['commands'] ) ) {
			$this->text( 'Arguments', true );
			$this->separator();
			$this->pretty_dump( $this->args );
			$this->separator();
		}

	}

	/**
	 * Cli Builder footer output.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:    3/27/19, 9:06 AM
	 *
	 */
	public function footer() {

	}


	/**
	 * Simple profiler that starts at the begginning and outputs the time and membory at the end.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:    3/27/19, 9:07 AM
	 *
	 * @param $start
	 */
	public function benchmark( $start ) {
		$mtime     = microtime();
		$mtime     = explode( ' ', $mtime );
		$timestart = explode( ' ', $start );
		$starttime = $timestart[1] + $timestart[0];
		$timeend   = $mtime[1] + $mtime[0];
		$timetotal = $timeend - $starttime;
		$r         = number_format( $timetotal, 5 );

		echo "\n";
		$this->separator( '+' );
		$this->text( 'Benchmark', true );
		$this->separator( '+' );
		echo "Load Time:                               $r seconds\n";
		if ( function_exists( 'memory_get_peak_usage' ) ) {
			echo "Peak Memory Usage:                       " . round( memory_get_peak_usage() / 1048576, 6 ) . " MiB\n";
		}
		$this->separator( '+' );
	}

	/**
	 * Command argument handling the creates an array for command --options -flags arguments=.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:    2/8/18, 9:48 AM
	 *
	 * @param $args
	 *
	 * @return array
	 */
	public function handler( $args ) {

		// We don't want the default stuff on $argv.
		array_shift( $args );
		$end_of_options = false;

		// Our container for the types of command args.
		$ret = array(
			'commands'  => array(),
			'options'   => array(),
			'flags'     => array(),
			'arguments' => array(),
		);

		while ( $arg = array_shift( $args ) ) {

			// if we have reached end of options,
			//we cast all remaining argvs as arguments
			if ( $end_of_options ) {
				$ret['arguments'][] = $arg;
				continue;
			}

			/**
			 * -------------------------------------------
			 * OPTIONS
			 * -------------------------------------------
			 * Is it a command? (prefixed with --)
			 */
			if ( substr( $arg, 0, 2 ) === '--' ) {

				// is it the end of options flag?
				if ( ! isset ( $arg[3] ) ) {
					$end_of_options = true; // end of options;
					continue;
				}

				$value = "";
				$com   = substr( $arg, 2 );

				// is it the syntax '--option=argument'?
				if ( strpos( $com, '=' ) ) {

					list( $com, $value ) = preg_split( "/=/", $com, 2 );

				} // is the option not followed by another option but by arguments
				elseif ( isset( $args[0] ) && strpos( $args[0], '-' ) !== 0 ) {

					// --word with no =value creates an indefinate loop of errors.
					// This check fixes that.
					if ( isset( $args[0] ) ) {

						while ( strpos( $args[0], '-' ) !== 0 ) {
							$value .= array_shift( $args ) . ' ';
						}

						$value = rtrim( $value, ' ' );
					}
				}

				$ret['options'][ $com ] = ( ! empty( trim( $value ) ) ) ? $value : '';

				continue;

			}

			/**
			 * -------------------------------------------
			 * FLAGS
			 * -------------------------------------------
			 * Is it a flag or a serial of flags? (prefixed with -)
			 */
			if ( substr( $arg, 0, 1 ) === '-' ) {

				for ( $i = 1; isset( $arg[ $i ] ); $i ++ ) {
					$ret['flags'][] = trim( $arg[ $i ] );
				}

				continue;
			}

			/**
			 * -------------------------------------------
			 * ARGUMENTS
			 * -------------------------------------------
			 * If it has an = but is not in quotes, its arguments.
			 */
			if ( strpos( $arg, '=' ) !== false ) {

				$part = explode( '=', $arg );

				if ( isset( $part[0] ) && isset( $part[1] ) ) {
					$key                      = str_replace( ' ', '_', trim( $part[0] ) );
					$ret['arguments'][ $key ] = trim( $part[1] );
				} else {
					$ret['arguments'][] = trim( $arg );
				}

				continue;
			}

			/**
			 * -------------------------------------------
			 * COMMANDS
			 * -------------------------------------------
			 * It is not an option, or flag, or argument so it has to be a command.
			 */
			$ret['commands'][] = $arg;
			continue;
		}

		return $this->args = $ret;
	}

}
// End cli_base.php
