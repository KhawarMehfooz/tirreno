<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Query;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Query\TestQuery;

/**
 * Unit tests for Tirreno\Models\Query\Base::find().
 */
final class BaseQueryFindTest extends TestCase {
    public function testFindBuildsSimpleQuery(): void {
        $query = new TestQuery(10);

        $query->find('id=1');

        $this->assertSame(
            'SELECT event.id AS id, event.key AS key, event.ip AS ip, event.fraud AS fraud, event.lastseen AS lastseen, event.deleted_at AS deleted_at, event.active AS active FROM event WHERE event.key = :key AND event.id::text = :val_1',
            $query->lastQuery
        );

        $this->assertSame(
            [
                ':key' => 10,
                ':val_1' => '1',
            ],
            $query->lastParams
        );
    }

    public function testFindAppliesSelector(): void {
        $query = new TestQuery(10);

        $query->find('id>100, sort=-lastseen, limit=20');

        $this->assertSame(
            'SELECT event.id AS id, event.key AS key, event.ip AS ip, event.fraud AS fraud, event.lastseen AS lastseen, event.deleted_at AS deleted_at, event.active AS active FROM event WHERE event.key = :key AND event.id::text > :val_1 ORDER BY event.lastseen DESC LIMIT 20',
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
}
