<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Enrichment\Base;

use Tirreno\Models\Enrichment\Base;
use PHPUnit\Framework\TestCase;

class BaseValidateDatesTest extends TestCase {
    private Base $model;

    protected function setUp(): void {
        parent::setUp();

        $this->model = new Base();
    }

    public function testReturnsTrueForValidDates(): void {
        $this->assertTrue(
            $this->model->validateDates([
                '2024-01-01',
                '2024-12-31',
            ])
        );
    }

    public function testIgnoresNullValues(): void {
        $this->assertTrue(
            $this->model->validateDates([
                '2024-01-01',
                null,
                '2024-12-31',
            ])
        );
    }

    public function testReturnsFalseWhenAnyDateIsInvalid(): void {
        $this->assertFalse(
            $this->model->validateDates([
                '2024-01-01',
                '2024-02-30',
            ])
        );
    }
}
