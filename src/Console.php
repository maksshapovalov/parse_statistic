<?php


namespace Parser;


use Parser\Commands\ICommand;
use Parser\HtmlParsers\DomParser;

class Console
{

    /**
     * @param array $args
     * @return bool
     * @throws Exception
     */
    public function execute(array $args)
    {
        array_shift($args);
        $commandName = array_shift($args);
        $className = 'Parser\Commands\\' . $commandName . 'Command';
        if (class_exists($className)) {
            $params = [];
            foreach ($args as $arg) {
                if (strlen($arg) > 1 && $arg{1} == '-') {
                    $arg = explode('=', substr($arg, 2), 2);
                    $param = array_shift($arg);
                    $val = array_shift($arg);
                    $params[$param] = $val;
                }
            }
            /** @var $command ICommand */
            $command = new $className($params, new DomParser());
            $command->execute();
        } else {
            throw new Exception("Command $commandName not registered", Exception::E_UNKNOWN_OPTION);
        }

        return false;
    }

    static public function getHelp()
    {
        echo "
Commands:
    parse           Run parser
        --url       Required param
    report          Show domain analyze result
        --domain    Required param
    help            Show this message
    
Example: parser parse --url=google.com
";
    }
}