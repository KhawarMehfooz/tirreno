<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Query;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Query\TestQuery;

/**
 * Unit tests for Tirreno\Models\Query\Base::whereColumn().
 */
final class BaseQueryWhereColumnTest extends TestCase {
    public function testWhereColumnAddsCondition(): void {
        $query = new TestQuery(10);

        $query->whereColumn(
            'event.id',
            '=',
            'event.key'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.id = event.key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereColumnIgnoresInvalidLeftColumn(): void {
        $query = new TestQuery(10);

        $query->whereColumn(
            'invalid',
            '=',
            'event.key'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereColumnIgnoresInvalidRightColumn(): void {
        $query = new TestQuery(10);

        $query->whereColumn(
            'event.id',
            '=',
            'invalid'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereColumnIgnoresInvalidOperator(): void {
        $query = new TestQuery(10);

        $query->whereColumn(
            'event.id',
            '===',
            'event.key'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }
}
