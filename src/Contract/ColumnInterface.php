<?php

declare(strict_types=1);

namespace Splitpay\Support\Csv\Contract;

interface ColumnInterface
{
    public function getName(): string;

    public function getAlias(): ?string;

    public function getType(): string;

    /**
     * @return callable[]
     */
    public function getFilters(): array;

    public function addFilter(callable $filter);

    public function removeFilter(callable $filter);

    public function applyFilters(mixed $value);
}