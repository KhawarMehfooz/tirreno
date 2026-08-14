<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Grid;

use Base;
use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Grid\TestGridQuery;

/**
 * @covers \Tirreno\Models\Grid\Base\Query::applyOrder
 */
final class BaseQueryApplyOrderTest extends TestCase {
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

    public function testApplyOrderUsesDefaultOrderWhenRequestIsEmpty(): void {
        $query = new TestGridQuery();

        $sql = 'SELECT * FROM event';

        $query->exposeApplyOrder($sql);

        $this->assertSame(
            'SELECT * FROM event ORDER BY event.id ASC',
            $sql
        );
    }

    public function testApplyOrderUsesRequestOrderForAllowedColumns(): void {
        $this->f3->set('GET.columns', [
            ['data' => 'event.country'],
            ['data' => 'event.lastseen'],
        ]);

        $this->f3->set('GET.order', [
            [
                'column' => 1,
                'dir' => 'desc',
            ],
            [
                'column' => 0,
                'dir' => 'asc',
            ],
        ]);

        tirreno('request')->resetPayloadCache();

        $query = new TestGridQuery();

        $sql = 'SELECT * FROM event';

        $query->exposeApplyOrder($sql);

        $this->assertSame(
            'SELECT * FROM event ORDER BY event.lastseen DESC, event.country ASC',
            $sql
        );
    }

    public function testApplyOrderIgnoresDisallowedColumns(): void {
        $this->f3->set('GET.columns', [
            ['data' => 'event.password'],
        ]);

        $this->f3->set('GET.order', [
            [
                'column' => 0,
                'dir' => 'asc',
            ],
        ]);

        tirreno('request')->resetPayloadCache();

        $query = new TestGridQuery();

        $sql = 'SELECT * FROM event';

        $query->exposeApplyOrder($sql);

        $this->assertSame(
            'SELECT * FROM event ORDER BY event.id ASC',
            $sql
        );
    }

    public function testApplyOrderTreatsUnknownDirectionAsDesc(): void {
        $this->f3->set('GET.columns', [
            ['data' => 'event.country'],
        ]);

        $this->f3->set('GET.order', [
            [
                'column' => 0,
                'dir' => 'foobar',
            ],
        ]);

        tirreno('request')->resetPayloadCache();

        $query = new TestGridQuery();

        $sql = 'SELECT * FROM event';

        $query->exposeApplyOrder($sql);

        $this->assertSame(
            'SELECT * FROM event ORDER BY event.country DESC',
            $sql
        );
    }
}
