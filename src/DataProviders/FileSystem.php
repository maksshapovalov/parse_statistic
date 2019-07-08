<?php


namespace Parser\DataProviders;


class FileSystem implements IDataProvider
{
    private $filePath;

    public function __construct($rootPath)
    {
        $this->filePath = $rootPath . 'tmp/data';
    }

    /**
     * @param string $domain
     * @param string $parentUrl
     * @param string $childUrl
     * @param array $data
     */
    public function saveParseData(string $domain, string $parentUrl, string $childUrl, array $data): void
    {
        if (file_exists($this->filePath)) {
            $result = unserialize(file_get_contents($this->filePath)) ?: [];
        } else {
            $result = [];
        }
        if (array_key_exists($domain, $result)) {
            if (array_key_exists($parentUrl, $result[$domain])) {
                $result[$domain][$parentUrl][$childUrl] = $data;
            } else {
                $result[$domain][$parentUrl] = [$childUrl => $data];
            }
        } else $result[$domain] = [$parentUrl => [$childUrl => $data]];
        file_put_contents($this->filePath, serialize($result));
    }

    /**
     * @param string $domain
     * @param string $url
     * @return array
     */
    public function getParseData(string $domain, string $url): array
    {
        if (file_exists($this->filePath)) {
            $data = unserialize(file_get_contents($this->filePath));
            if (array_key_exists($domain, $data)) {
                if (array_key_exists($url, $data[$domain])) {
                    return $data[$domain][$url];
                }
            }
        }
        return [];
    }

    /**
     * @param string $domain
     * @param string $parentUrl
     * @param string $childUrl
     * @return bool
     */
    public function isAlreadyParsed(string $domain, string $parentUrl, string $childUrl): bool
    {
        if (file_exists($this->filePath)) {
            $data = unserialize(file_get_contents($this->filePath));
            if (array_key_exists($domain, $data)) {
                if (array_key_exists($parentUrl, $data[$domain])) {
                    return array_key_exists($childUrl, $data[$domain][$parentUrl]);
                }
            }
        }
        return false;
    }

    /**
     * @param string $domain
     * @return array
     */
    public function getDomainData(string $domain): array
    {
        if (file_exists($this->filePath)) {
            $data = unserialize(file_get_contents($this->filePath));
            if (array_key_exists($domain, $data)) {
                return $data[$domain];
            }
        }
        return [];
    }
}