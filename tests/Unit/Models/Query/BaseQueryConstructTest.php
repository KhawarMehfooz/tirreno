<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Query;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Query\TestQuery;

/**
 * Unit tests for Tirreno\Models\Query\Base::__construct().
 *
 * Covered:
 * - stores key
 * - initializes default WHERE clause
 * - initializes default params
 * - builds fields map
 */
final class BaseQueryConstructTest extends TestCase {
    public function testConstructStoresKey(): void {
        $query = new TestQuery(10);

        $this->assertSame(
            10,
            $query->exposeKey()
        );
    }

    public function testConstructInitializesDefaultWhereClause(): void {
        $query = new TestQuery(10);

        $actual = $query->exposeApplyFilters(
            'SELECT event.id'
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $actual
        );
    }

    public function testConstructInitializesDefaultParams(): void {
        $query = new TestQuery(10);

        $query->get();

        $this->assertSame(
            [
                ':key' => 10,
            ],
            $query->lastParams
        );
    }

    public function testConstructBuildsFieldsMap(): void {
        $query = new TestQuery(10);

        $this->assertSame(
            [
                'id' => 'event.id',
                'key' => 'event.key',
                'ip' => 'event.ip',
                'fraud' => 'event.fraud',
                'lastseen' => 'event.lastseen',
                'deleted_at' => 'event.deleted_at',
                'active' => 'event.active',
            ],
            $query->getFieldsMap()
        );
    }
}
