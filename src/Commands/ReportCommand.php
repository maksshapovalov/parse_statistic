<?php


namespace Parser\Commands;


use Parser\Console;

class ReportCommand extends AbstractCommand
{
    const PARAM_KEY = 'domain';

    /**
     * @throws \Parser\Exception
     */
    public function execute()
    {
        $this->setRequiredParams([self::PARAM_KEY]);
        if ($this->isValidParams()) {
            echo 'Report!';
        }
    }
}