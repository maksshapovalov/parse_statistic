<?php


namespace Parser\Commands;


use Parser\Exception;

class ParseCommand extends AbstractCommand
{
    const PARAM_KEY = 'url';
    private $domain;
    private $url;
    private $scheme;

    /**
     * @throws \Parser\Exception
     */
    public function execute()
    {
        $this->setRequiredParams([self::PARAM_KEY]);
        if ($this->isValidParams()) {
            $this->htmlParser->setUrl($this->params[self::PARAM_KEY]);
            if ($this->htmlParser->getHtmlPage()) {
                $this->setUrlData();
                $this->parseData($this->url);
                echo $this->report->getParseReport(
                    $this->dataProvider->getParseData($this->domain, $this->url)
                );
            } else {
                throw new Exception('Could not connect to provided resource');
            }
        }
    }

    private function setUrlData()
    {
        $this->url = $this->htmlParser->getUrl();
        $this->domain = parse_url($this->url, PHP_URL_HOST);
        $this->scheme = parse_url($this->url, PHP_URL_SCHEME);
    }

    private function parseData($url): void
    {
        echo 'Parse link: ' . $url . PHP_EOL;
        if (!$this->dataProvider->isAlreadyParsed(
            $this->domain,
            $this->url,
            $url
        )) {
            $this->htmlParser->setUrl($url);
            $this->dataProvider->saveParseData(
                $this->domain,
                $this->url,
                $url,
                $this->getImages()
            );
            $this->parseChildren();
        }
    }

    /**
     * @return array
     */
    private function getImages(): array
    {
        $images = $this->htmlParser->getElementsByTagAttr('img', 'src');
        foreach ($images as $key => $image) {
            if (!parse_url($image, PHP_URL_HOST)) {
                $images[$key] = $this->scheme . '://' . $this->domain . $image;
            }
        }
        return $images;
    }

    private function parseChildren(): void
    {
        $links = $this->htmlParser->getElementsByTagAttr('a', 'href');
        foreach ($links as $link) {
            if (!parse_url($link, PHP_URL_HOST)) {
                $url = $this->scheme . '://' . $this->domain . $link;
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    $this->parseData($url);
                }
            }
        }
    }
}