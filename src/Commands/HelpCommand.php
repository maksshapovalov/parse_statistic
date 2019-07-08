<?php


namespace Parser\Commands;


use Parser\Console;

class HelpCommand extends AbstractCommand
{
    public function execute()
    {
        Console::getHelp();
    }
}