<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Query;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Query\TestQuery;

/**
 * Unit tests for Tirreno\Models\Query\Base::get().
 */
final class BaseQueryGetTest extends TestCase {
    public function testGetBuildsSimpleSelect(): void {
        $query = new TestQuery(10);

        $result = $query->get();

        $this->assertSame([], $result->result);
        $this->assertSame(10, $result->key);

        $this->assertSame(
            'SELECT event.id AS id, event.key AS key, event.ip AS ip, event.fraud AS fraud, event.lastseen AS lastseen, event.deleted_at AS deleted_at, event.active AS active FROM event WHERE event.key = :key',
            $query->lastQuery
        );

        $this->assertSame(
            [
                ':key' => 10,
            ],
            $query->lastParams
        );
    }

    public function testGetAppliesFilters(): void {
        $query = new TestQuery(10);

        $query
            ->where('id', '>', 100)
            ->orderBy('id', 'DESC')
            ->limit(20)
            ->offset(40);

        $query->get();

        $this->assertSame(
            'SELECT event.id AS id, event.key AS key, event.ip AS ip, event.fraud AS fraud, event.lastseen AS lastseen, event.deleted_at AS deleted_at, event.active AS active FROM event WHERE event.key = :key AND event.id::int > :val_1 ORDER BY event.id DESC LIMIT 20 OFFSET 40',
            $query->lastQuery
        );

        $this->assertSame(
            [
                ':key' => 10,
                ':val_1' => 100,
            ],
            $query->lastParams
        );
    }

    public function testGetPassesParametersToExecQuery(): void {
        $query = new TestQuery(10);

        $query
            ->where('id', '=', 123)
            ->get();

        $this->assertSame(
            [
                ':key' => 10,
                ':val_1' => 123,
            ],
            $query->lastParams
        );
    }
}
