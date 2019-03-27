<?php
/**
 * This class is purely to follow the same coding style of my package.
 * PHP version 7.
 *
 * Created: 2019-03-27, 15:03
 *
 * LICENSE:
 *
 * @author         Jeff Behnke <code@validwebs.com>
 * @copyright  (c) 2009 - 2019 ValidWebs.com
 * @package        cli-builder - cli_table.php
 * @license        https://raw.githubusercontent.com/topdown/cli-builder/master/LICENSE
 * @version        0.0.1
 * cli_table.php
 */


namespace cli_builder\helpers;

/**
 * Class cli_table.
 */
class cli_table extends Console_Table {

	/**
	 * Sets the headers for the columns.
	 *
	 * @param array $headers The column headers.
	 *
	 * @return void
	 */
	public function set_headers( $headers ) {
		parent::setHeaders( $headers );
	}

	/**
	 * Adds a row to the table.
	 *
	 * @param array   $row    The row data to add.
	 * @param boolean $append Whether to append or prepend the row.
	 *
	 * @return void
	 */
	public function add_row( $row, $append = true ) {
		parent::addRow( $row, $append );
	}

	/**
	 * Inserts a row after a given row number in the table.
	 *
	 * If $row_id is not given it will prepend the row.
	 *
	 * @param array   $row    The data to insert.
	 * @param integer $row_id Row number to insert before.
	 *
	 * @return void
	 */
	public function insert_row( $row, $row_id = 0 ) {
		parent::insertRow( $row, $row_id );
	}

	/**
	 * Adds a column to the table.
	 *
	 * @param array   $col_data The data of the column.
	 * @param integer $col_id   The column index to populate.
	 * @param integer $row_id   If starting row is not zero, specify it here.
	 *
	 * @return void
	 */
	public function add_col( $col_data, $col_id = 0, $row_id = 0 ) {
		parent::addCol( $col_data, $col_id, $row_id );
	}

	/**
	 * Returns the generated table.
	 *
	 * @return string  The generated table.
	 */
	public function get_table() {
		return parent::getTable();
	}

	/**
	 * Adds a horizontal separator to the table.
	 *
	 * @return void
	 */
	public function add_separator() {
		parent::addSeparator();
	}


}

// End cli_table.php