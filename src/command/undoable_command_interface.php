<?php

namespace cli_builder\command;

interface undoable_command_interface extends command_interface {
	/**
	 * This method is used to undo change made by command execution
	 */
	public function undo();
}
