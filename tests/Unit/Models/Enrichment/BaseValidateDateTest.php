<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Enrichment\Base;

use Tirreno\Models\Enrichment\Base;
use PHPUnit\Framework\TestCase;

class BaseValidateDateTest extends TestCase {
    private Base $model;

    protected function setUp(): void {
        parent::setUp();

        $this->model = new Base();
    }

    public function testReturnsTrueForValidDate(): void {
        $this->assertTrue($this->model->validateDate('2024-02-29'));
    }

    public function testReturnsFalseForInvalidCalendarDate(): void {
        $this->assertFalse($this->model->validateDate('2023-02-29'));
    }

    public function testReturnsFalseForWrongFormat(): void {
        $this->assertFalse($this->model->validateDate('29-02-2024'));
    }

    public function testSupportsCustomFormat(): void {
        $this->assertTrue(
            $this->model->validateDate('29.02.2024', 'd.m.Y')
        );
    }
}
