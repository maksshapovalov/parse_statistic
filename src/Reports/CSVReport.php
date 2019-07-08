<?php


namespace Parser\Reports;


class CSVReport implements IReport
{
    private $dirPath;

    public function __construct($rootPath)
    {
        $this->dirPath = $rootPath . 'resources/';
    }

    public function getParseReport(array $data): string
    {
        $fileName = "analyze_" . time() . ".csv";
        $result = '';
        if (!$fileHandler = fopen($this->dirPath . $fileName, 'w')) {
            return $result;
        }
        foreach ($data as $url => $rows) {
            foreach ($rows as $row) {
                fputcsv($fileHandler, [$url, $row]);
            }
        }
        $result = "\r\nCSV file saved in resources/$fileName\r\n";
        fclose($fileHandler);
        return $result;
    }

    public function getDomainReport(array $data): string
    {
        $fileName = "domain_analyze_" . time() . ".csv";
        $result = '';
        if (!$fileHandler = fopen($this->dirPath . $fileName, 'w')) {
            return $result;
        }
        foreach ($data as $parentUrl => $children) {
            foreach ($children as $childrenUrl => $rows) {
                foreach ($rows as $row) {
                    fputcsv($fileHandler, [$parentUrl, $childrenUrl, $row]);
                }
            }
        }
        $result = "\r\nCSV file saved in resources/$fileName\r\n";
        fclose($fileHandler);
        return $result;
    }
}