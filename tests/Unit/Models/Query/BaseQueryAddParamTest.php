<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Query;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Query\TestQuery;

/**
 * Unit tests for Tirreno\Models\Query\Base::addParam().
 */
final class BaseQueryAddParamTest extends TestCase {
    public function testAddParamAddsInteger(): void {
        $query = new TestQuery(10);

        $placeholder = $query->addParam(123);

        $this->assertSame(
            ':val_1',
            $placeholder
        );

        $query->get();

        $this->assertSame(
            [
                ':key' => 10,
                ':val_1' => 123,
            ],
            $query->lastParams
        );
    }

    public function testAddParamAddsString(): void {
        $query = new TestQuery(10);

        $placeholder = $query->addParam('hello');

        $this->assertSame(
            ':val_1',
            $placeholder
        );

        $query->get();

        $this->assertSame(
            [
                ':key' => 10,
                ':val_1' => 'hello',
            ],
            $query->lastParams
        );
    }

    public function testAddParamAddsFloat(): void {
        $query = new TestQuery(10);

        $placeholder = $query->addParam(12.5);

        $this->assertSame(
            ':val_1',
            $placeholder
        );

        $query->get();

        $this->assertSame(
            [
                ':key' => 10,
                ':val_1' => 12.5,
            ],
            $query->lastParams
        );
    }

    public function testAddParamAddsArray(): void {
        $query = new TestQuery(10);

        $placeholder = $query->addParam(
            [1, 2, 3]
        );

        $this->assertSame(
            '(:val_1, :val_2, :val_3)',
            $placeholder
        );

        $query->get();

        $this->assertSame(
            [
                ':key' => 10,
                ':val_1' => 1,
                ':val_2' => 2,
                ':val_3' => 3,
            ],
            $query->lastParams
        );
    }

    public function testAddParamAddsBetweenArray(): void {
        $query = new TestQuery(10);

        $placeholder = $query->addParam(
            [100, 200],
            true
        );

        $this->assertSame(
            ':val_1 AND :val_2',
            $placeholder
        );

        $query->get();

        $this->assertSame(
            [
                ':key' => 10,
                ':val_1' => 100,
                ':val_2' => 200,
            ],
            $query->lastParams
        );
    }
}
