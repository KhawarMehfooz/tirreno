<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Grid;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Grid\TestGridQuery;

/**
 * Unit tests for Tirreno\Models\Grid\Base\Query::injectIdQuery().
 */
final class BaseQueryInjectIdQueryTest extends TestCase {
    public function testInjectIdQueryReturnsEmptyStringWhenIdsAreNull(): void {
        $query = new TestGridQuery();

        $params = [];

        $this->assertSame(
            '',
            $query->exposeInjectIdQuery(
                'event.id',
                $params
            )
        );

        $this->assertSame(
            [],
            $params
        );
    }

    public function testInjectIdQueryReturnsEmptyStringWhenIdsAreEmpty(): void {
        $query = new TestGridQuery();

        $query->setIds(
            '',
            [],
            1
        );

        $params = [];

        $this->assertSame(
            '',
            $query->exposeInjectIdQuery(
                'event.id',
                $params
            )
        );

        $this->assertSame(
            [],
            $params
        );
    }

    public function testInjectIdQueryReturnsQueryAndAddsParameters(): void {
        $query = new TestGridQuery();

        $query->setIds(
            ':id_1, :id_2',
            [
                ':id_1' => 10,
                ':id_2' => 20,
            ],
            1
        );

        $params = [];

        $this->assertSame(
            ' AND event.id IN (:id_1, :id_2)',
            $query->exposeInjectIdQuery(
                'event.id',
                $params
            )
        );

        $this->assertSame(
            [
                ':id_1' => 10,
                ':id_2' => 20,
            ],
            $params
        );
    }

    public function testInjectIdQueryDoesNotOverwriteExistingParameters(): void {
        $query = new TestGridQuery();

        $query->setIds(
            ':id_1, :id_2',
            [
                ':id_1' => 10,
                ':id_2' => 20,
            ],
            1
        );

        $params = [
            ':id_1' => 999,
            ':id_2' => 888,
        ];

        $this->assertSame(
            ' AND event.id IN (:id_1, :id_2)',
            $query->exposeInjectIdQuery(
                'event.id',
                $params
            )
        );

        $this->assertSame(
            [
                ':id_1' => 999,
                ':id_2' => 888,
            ],
            $params
        );
    }

    public function testInjectIdQueryAddsOnlyMissingParameters(): void {
        $query = new TestGridQuery();

        $query->setIds(
            ':id_1, :id_2',
            [
                ':id_1' => 10,
                ':id_2' => 20,
            ],
            1
        );

        $params = [
            ':id_1' => 999,
        ];

        $this->assertSame(
            ' AND event.id IN (:id_1, :id_2)',
            $query->exposeInjectIdQuery(
                'event.id',
                $params
            )
        );

        $this->assertSame(
            [
                ':id_1' => 999,
                ':id_2' => 20,
            ],
            $params
        );
    }

    public function testInjectIdQueryReplacesNullParameter(): void {
        $query = new TestGridQuery();

        $query->setIds(
            ':id',
            [
                ':id' => 10,
            ],
            1
        );

        $params = [
            ':id' => null,
        ];

        $this->assertSame(
            ' AND event.id IN (:id)',
            $query->exposeInjectIdQuery(
                'event.id',
                $params
            )
        );

        $this->assertSame(
            [
                ':id' => 10,
            ],
            $params
        );
    }
}
