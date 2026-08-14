<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Query;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Query\TestQuery;

/**
 * Unit tests for Tirreno\Models\Query\Base::count().
 */
final class BaseQueryCountTest extends TestCase {
    public function testCountBuildsSimpleQuery(): void {
        $query = new TestQuery(10);

        $query->count(null);

        $this->assertSame(
            'SELECT COUNT(*) FROM event WHERE event.key = :key',
            $query->lastQuery
        );

        $this->assertSame(
            [
                ':key' => 10,
            ],
            $query->lastParams
        );
    }

    public function testCountAppliesSelector(): void {
        $query = new TestQuery(10);

        $query->count('id>100, sort=-lastseen, limit=20, start=40');

        $this->assertSame(
            'SELECT COUNT(*) FROM event WHERE event.key = :key AND event.id::text > :val_1 ORDER BY event.lastseen DESC LIMIT 20 OFFSET 40',
            $query->lastQuery
        );

        $this->assertSame(
            [
                ':key' => 10,
                ':val_1' => '100',
            ],
            $query->lastParams
        );
    }

    public function testCountReturnsNullWhenQueryReturnsEmptyResult(): void {
        $query = new TestQuery(10);

        $this->assertNull(
            $query->count(null)
        );
    }
}
