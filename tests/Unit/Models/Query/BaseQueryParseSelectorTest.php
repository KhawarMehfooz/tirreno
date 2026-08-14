<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Query;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Query\TestQuery;

/**
 * Unit tests for Tirreno\Models\Query\Base::parseSelector().
 */
final class BaseQueryParseSelectorTest extends TestCase {
    public function testParseSelectorAppliesLimit(): void {
        $query = new TestQuery(10);

        $query->exposeParseSelector('limit=25');

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key LIMIT 25',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testParseSelectorAppliesOffset(): void {
        $query = new TestQuery(10);

        $query->exposeParseSelector('start=40');

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key OFFSET 40',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testParseSelectorAppliesAscendingSort(): void {
        $query = new TestQuery(10);

        $query->exposeParseSelector('sort=lastseen');

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key ORDER BY event.lastseen ASC',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testParseSelectorAppliesDescendingSort(): void {
        $query = new TestQuery(10);

        $query->exposeParseSelector('sort=-lastseen');

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key ORDER BY event.lastseen DESC',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testParseSelectorIgnoresInvalidSort(): void {
        $query = new TestQuery(10);

        $query->exposeParseSelector('sort=***');

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testParseSelectorAddsSimpleCondition(): void {
        $query = new TestQuery(10);

        $query->exposeParseSelector('id=100');

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.id::text = :val_1',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testParseSelectorAddsMultipleOrConditions(): void {
        $query = new TestQuery(10);

        $query->exposeParseSelector('id=100|200');

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND (event.id::text = :val_1 OR event.id::text = :val_2)',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testParseSelectorCanCombineEverything(): void {
        $query = new TestQuery(10);

        $query->exposeParseSelector(
            'id>100, ip=10|20|30, sort=-lastseen, limit=20, start=40'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND (event.id::text > :val_1 AND (event.ip::text = :val_2 OR event.ip::text = :val_3 OR event.ip::text = :val_4)) ORDER BY event.lastseen DESC LIMIT 20 OFFSET 40',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }
}
