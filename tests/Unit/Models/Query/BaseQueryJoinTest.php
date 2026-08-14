<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Query;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Query\TestIpQuery;
use Tests\Support\Models\Query\TestQuery;

/**
 * Unit tests for Tirreno\Models\Query\Base::join().
 */
final class BaseQueryJoinTest extends TestCase {
    public function testJoinIgnoresSelfJoin(): void {
        $query = new TestQuery(10);

        $query->join('event');

        $this->assertSame(
            $query,
            $query->join('event')
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testJoinIgnoresUnknownTable(): void {
        $query = new TestQuery(10);

        $this->assertSame(
            $query,
            $query->join('unknown_table')
        );

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testJoinIgnoresJoinFromEventTable(): void {
        $query = new TestQuery(10);

        $query->join('event_ip');

        $this->assertSame(
            'SELECT event.id FROM event WHERE event.key = :key',
            $query->exposeApplyFilters('SELECT event.id')
        );
    }

    public function testJoinAddsFields(): void {
        $query = new TestIpQuery(10);

        $query->join('event_account');

        $fields = $query->getFields();

        $this->assertArrayHasKey('event_account.id', $fields);
        $this->assertArrayHasKey('event_email.id', $fields);
        $this->assertArrayHasKey('event_phone.id', $fields);

        $this->assertSame('user_id', $fields['event_account.id']);
        $this->assertSame('email_id', $fields['event_email.id']);
        $this->assertSame('phone_id', $fields['event_phone.id']);
    }

    public function testJoinAddsFieldsMap(): void {
        $query = new TestIpQuery(10);

        $query->join('event_account');

        $fieldsMap = $query->getFieldsMap();

        $this->assertSame('event_account.id', $fieldsMap['user_id']);
        $this->assertSame('event_email.id', $fieldsMap['email_id']);
        $this->assertSame('event_phone.id', $fieldsMap['phone_id']);
    }

    public function testJoinAddsJoinClause(): void {
        $query = new TestIpQuery(10);

        $query->join('event_account');

        $this->assertSame(
            'SELECT event_ip.id FROM event_ip '
            . 'LEFT JOIN event_account ON event.account = event_account.id '
            . 'LEFT JOIN event ON event_ip.id = event.ip '
            . 'WHERE event_ip.key = :key',
            $query->exposeApplyFilters('SELECT event_ip.id')
        );
    }

    public function testJoinIgnoresUnknownTableForNonEventQuery(): void {
        $query = new TestIpQuery(10);

        $this->assertSame(
            $query,
            $query->join('unknown_table')
        );

        $this->assertSame(
            'SELECT event_ip.id FROM event_ip WHERE event_ip.key = :key',
            $query->exposeApplyFilters('SELECT event_ip.id')
        );
    }
}
