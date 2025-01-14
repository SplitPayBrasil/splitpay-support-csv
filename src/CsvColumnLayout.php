<?php

declare(strict_types=1);

namespace Splitpay\Support\Csv;

use Splitpay\Support\Csv\Contract\CsvColumnLayoutInterface;

class CsvColumnLayout implements CsvColumnLayoutInterface
{
    /**
     * @param string $name The column name
     * @param string $type The column type, default 'string'
     * @param string|null $alias The alias replaces the column name when generated csv
     * @param callable[]|null $filters Filters are called before csv generation. Eg.: ['trim', 'strtolower']
     */
    public function __construct(
        private string $name,
        private string $type = 'string',
        private ?string $alias = null,
        private ?array $filters = []
    ) {
    }

    public function applyFilters(mixed $value): mixed
    {
        foreach ($this->filters as $filter) {
            $value  =   filter_var($value, FILTER_CALLBACK, ['options' => $filter ]);
        }

        return $value;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /** @inheritDoc */
    public function getFilters(): array
    {
        return $this->filters;
    }

    public function addFilter(callable $filter): static
    {
        if (!in_array($filter, $this->filters)) {
            $this->filters[]    =   $filter;
        }

        return $this;
    }

    public function removeFilter(callable $filter): static
    {
        $key = array_search($filter, $this->filters);
        if ($key !== false) {
            array_splice($this->filters, $key);
        }

        return $this;
    }
}
