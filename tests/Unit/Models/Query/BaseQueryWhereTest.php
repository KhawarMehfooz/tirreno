<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Query;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Query\TestQuery;

/**
 * Unit tests for Tirreno\Models\Query::where(),
 * ::andWhere() and ::orWhere().
 */
final class BaseQueryWhereTest extends TestCase {
    public function testWhereAddsAndCondition(): void {
        $query = new TestQuery(10);

        $query->where(
            'event.id',
            '=',
            123
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.id::int = :val_1',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testAndWhereAddsAndCondition(): void {
        $query = new TestQuery(10);

        $query->andWhere(
            'event.id',
            '=',
            123
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.id::int = :val_1',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereAddsBetweenCondition(): void {
        $query = new TestQuery(10);

        $query->where(
            'event.id',
            'BETWEEN',
            [1000, 2000],
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.id BETWEEN :val_1 AND :val_2',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testOrWhereAddsOrCondition(): void {
        $query = new TestQuery(10);

        $query->where(
            'event.id',
            '=',
            1
        );

        $query->orWhere(
            'event.key',
            '=',
            2
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND (event.id::int = :val_1 OR event.key::int = :val_2)',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testFirstOrWhereIsConvertedToAnd(): void {
        $query = new TestQuery(10);

        $query->orWhere(
            'event.id',
            '=',
            123
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.id::int = :val_1',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereIgnoresInvalidCondition(): void {
        $query = new TestQuery(10);

        $query->where(
            'unknown',
            '=',
            123
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereConvertsNullToIsNull(): void {
        $query = new TestQuery(10);

        $query->where(
            'event.deleted_at',
            '=',
            'NULL'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.deleted_at IS NULL',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereConvertsNotNullToIsNotNull(): void {
        $query = new TestQuery(10);

        $query->where(
            'event.deleted_at',
            '!=',
            'NULL'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.deleted_at IS NOT NULL',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereConvertsTrueToIsTrue(): void {
        $query = new TestQuery(10);

        $query->where(
            'event.active',
            '=',
            'TRUE'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.active IS TRUE',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereConvertsNotTrueToIsNotTrue(): void {
        $query = new TestQuery(10);

        $query->where(
            'event.active',
            '!=',
            'TRUE'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.active IS NOT TRUE',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereConvertsFalseToIsFalse(): void {
        $query = new TestQuery(10);

        $query->where(
            'event.active',
            '=',
            'FALSE'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.active IS FALSE',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereConvertsNotFalseToIsNotFalse(): void {
        $query = new TestQuery(10);

        $query->where(
            'event.active',
            '!=',
            'FALSE'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.active IS NOT FALSE',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }


    public function testWhereUsesNumericCastForFloat(): void {
        $query = new TestQuery(10);

        $query->where(
            'id',
            '=',
            12.5
        );

        $this->assertSame(
            'SELECT event_ip.id FROM event WHERE event.key = :key AND event.id::numeric = :val_1',
            $query->exposeApplyFilters('SELECT event_ip.id')
        );
    }

    public function testWhereAllowsNotUnaryOperator(): void {
        $query = new TestQuery(10);

        $query->where(
            'event.active',
            'NOT'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND NOT event.active',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereAcceptsLowercaseIsNull(): void {
        $query = new TestQuery(10);

        $query->where(
            'event.deleted_at',
            'is null'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.deleted_at IS NULL',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereAllowsIsUnknownUnaryOperator(): void {
        $query = new TestQuery(10);

        $query->where(
            'event.active',
            'IS UNKNOWN'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.active IS UNKNOWN',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testWhereAllowsIsNotUnknownUnaryOperator(): void {
        $query = new TestQuery(10);

        $query->where(
            'event.active',
            'is not unknown'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key AND event.active IS NOT UNKNOWN',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }
}
