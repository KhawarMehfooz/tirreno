<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Query;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Query\TestQuery;

/**
 * Unit tests for Tirreno\Models\Query\Base::limit()
 * and ::offset().
 */
final class BaseQueryLimitOffsetTest extends TestCase {
    public function testLimitAddsLimit(): void {
        $query = new TestQuery(10);

        $query->limit(25);

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key LIMIT 25',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testLimitIgnoresNegativeValue(): void {
        $query = new TestQuery(10);

        $query->limit(-1);

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testLimitReturnsSameInstance(): void {
        $query = new TestQuery(10);

        $this->assertSame(
            $query,
            $query->limit(10)
        );
    }

    public function testOffsetAddsOffset(): void {
        $query = new TestQuery(10);

        $query->offset(50);

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key OFFSET 50',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testOffsetIgnoresNegativeValue(): void {
        $query = new TestQuery(10);

        $query->offset(-1);

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testOffsetReturnsSameInstance(): void {
        $query = new TestQuery(10);

        $this->assertSame(
            $query,
            $query->offset(10)
        );
    }

    public function testLimitAndOffsetCanBeCombined(): void {
        $query = new TestQuery(10);

        $query
            ->limit(20)
            ->offset(40);

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key LIMIT 20 OFFSET 40',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }
}
