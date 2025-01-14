<?php

declare(strict_types=1);

namespace Splitpay\Support\Csv;

use Splitpay\Support\Csv\Contract\CsvLayoutInterface;
use Splitpay\Support\Csv\Contract\CsvColumnLayoutInterface;

class CsvLayout implements CsvLayoutInterface
{
    /**
     * @param CsvColumnLayoutInterface[] $columns
     * @param string $columnSeparator
     * @param string $lineSeparator
     * @param string[] $quotedTypes
     */
    public function __construct(
        private array $columns          =   [],
        private string $columnSeparator =   ';',
        private string $lineSeparator   =   PHP_EOL,
        private array $quotedTypes      =   ['string'],
    ) {
    }

    public function getHeaderLine(): string
    {
        $headers    =   $this->getHeaders();

        return $this->quote(
            implode(
                $this->quote($this->columnSeparator),
                $headers
            )
        );
    }

    public function getColumn(string $columnName): CsvColumnLayoutInterface
    {
        return current(
            array_filter(
                $this->columns,
                fn ($c) => $c->getName() === $columnName
            )
        );
    }

    /**
     * @return CsvColumnLayout[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function addColumn(CsvColumnLayoutInterface $column): static
    {
        if (! in_array($column, $this->columns)) {
            $this->columns[]    =   $column;
        }

        return $this;
    }

    public function removeColumn(CsvColumnLayoutInterface $column): static
    {
        $key    =   array_search($column, $this->columns);
        if ($key !== false) {
            array_splice($this->columns, $key);
        }

        return $this;
    }

    public function getColumnSeparator(): string
    {
        return $this->columnSeparator;
    }

    public function getLineSeparator(): string
    {
        return $this->lineSeparator;
    }

    /**
     * @return string[]
     */
    public function getQuotedTypes(): array
    {
        return $this->quotedTypes;
    }

    public function addQuotedType(string $quotedType): static
    {
        if (! in_array($quotedType, $this->quotedTypes)) {
            $this->quotedTypes[]    =   $quotedType;
        }

        return $this;
    }

    public function removeQuotedType(string $quotedType): static
    {
        $key    =   array_search($quotedType, $this->quotedTypes);
        if ($key !== false) {
            array_splice($this->quotedTypes, $key);
        }

        return $this;
    }

    private function getHeaders(): array
    {
        return array_map(
            fn(CsvColumnLayoutInterface $c) => $c->getAlias()?? $c->getName(),
            $this->columns
        );
    }

    private function quote(string $value): string
    {
        return sprintf('"%s"', $value);
    }
}
