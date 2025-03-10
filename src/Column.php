<?php

declare(strict_types=1);

namespace Splitpay\Support\Csv;

use Splitpay\Support\Csv\Contract\ColumnInterface;

class Column implements ColumnInterface
{
    /**
     * @param string $name The column name
     * @param Type|'boolean'|'integer'|'double'|'string'|'array'|'object'|'resource'|'NULL'|'unknown type'|'resource (closed)' $type The column type, default Type::String
     * @param string|null $alias The alias replaces the column name when generated csv
     * @param callable[]|null $filters Filters are called before csv generation. Eg.: ['trim', 'strtolower']
     * @param bool $nullable If FALSE this column can not be null. Default TRUE
     */
    public function __construct(
        private string $name,
        private Type|string $type = Type::String,
        private ?string $alias = null,
        private ?array $filters = [],
        private bool $nullable = true
    ) {
        if (is_string($type)) {
            $this->type = Type::from($type);
        }
    }

    public function applyFilters(mixed $value): mixed
    {
        foreach ($this->filters as $filter) {
            $value  =   call_user_func($filter, $value);
        }

        return $value;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type->value;
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

    public function isNullable(): bool
    {
        return $this->nullable;
    }
}
