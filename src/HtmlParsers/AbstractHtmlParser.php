<?php


namespace Parser\HtmlParsers;


abstract class AbstractHtmlParser
{
    protected $url;
    private $page;


    /**
     * @param string $tagName
     * @param string $attrName
     * @return array
     */
    abstract public function getElementsByTagAttr(string $tagName, string $attrName): array;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
        $this->page = null;
    }

    /**
     * @return bool|string
     */
    public function getHtmlPage()
    {
        if (!$this->page) {
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $this->url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($handle, CURLOPT_HEADER, [
                'Accept: text/html,application/xhtml+xml,application/xml'
            ]);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 0);
            $this->page = curl_exec($handle);

            $info = curl_getinfo($handle);
            if ($info['http_code'] == 200) {
                $this->url = $info['url'];
            }
            curl_close($handle);
        }
        return $this->page;
    }
}