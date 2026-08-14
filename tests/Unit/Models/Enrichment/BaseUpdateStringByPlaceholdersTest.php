<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Enrichment;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Enrichment\TestEnrichment;

final class BaseUpdateStringByPlaceholdersTest extends TestCase {
    public function testUpdateStringByPlaceholdersReturnsEmptyString(): void {
        $enrichment = new TestEnrichment();

        $this->assertSame(
            '',
            $enrichment->updateStringByPlaceholders([])
        );
    }

    public function testUpdateStringByPlaceholdersReturnsSingleAssignment(): void {
        $enrichment = new TestEnrichment();

        $this->assertSame(
            'id = :id',
            $enrichment->updateStringByPlaceholders([
                ':id',
            ])
        );
    }

    public function testUpdateStringByPlaceholdersReturnsMultipleAssignments(): void {
        $enrichment = new TestEnrichment();

        $this->assertSame(
            'id = :id, country = :country, comment = :comment',
            $enrichment->updateStringByPlaceholders([
                ':id',
                ':country',
                ':comment',
            ])
        );
    }
}
