<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Grid\Base;

use Tirreno\Models\Grid\Base\Query;
use Base;
use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Grid\TestGridQuery;

final class BaseQueryApplyDateRangeTest extends TestCase {
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

    public function testApplyDateRangeAddsWhereClauseAndParams(): void {
        $this->f3->set('GET.dateFrom', '2026-02-01');
        $this->f3->set('GET.dateTo', '2026-02-28');

        tirreno('request')->resetPayloadCache();

        $query = new TestGridQuery();

        $sql = <<<'SQL'
SELECT *
FROM event_country
WHERE 1=1
%s
SQL;

        $params = [];

        $query->exposeApplyDateRange($sql, $params);

        $this->assertStringContainsString(
            'event_country.lastseen >= :start_time',
            $sql
        );

        $this->assertStringContainsString(
            'event_country.lastseen <= :end_time',
            $sql
        );

        $this->assertSame(
            '2026-02-01 00:00:00',
            $params[':start_time']
        );

        $this->assertSame(
            '2026-02-28 00:00:00',
            $params[':end_time']
        );
    }

    public function testApplyDateRangeDoesNothingWithoutDates(): void {
        tirreno('request')->resetPayloadCache();

        $query = new TestGridQuery();

        $sql = 'SELECT * FROM event_country WHERE 1=1%s';
        $params = [];

        $query->exposeApplyDateRange($sql, $params);

        $this->assertSame(
            'SELECT * FROM event_country WHERE 1=1%s',
            $sql
        );

        $this->assertSame(
            [],
            $params
        );
    }
}
