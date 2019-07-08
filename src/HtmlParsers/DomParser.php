<?php


namespace Parser\HtmlParsers;


class DomParser extends AbstractHtmlParser
{

    /**
     * @param string $tagName
     * @param string $attrName
     * @return array
     */
    public function getElementsByTagAttr(string $tagName, string $attrName): array
    {
        $elements = [];
        $dom = new \DOMDocument();
        @$dom->loadHTML($this->getHtmlPage());

        $xpath = new \DOMXPath($dom);
        $domElements = $xpath->evaluate("/html/body//" . $tagName);

        foreach ($domElements as $domElement) {
            /** @var $domElement \DOMElement*/
            $elements[] = $domElement->getAttribute($attrName);
        }
        return $elements;
    }


}