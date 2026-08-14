<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Query;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Query\TestQuery;

/**
 * Unit tests for Tirreno\Models\Query\Base::groupBy().
 */
final class BaseQueryGroupByTest extends TestCase {
    public function testGroupByAddsColumn(): void {
        $query = new TestQuery(10);

        $query->groupBy('event.id');

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key GROUP BY event.id',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testGroupByResolvesAlias(): void {
        $query = new TestQuery(10);

        $query->groupBy('id');

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key GROUP BY event.id',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testGroupByIgnoresInvalidColumn(): void {
        $query = new TestQuery(10);

        $query->groupBy('unknown');

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testGroupByReturnsSameInstance(): void {
        $query = new TestQuery(10);

        $this->assertSame(
            $query,
            $query->groupBy('event.id')
        );
    }
}
