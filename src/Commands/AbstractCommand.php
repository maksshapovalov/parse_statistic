<?php


namespace Parser\Commands;


use Parser\Exception;
use Parser\HtmlParsers\AbstractHtmlParser;

abstract class AbstractCommand implements ICommand
{
    protected $params = [];
    protected $requiredParams = [];
    protected $htmlParser;

    public function __construct(array $params, AbstractHtmlParser $htmlParser)
    {
        $this->params = $params;
        $this->htmlParser = $htmlParser;
    }

    /**
     * @param array $requiredParams
     */
    public function setRequiredParams(array $requiredParams): void
    {
        $this->requiredParams = $requiredParams;
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected function isValidParams()
    {
        if (!empty($this->requiredParams)) {
            foreach ($this->requiredParams as $param){
                if(!array_key_exists($param, $this->params)) {
                    throw new Exception('Missing required parameter --' . $param, Exception::E_OPTION_PARAM_REQUIRED);
                }
            }
        }
        return true;
    }


}