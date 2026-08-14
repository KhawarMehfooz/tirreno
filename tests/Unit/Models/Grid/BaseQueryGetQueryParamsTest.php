<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Grid;

use PHPUnit\Framework\TestCase;
use Tests\Support\Models\Grid\TestGridQuery;

/**
 * Unit tests for Tirreno\Models\Grid\Base\Query::getQueryParams().
 */
final class BaseQueryGetQueryParamsTest extends TestCase {
    public function testGetQueryParamsReturnsApiKey(): void {
        $query = new TestGridQuery();

        $query->setIds(
            null,
            [],
            123
        );

        $this->assertSame(
            [
                ':api_key' => 123,
            ],
            $query->exposeGetQueryParams()
        );
    }

    public function testGetQueryParamsReturnsNullApiKey(): void {
        $query = new TestGridQuery();

        $this->assertSame(
            [
                ':api_key' => null,
            ],
            $query->exposeGetQueryParams()
        );
    }
}
