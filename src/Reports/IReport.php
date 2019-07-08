<?php


namespace Parser\Reports;


interface IReport
{
    public function getParseReport(array $data): string;

    public function getDomainReport(array $data): string;
}