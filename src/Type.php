<?php

declare(strict_types=1);

namespace Splitpay\Support\Csv;

enum Type: string
{
    case Boolean        =   'boolean';
    case Integer        =   'integer';
    case Double         =   'double';
    case String         =   'string';
    case Array          =   'array';
    case Object         =   'object';
    case Resource       =   'resource';
    case NULL           =   'NULL';
    case Unknown        =   'unknown type';
    case ClosedResource =   'resource (closed)';
}
