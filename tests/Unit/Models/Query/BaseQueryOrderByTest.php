<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Query;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Query\TestQuery;

/**
 * Unit tests for Tirreno\Models\Query\Base::orderBy().
 */
final class BaseQueryOrderByTest extends TestCase {
    public function testOrderByAddsAscendingOrder(): void {
        $query = new TestQuery(10);

        $query->orderBy(
            'event.id',
            'ASC'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key ORDER BY event.id ASC',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testOrderByAddsDescendingOrder(): void {
        $query = new TestQuery(10);

        $query->orderBy(
            'event.id',
            'DESC'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key ORDER BY event.id DESC',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testOrderByResolvesAlias(): void {
        $query = new TestQuery(10);

        $query->orderBy(
            'id',
            'ASC'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key ORDER BY event.id ASC',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testOrderByIgnoresInvalidColumn(): void {
        $query = new TestQuery(10);

        $query->orderBy(
            'unknown',
            'ASC'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testOrderByIgnoresInvalidDirection(): void {
        $query = new TestQuery(10);

        $query->orderBy(
            'event.id',
            'INVALID'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testOrderByReturnsSameInstance(): void {
        $query = new TestQuery(10);

        $this->assertSame(
            $query,
            $query->orderBy(
                'event.id',
                'ASC'
            )
        );
    }
}
