<?php


namespace Parser\Commands;


use Parser\Exception;

class ParseCommand extends AbstractCommand
{
    private $domain;
    private $url;
    private $scheme;
    const PARAM_KEY = 'url';

    /**
     * @throws \Parser\Exception
     */
    public function execute()
    {
        $this->setRequiredParams([self::PARAM_KEY]);
        if ($this->isValidParams()) {
            $this->htmlParser->setUrl($this->params[self::PARAM_KEY]);
            if ($this->htmlParser->getHtmlPage()){
                $this->setUrlData();
                $this->getImages();
            } else {
                throw new Exception('Could not connect to provided resource');
            }
        }
    }

    private function getImages(): array
    {
        $images = $this->htmlParser->getElementsByTagAttr('img', 'src');
        foreach ($images as $key => $image) {
            if(!parse_url($image, PHP_URL_HOST)) {
                $images[$key] = $this->scheme . '://' . $this->domain . $image;
            }
        }
        return $images;
    }

    private function setUrlData()
    {
        $this->url = $this->htmlParser->getUrl();
        $this->domain = parse_url($this->url, PHP_URL_HOST);
        $this->scheme = parse_url($this->url, PHP_URL_SCHEME);
    }
}