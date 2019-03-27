<?php

namespace cli_builder\command;

/**
 * This concrete command tweaks receiver to add current date to messages
 * invoker just knows that it can call "execute"
 */
class add_message_date_command implements undoable_command_interface {
	/**
	 * @var receiver
	 */
	private $output;

	/**
	 * Each concrete command is built with different receivers.
	 * There can be one, many or completely no receivers, but there can be other commands in the parameters.
	 *
	 * @param receiver $console
	 */
	public function __construct( receiver $console ) {
		$this->output = $console;
	}

	/**
	 * Execute and make receiver to enable displaying messages date.
	 */
	public function execute() {
		// sometimes, there is no receiver and this is the command which
		// does all the work
		$this->output->enable_date();
	}

	/**
	 * Undo the command and make receiver to disable displaying messages date.
	 */
	public function undo() {
		// sometimes, there is no receiver and this is the command which
		// does all the work
		$this->output->disable_date();
	}
}
