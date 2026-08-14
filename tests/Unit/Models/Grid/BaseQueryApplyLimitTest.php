<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Grid;

use Base;
use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Grid\TestGridQuery;

final class BaseQueryApplyLimitTest extends TestCase {
    private Base $f3;

    protected function setUp(): void {
        parent::setUp();

        $this->f3 = Base::instance();

        $this->f3->clear('REQUEST');
        $this->f3->clear('PARAMS');
        $this->f3->clear('GET');
        $this->f3->clear('POST');
        $this->f3->clear('BODY');
        $this->f3->clear('HEADERS');

        tirreno('request')->resetPayloadCache();
    }

    protected function tearDown(): void {
        tirreno('request')->resetPayloadCache();

        parent::tearDown();
    }

    public function testApplyLimitUsesDefaultZeroValuesWhenRequestIsMissing(): void {
        $query = new TestGridQuery();

        $sql = 'SELECT * FROM event';
        $params = [];

        $query->exposeApplyLimit($sql, $params);

        $this->assertSame(
            'SELECT * FROM event LIMIT :length OFFSET :start',
            $sql
        );

        $this->assertSame(
            [
                ':start' => 0,
                ':length' => 0,
            ],
            $params
        );
    }

    public function testApplyLimitAppendsLimitClause(): void {
        $this->f3->set('GET.start', '10');
        $this->f3->set('GET.length', '20');

        tirreno('request')->resetPayloadCache();

        $query = new TestGridQuery();

        $sql = 'SELECT * FROM event';
        $params = [];

        $query->exposeApplyLimit($sql, $params);

        $this->assertSame(
            'SELECT * FROM event LIMIT :length OFFSET :start',
            $sql
        );

        $this->assertSame(
            [
                ':start' => 10,
                ':length' => 20,
            ],
            $params
        );
    }

    public function testApplyLimitPreservesExistingParameters(): void {
        $this->f3->set('GET.start', '5');
        $this->f3->set('GET.length', '50');

        tirreno('request')->resetPayloadCache();

        $query = new TestGridQuery();

        $sql = 'SELECT * FROM event';
        $params = [
            ':api_key' => 100,
        ];

        $query->exposeApplyLimit($sql, $params);

        $this->assertSame(
            'SELECT * FROM event LIMIT :length OFFSET :start',
            $sql
        );

        $this->assertSame(
            [
                ':api_key' => 100,
                ':start' => 5,
                ':length' => 50,
            ],
            $params
        );
    }
}
