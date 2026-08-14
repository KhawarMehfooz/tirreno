<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Enrichment;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Enrichment\TestEnrichment;

final class BaseQueryParamsTest extends TestCase {
    public function testQueryParamsReturnsEmptyArray(): void {
        $enrichment = new TestEnrichment();

        $this->assertSame(
            [
                ':id' => null,
                ':country' => null,
                ':comment' => null,
            ],
            $enrichment->queryParams()
        );
    }

    public function testQueryParamsReturnsAllProperties(): void {
        $enrichment = new TestEnrichment();

        $enrichment->id = 10;
        $enrichment->country = 'FR';

        $this->assertSame(
            [
                ':id' => 10,
                ':country' => 'FR',
                ':comment' => null,
            ],
            $enrichment->queryParams()
        );
    }
}
