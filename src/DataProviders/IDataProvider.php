<?php


namespace Parser\DataProviders;


interface IDataProvider
{

    /**
     * @param string $domain
     * @param string $parentUrl
     * @param string $childUrl
     * @param array $data
     */
    public function saveParseData(string $domain, string $parentUrl, string $childUrl, array $data): void;

    /**
     * @param string $domain
     * @param string $url
     * @return array
     */
    public function getParseData(string $domain, string $url): array;

    /**
     * @param string $domain
     * @return array
     */
    public function getDomainData(string $domain): array;

    /**
     * @param string $domain
     * @param string $parentUrl
     * @param string $childUrl
     * @return bool
     */
    public function isAlreadyParsed(string $domain, string $parentUrl, string $childUrl): bool;
}