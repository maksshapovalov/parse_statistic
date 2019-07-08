<?php


namespace Parser\Savers;


interface ISaver
{
    public function save(array $data): string;
}