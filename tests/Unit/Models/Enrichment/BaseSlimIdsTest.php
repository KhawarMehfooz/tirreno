<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Enrichment;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Enrichment\TestEnrichment;

final class BaseSlimIdsTest extends TestCase {
    public function testSlimIdsReturnsEmptyArray(): void {
        $enrichment = new TestEnrichment();

        $this->assertSame(
            [],
            $enrichment->slimIds([])
        );
    }

    public function testSlimIdsRemovesNullValues(): void {
        $enrichment = new TestEnrichment();

        $this->assertSame(
            [1, 2, 3],
            $enrichment->slimIds([1, null, 2, null, 3])
        );
    }

    public function testSlimIdsRemovesDuplicateValues(): void {
        $enrichment = new TestEnrichment();

        $this->assertSame(
            [5, 7, 9],
            $enrichment->slimIds([5, 7, 5, 9, 7])
        );
    }

    public function testSlimIdsRemovesNullsAndDuplicates(): void {
        $enrichment = new TestEnrichment();

        $this->assertSame(
            [3, 1, 2],
            $enrichment->slimIds([3, null, 1, 3, 2, null, 1])
        );
    }
}
