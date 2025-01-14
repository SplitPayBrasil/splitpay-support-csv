<?php

declare(strict_types=1);

namespace Splitpay\Support\Csv;

use RuntimeException;
use Splitpay\Support\Csv\Contract\ColumnInterface;
use Splitpay\Support\Csv\Contract\LayoutInterface;

class Parser
{
    public function __construct(
        private LayoutInterface $layout
    )
    {
    }

    public function parseFromArray(array $array): string
    {
        $this->arraySchemaValidate($array);
        $headerLine     =   $this->layout->getHeaderLine();
        $parsedLines    =   array_map([$this, 'parseLine'], $array);

        return implode(
            $this->layout->getLineSeparator(),
            array_merge([$headerLine], $parsedLines)
        );
    }

    public function parseFromJson(string $json): string
    {
        $array  =   json_decode($json, true);

        return $this->parseFromArray($array);
    }


    private function arraySchemaValidate(array $schema): void
    {
        $columns    =   $this->layout->getColumns();
        foreach($columns as $key => $column) {
            $this->columnValidate($column, $schema, $key);
        }
    }

    private function columnValidate(ColumnInterface $column, array $schema, ?int $key): void
    {
        $columnName     =   $column->getName();
        $columnType     =   $column->getType();

        foreach ($schema as $line) {
            if (!isset($line[$columnName]) && !isset($line[$key])) {
                throw new RuntimeException('Invalid schema');
            }

            $type   =   gettype($line[$columnName] ?? $line[$key]);
            if ($type !== $columnType) {
                throw new RuntimeException('Invalid schema');
            }
        }
    }

    private function parseLine(array $csvLine): string
    {
        $columns    =   [];
        foreach ($csvLine as $columnName => $columnValue) {
            $columnLayout   =   $this->layout->getColumn($columnName);
            $columns[]      =   $this->normalizeColumn($columnLayout, $columnValue);
        }

        return implode($this->layout->getColumnSeparator(), $columns);
    }

    private function normalizeColumn(ColumnInterface $column, mixed $value): string
    {
        $value  =   $column->applyFilters($value);
        if (in_array($column->getType(), $this->layout->getQuotedTypes())) {
            $value = sprintf('"%s"', $value);
        }

        return (string) $value;
    }

}