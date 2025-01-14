<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Splitpay\Support\Csv\CsvColumnLayout;
use Splitpay\Support\Csv\CsvLayout;
use Splitpay\Support\Csv\CsvParser;

class CsvParserTest extends TestCase
{
    public function testMethodParseFromArrayExists():void
    {
        $this->assertTrue(method_exists(CsvParser::class, 'parseFromArray'));
    }

    public function testMethodParseFromArrayReturnErrorWhenDifferentStructureLayoutPassed(): void
    {
        $layout =   new CsvLayout([
            new CsvColumnLayout(name: 'User', type: 'string'),
            new CsvColumnLayout(name: 'Email', type: 'string')
        ]);

        $parser = new CsvParser($layout);

        $array  =   [
            0 => ['Name' => 'Esdras', 'Age' => 36],
            1 => ['Name' => 'Rebeca', 'Age' => 25]
        ];

        $this->expectException(\Exception::class);
        $parser->parseFromArray($array);
    }

    public function testMethodParseFromArrayReturnCurrectCsvExpected(): void
    {
        $layout =   new CsvLayout([
            new CsvColumnLayout(name: 'User', type: 'string'),
            new CsvColumnLayout(name: 'Email', type: 'string')
        ]);

        $parser = new CsvParser($layout);

        $array  =   [
            0 => ['User' => 'Esdras', 'Email' => 'esdras@splitpaybrasil.com.br'],
            1 => ['User' => 'Rebeca', 'Email' => 'rebeca@splitpaybrasil.com.br']
        ];

        $result     =   $parser->parseFromArray($array);
        $expected   =   '"User";"Email"'. PHP_EOL
            .'"Esdras";"esdras@splitpaybrasil.com.br"' . PHP_EOL
            .'"Rebeca";"rebeca@splitpaybrasil.com.br"';

        $this->assertEquals($expected, $result);
    }
}