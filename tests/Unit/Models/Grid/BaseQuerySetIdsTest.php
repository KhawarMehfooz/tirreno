<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Grid;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Grid\TestGridQuery;

/**
 * Unit tests for Tirreno\Models\Grid\Base\Query::setIds().
 */
final class BaseQuerySetIdsTest extends TestCase {
    public function testSetIdsStoresNullIds(): void {
        $query = new TestGridQuery();

        $query->setIds(
            null,
            [],
            123
        );

        $this->assertNull(
            $query->exposeIds()
        );

        $this->assertSame(
            [],
            $query->exposeIdsParams()
        );

        $this->assertNull(
            $query->exposeItemKey()
        );

        $this->assertNull(
            $query->exposeItemId()
        );

        $this->assertSame(
            123,
            $query->exposeApiKey()
        );
    }

    public function testSetIdsStoresIdsWithoutParameters(): void {
        $query = new TestGridQuery();

        $query->setIds(
            ':id_1, :id_2',
            [],
            321
        );

        $this->assertSame(
            ':id_1, :id_2',
            $query->exposeIds()
        );

        $this->assertSame(
            [],
            $query->exposeIdsParams()
        );

        $this->assertNull(
            $query->exposeItemKey()
        );

        $this->assertNull(
            $query->exposeItemId()
        );

        $this->assertSame(
            321,
            $query->exposeApiKey()
        );
    }

    public function testSetIdsStoresParameters(): void {
        $query = new TestGridQuery();

        $query->setIds(
            ':id_1, :id_2',
            [
                ':id_1' => 10,
                ':id_2' => 20,
            ],
            456
        );

        $this->assertSame(
            ':id_1, :id_2',
            $query->exposeIds()
        );

        $this->assertSame(
            [
                ':id_1' => 10,
                ':id_2' => 20,
            ],
            $query->exposeIdsParams()
        );

        $this->assertSame(
            ':id_1',
            $query->exposeItemKey()
        );

        $this->assertSame(
            10,
            $query->exposeItemId()
        );

        $this->assertSame(
            456,
            $query->exposeApiKey()
        );
    }
}
