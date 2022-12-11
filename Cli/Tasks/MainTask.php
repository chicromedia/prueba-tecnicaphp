<?php

namespace Cli\Tasks;

use Phalcon\Cli\Task;
use Phalcon\Migrations\Console\Color;

class MainTask extends Task
{
    private array $parameters = [
        'db synchronize' => 'Run synchronize with database',
        'db migrate' => 'Run generate the migrations of all tables',
    ];

    /**
     * Executes the main action of the cli mapping passed parameters to tasks
     */
    public function mainAction()
    {
        $this->dispatcher->forward( [
            "task" => "main",
            "action" => "help",
        ] );
    }

    public function helpAction(): void
    {
        echo PHP_EOL;
        echo Color::colorize( 'Devtools CLI', Color::FG_GREEN, Color::AT_BOLD ) . PHP_EOL . PHP_EOL;

        $length = 0;
        foreach ( $this->parameters as $parameter => $description )
        {
            if ( $length == 0 )
            {
                $length = strlen( $parameter );
            }
            if ( strlen( $parameter ) > $length )
            {
                $length = strlen( $parameter );
            }
        }

        echo Color::head( 'Commands for usage:' ) . PHP_EOL;
        foreach ( $this->parameters as $parameter => $description )
        {
            echo Color::colorize( $parameter . str_repeat( ' ', $length - strlen( $parameter ) ), Color::FG_GREEN );
            echo Color::colorize( '    ' . $description ) . PHP_EOL;
        }

        echo PHP_EOL . PHP_EOL;
    }
}
