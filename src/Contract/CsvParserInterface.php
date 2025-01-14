<?php

namespace Splitpay\Support\Csv\Contract;

declare(strict_types=1);

interface CsvParserInterface
{
    public function parseFromArray(array $array): string;

    public function parseFromJson(string $json): string;
}