<?php


namespace Parser\Commands;



use Parser\Exception;

class ReportCommand extends AbstractCommand
{
    const PARAM_KEY = 'domain';
    protected $domain;

    /**
     * @throws \Parser\Exception
     */
    public function execute()
    {
        $this->setRequiredParams([self::PARAM_KEY]);
        if ($this->isValidParams()) {
            $this->htmlParser->setUrl($this->params[self::PARAM_KEY]);
            if ($this->htmlParser->getHtmlPage()) {
                $this->domain = parse_url($this->htmlParser->getUrl(), PHP_URL_HOST);
                echo $this->report->getDomainReport(
                    $this->dataProvider->getDomainData($this->domain)
                );
            } else {
                throw new Exception('Could not find such domain');
            }
        }
    }
}