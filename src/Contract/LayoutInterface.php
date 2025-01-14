<?php

declare(strict_types=1);

namespace Splitpay\Support\Csv\Contract;

interface LayoutInterface
{
    public function getHeaderLine(): string;

    public function getColumn(string $columnName): ColumnInterface;

    /**
     * @return array
     */
    public function getColumns(): array;

    public function addColumn(ColumnInterface $column): static;

    public function removeColumn(ColumnInterface $column): static;

    public function getColumnSeparator(): string;

    public function getLineSeparator(): string;

    /**
     * @return string[]
     */
    public function getQuotedTypes(): array;

    public function addQuotedType(string $quotedType): static;

    public function removeQuotedType(string $quotedType): static;
}