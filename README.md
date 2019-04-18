![alt text](https://raw.githubusercontent.com/topdown/cli-builder/master/assets/logo.jpg)

CLI Builder is a PHP Command Line Builder that aims to help simplify building powerful CLI commands for PHP.

[Screenshot](https://raw.githubusercontent.com/topdown/cli-builder/master/assets/screenshot.jpg)

The main CLI class implements a handler that parses the string passed via `$argv`

It is parsed into an array as follows.

| String | Definition |
|:---|:---|
|__command__| Single word |
| __--option__ | Single word prefexed with `--` and accepts values via `=` |
| __-f__ | Single character prefixed with `-` |
| __argument=__ | Single word that has value via `=` |

__This makes your CLI options endless for each command you want to build.__

__Example__
```bash
php cli.php mycommand --option_no_val --option_with_val="Hello World" myarg="foo_bar" -m  debug
```

Would be an array of instructions to use in your command class like the following.
```
Array(4)
|   
|   [commands] => Array(1)
|   |   
|   |   [0] => String(6) "mycommand"
|   |   
|   [options] => Array(2)
|   |   
|   |   [option_no_val] => String(0) ""
|   |   [option_with_val] => String(11) "Hello World"
|   |   
|   [flags] => Array(1)
|   |   
|   |   [0] => String(1) "m"
|   |   
|   [arguments] => Array(1)
|   |   
|   |   [myarg] => String(7) "foo_bar"
|   |   
|   
```

### Getting Started.

_Composer setup is coming soon which will be the preferred way._

```bash
mkdir cli

cd cli

git clone https://github.com/topdown/cli-builder.git

cd cli-builder

mkdir logs
chmod 777 logs

mkdir commands

# I use CLI Builder for generating scaffolds so I also have templates for my commands.
# This is where I put my template functions for adding pre templated code to files.
mkdir commands/templates

cp cli-builder/example-cli.php cli.php

```

### Generating Starter Commands

```bash
php cli-builder/src/generate.php command=testing namespace=foo_bar

```
Will generate a command class named `testing` with the namespace `cli_builder\commands\foo_bar` in the `commands` directory.

__NOTE:__ Leaving the `namespace=` off of this command makes the namespace default to `namespace cli_builder\commands;`

Namespaces will __eventually__ generate proper directory structures. `commands/foo_bar/testing.php`


### Setup  (see) example-cli.php

```php

use cli_builder\command\invoker;
use cli_builder\command\receiver;

// Only command line
if ( php_sapi_name() !== 'cli' ) {
	die( 'This is a command line tool only.' );
}

include_once 'cli-builder/setup.php';

// CLI Base methods
$cli_base = new \cli_builder\cli_base();

// Loads your command line args into an array( options=[], arguments=[] commands=[], flags=[] ).
$arguments = $cli_base->handler( $argv );

// Start the CLI
$cli = new \cli_builder\cli( $arguments );

// Our header output. (optional)
$cli_base->header();

// New CLI Builder with creation methods.
$builder = new \cli_builder\command\builder();

```

### Registering Commands

__NOTE:__ If you change commands with a single $invoker and single $receiver they will all run and output at the end of the run.

It's better to use a switch and separate commands like in the next section __Example Commands cli.php__.

```php
// Custom commands.
include_once "commands/HelloCommand.php";
include_once "commands/FooCommand.php";
include_once "commands/BarCommand.php";

// Register HelloCommand.
$invoker->set_command( new \cli_builder\commands\HelloCommand( $receiver ) );
// Run the command.
$invoker->run();

// Register FooCommand.
$invoker->set_command( new \cli_builder\commands\FooCommand( $receiver ) );
// Run the command.
$invoker->run();

// Register BarCommand.
$invoker->set_command( new \cli_builder\commands\BarCommand( $receiver ) );
// Run the command.
$invoker->run();

// Outputs the results from all three commands registered above.
echo $receiver->get_output();

```

#### Example Commands cli.php

```php
// Lots of commands
foreach ( $arguments['commands'] as $command ) {

	switch ( $command ) {

		case 'command1':
		
			// Required to load our custom commands.
			$invoker  = new invoker();
			$receiver = new receiver();
			
			// Custom build path. Defaults to build/
			$receiver->set_build_path( 'build/api' );
			
			// Include your command.
			include_once "commands/command1.php";
			
			// Register BarCommand.
			$invoker->set_command( new \cli_builder\commands\command1( $receiver ) );
			
			
			// Run the command.
			$invoker->run();
		break;

		case 'command2':
			// Required to load our custom commands.
			$invoker  = new invoker();
			$receiver = new receiver();
			
			// Include your command.
			include_once "commands/command2.php";
			
			// Register BarCommand.
			$invoker->set_command( new \cli_builder\commands\command2( $receiver ) );
			
			// Run the command.
			$invoker->run();
		break;
	}
}

```

### Layout

Hiding the logo and date
```php
// The first param is for logo and second for date.
$cli->header( false, false);

```

### Methods Available In Command Classes

The following are available if you use the command generator to scaffold your commands so the proper objects are availble to the class.

```php 

// Get the args that were used in the command line input.
$args = $this->_cli->get_args();

// Create a directory. All directories have an index.php added on creation.
$this->_builder->create_directory( $this->_command->build_path . '/foobar' );

// Create nested directories
$this->_builder->create_directory( $this->_command->build_path . '/foo/bar/testing' );

// Create a file.
$this->_builder->create_file( $this->_command->build_path . '/foo/bar/testing/hello.php' );

// Write to file. $config would be your template to write into the file.
$this->_builder->write_file( $this->_command->build_path . '/foo/bar/testing/hello.php', $config );

// Dump your input command line arguments array into a colored output.
$this->_cli->pretty_dump( $args );

// Logging things to a log file. Also excepts a second param for custom log name.
$this->_command->log( __CLASS__ . ' completed run.' );

// Separator lines in your output with option custom param like + = etc...
$this->_cli->separator();

// New line space in your output
$this->_cli->nl();

// Outputs a separator, but can add text with another separator after it.
$this->_cli->lines('Testing lines');

// Output text now. Set second param to true for centering the text.
$this->_cli->text('My text');

// Will output all content sent to the write method at the end even if it was set in the beginning.
$this->_command->write( __CLASS__ . ' completed run.' );

```


### CLI Helpers

All of these styling helpers are __optional__.

#### Separator (full width of the current window)
```php
$cli->separator();
// Default output
-----------------------------------------------------------------

// Custom
$cli->separator('+');
// Custom output
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

```

#### Text
```php
// Adds a \n (new line) return on the end.
$cli->text('My text');

// Centered Text, will center it in the window
$cli->text('My centered text', true);

```

#### Progress bar for long running processes (optional)
```php
$cli->progress_bar( $done, $tasks);

// Example
for ( $done = 0; $done <= $tasks; $done ++ ) {

	$cli->progress_bar( $done, $tasks);
	usleep( ( rand() % 127 ) * 100 );
}
```

#### Pretty Dump (optional)
See the colored array in the [Screenshot](https://raw.githubusercontent.com/topdown/cli-builder/master/assets/screenshot.jpg)

```php
$cli->pretty_dump( $your_array );
```

#### Table Data (optional)
```php

// At the top of your command class after your namespace
use cli_builder\helpers\cli_table;

// Example Use
$tbl = new cli_table();
$tbl->set_headers(
	array( 'File Path', 'Size' )
);

// Your data array.
$items = array();

foreach ( $items as $item ) {
	$size      = filesize( $item );;
	// Add your row. 
	//Make sure you have as many items in the addRow array as your setHeaders.
	$tbl->add_row( array( $item, $size ) );
}
// Output the table.
echo $tbl->get_table();
```
__Table Output Example__

```bash
+--------------------------------+------+
| File Path                      | Size |
+--------------------------------+------+
| ./cli-builder/assets/index.php | 297  |
| ./index.php                    | 325  |
| ./logs/index.php               | 297  |
| ./src/index.php                | 297  |
| ./src/commands/index.php       | 297  |
| ./src/command/index.php        | 297  |
| ./src/helpers/index.php        | 297  |
+--------------------------------+------+
```

#### Colors (optional)
```php
$colors = new \cli_builder\helpers\cli_colors();
// Just colored text.
echo $colors->get_colored( 'Just colored text', 'green' );
// Colored text and background.
echo $colors->get_colored( 'Colored text and background', 'light_blue', 'black' );
```

| Text Colors | Background Colors |
|:---:|:---:|
| black             | black      |  
| dark_gray         | red        |  
| blue              | green      |  
| light_blue        | yellow     |  
| green             | blue       |  
| light_green       | magenta    |  
| cyan              | cyan       |  
| light_cyan        | light_gray |  
| red              |             |
| light_red        |             |
| purple           |             |
| light_purple     |             |
| brown            |             |
| yellow           |             |
| light_gray       |             |
| white            |             |


#### Benchmark (optional)
```php
// Will output the time to process in seconds and also the max memory used.
$cli_base->benchmark( $start );
```

