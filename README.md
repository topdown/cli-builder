![alt text](https://raw.githubusercontent.com/topdown/cli-builder/master/assets/logo.jpg)
CLI Builder aims to help simplify building powerful CLI commands for PHP.

![alt text](https://raw.githubusercontent.com/topdown/cli-builder/master/assets/screenshot.jpg)


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
php cli.php find path='.' depth=6 debug --foo=test -b -c
```

## Setup

```php
// Only command line
if ( php_sapi_name() !== 'cli' ) {
	die( 'This is a command line tool only.' );
}

use cli_builder\command\Invoker;
use cli_builder\command\Receiver;

$start = microtime();

// PHP settings
ini_set( "log_errors", 1 );
ini_set( "error_log", __DIR__ . '/logs/error.log' );

date_default_timezone_set( 'America/Chicago' );

// Helpers - Mostly for visual decorating.
include_once "src/helpers/Console_Table.php";
include_once "src/helpers/cli_colors.php";

// Interfaces and Cammand package to encapsulate, invocation and decoupling of future commands.
// These are required.
include_once "src/command/CommandInterface.php";
include_once "src/command/UndoableCommandInterface.php";
include_once "src/command/Receiver.php";
include_once "src/command/Invoker.php";

// The instance of the CLI.
// Required to use the built in simplicity, IE output, arg handling, progress bar, etc..
include_once "src/cli.php";
$cli = new \cli_builder\cli();
// Our header output.
$cli->header();

// Required to load our custom commands.
$invoker  = new Invoker();
$receiver = new Receiver();

// Custom commands.

```