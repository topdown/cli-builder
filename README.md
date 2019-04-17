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
php cli.php mycommand --option_no_val --option_with_val="Hello World" myarg="foo bar" -m  debug
```

### Getting Started.

_Composer setup is coming soon which will be the preferred way._

```bash
git clone https://github.com/topdown/cli-builder.git

cd cli-builder

mkdir logs
chmod 777 logs

mkdir commands

cp example-cli.php cli.php

```

### Generating Starter Commands

```bash
sh gen.sh command=testing namespace=foo_bar

```
Will generate a command class named `testing` with the namespace `cli_builder\commands\foo_bar` in the `commands` directory.

Namespaces will __eventually__ generate proper directory structures. `commands/foo_bar/testing.php`


### Setup  (see) example-cli.php

```php

use cli_builder\command\invoker;
use cli_builder\command\receiver;

// Only command line
if ( php_sapi_name() !== 'cli' ) {
	die( 'This is a command line tool only.' );
}

include_once 'setup.php';

$cli = new \cli_builder\cli();
// Our header output. (optional)
$cli->header();

// Required to load our custom commands.
$invoker  = new invoker();
$receiver = new receiver();

// Your Custom commands.

```

### Registering Commands

```php
// Custom commands.
include_once "commands/HelloCommand.php";
include_once "commands/FooCommand.php";
include_once "commands/BarCommand.php";

// Register HelloCommand.
$invoker->set_command( new HelloCommand( $receiver ) );
// Run the command.
$invoker->run();

// Register FooCommand.
$invoker->set_command( new FooCommand( $receiver ) );
// Run the command.
$invoker->run();

// Register BarCommand.
$invoker->set_command( new BarCommand( $receiver ) );
// Run the command.
$invoker->run();

// Outputs the results from all three commands registered above.
echo $receiver->get_output();

```

### Layout

Hiding the logo and date
```php
// The first param is for logo and second for date.
$cli->header(false,false);

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
$cli->benchmark( $start );
```

