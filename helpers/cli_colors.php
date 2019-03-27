<?php

/**
 *
 * PHP version 5
 *
 * Created: 3/17/19, 10:46 AM
 *
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2019 ValidWebs.com
 * @license        https://raw.githubusercontent.com/topdown/cli-builder/master/LICENSE
 * @version        0.0.1
 *
 * mormvc
 * cli_colors.php
 */
namespace cli_builder\helpers;

/**
 *
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2019 ValidWebs.com
 *
 * Class cli_colors
 * @package        cli_builder\helpers
 */
class cli_colors {

	/**
	 * @property array $foreground_colors
	 */
	private $foreground_colors = array();

	/**
	 * @property array $background_colors
	 */
	private $background_colors = array();

	/**
	 * cli_colors constructor.
	 */
	public function __construct() {
		// Set up shell colors
		$this->foreground_colors['black']        = '0;30';
		$this->foreground_colors['dark_gray']    = '1;30';
		$this->foreground_colors['blue']         = '0;34';
		$this->foreground_colors['light_blue']   = '1;34';
		$this->foreground_colors['green']        = '0;32';
		$this->foreground_colors['light_green']  = '1;32';
		$this->foreground_colors['cyan']         = '0;36';
		$this->foreground_colors['light_cyan']   = '1;36';
		$this->foreground_colors['red']          = '0;31';
		$this->foreground_colors['light_red']    = '1;31';
		$this->foreground_colors['purple']       = '0;35';
		$this->foreground_colors['light_purple'] = '1;35';
		$this->foreground_colors['brown']        = '0;33';
		$this->foreground_colors['yellow']       = '1;33';
		$this->foreground_colors['light_gray']   = '0;37';
		$this->foreground_colors['white']        = '1;37';

		$this->background_colors['black']      = '40';
		$this->background_colors['red']        = '41';
		$this->background_colors['green']      = '42';
		$this->background_colors['yellow']     = '43';
		$this->background_colors['blue']       = '44';
		$this->background_colors['magenta']    = '45';
		$this->background_colors['cyan']       = '46';
		$this->background_colors['light_gray'] = '47';
	}

	/**
	 * Returns colored string.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     3/27/19, 11:38 AM
	 *
	 * @param      $string
	 * @param null $foreground_color
	 * @param null $background_color
	 *
	 * @return string
	 */
	public function get_colored( $string, $foreground_color = null, $background_color = null ) {
		$colored_string = "";

		// Check if given foreground color found
		if ( isset( $this->foreground_colors[ $foreground_color ] ) ) {
			$colored_string .= "\033[" . $this->foreground_colors[ $foreground_color ] . "m";
		}
		// Check if given background color found
		if ( isset( $this->background_colors[ $background_color ] ) ) {
			$colored_string .= "\033[" . $this->background_colors[ $background_color ] . "m";
		}

		// Add string and end coloring
		$colored_string .= $string . "\033[0m";

		return $colored_string;
	}

	/**
	 * Returns all foreground color names.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     3/27/19, 11:39 AM
	 *
	 * @return array
	 */
	public function get_foreground_colors() {
		return array_keys( $this->foreground_colors );
	}

	/**
	 * Returns all background color names.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     3/27/19, 11:39 AM
	 *
	 * @return array
	 */
	public function get_background_colors() {
		return array_keys( $this->background_colors );
	}

	/**
	 * Just another text function to output all color options.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     3/27/19, 11:39 AM
	 *
	 */
	public function output_all_colors() {

		// Get Foreground Colors
		$fgs = $this->get_foreground_colors();
		// Get Background Colors
		$bgs = $this->get_background_colors();

		// Loop through all foreground and background colors
		$count = count( $fgs );
		for ( $i = 0; $i < $count; $i ++ ) {
			echo $this->get_colored( "Test Foreground colors", $fgs[ $i ] ) . "\t";
			if ( isset( $bgs[ $i ] ) ) {
				echo $this->get_colored( "Test Background colors", null, $bgs[ $i ] );
			}
			echo "\n";
		}
		echo "\n";

		// Loop through all foreground and background colors
		foreach ( $fgs as $fg ) {
			foreach ( $bgs as $bg ) {
				echo $this->get_colored( "Test Colors", $fg, $bg ) . "\t";
			}
			echo "\n";
		}
	}

	/**
	 * Test method for testing colors.
	 *
	 * @author         Jeff Behnke <code@validwebs.com>
	 * @copyright  (c) 2009 - 2019 ValidWebs.com
	 *
	 * Created:     3/27/19, 11:39 AM
	 *
	 */
	public function tests() {
		// Test some basic printing with Colors class
		echo $this->get_colored( " Testing Colors class, this is purple string on yellow background. ", "purple", "yellow" ) . "\n";
		echo $this->get_colored( "Testing Colors class, this is blue string on light gray background.", "blue", "light_gray" ) . "\n";
		echo $this->get_colored( "Testing Colors class, this is red string on black background.", "yellow", "black" ) . "\n";
		echo $this->get_colored( "Testing Colors class, this is cyan string on green background.", null, "green" ) . "\n";
		echo $this->get_colored( "Testing Colors class, this is cyan string on default background.", "cyan" ) . "\n";
		echo $this->get_colored( "Testing Colors class, this is default string on cyan background.", null, "cyan" ) . "\n";

	}
}

// End cli_colors.php