<?php

declare(strict_types=1);

namespace Splitpay\Support\Csv\Contract;

interface CsvLayoutInterface
{
    public function getHeaderLine(): string;

    public function getColumn(string $columnName): CsvColumnLayoutInterface;

    /**
     * @return array
     */
    public function getColumns(): array;

    public function addColumn(CsvColumnLayoutInterface $column): static;

    public function removeColumn(CsvColumnLayoutInterface $column): static;

    public function getColumnSeparator(): string;

    public function getLineSeparator(): string;

    /**
     * @return string[]
     */
    public function getQuotedTypes(): array;

    public function addQuotedType(string $quotedType): static;

    public function removeQuotedType(string $quotedType): static;
}