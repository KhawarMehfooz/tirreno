<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\I11;
use PHPUnit\Framework\TestCase;

final class I11Test extends TestCase {
    public function testItMatchesWhenAllIpsBelongToSingleNetwork(): void {
        $params = [
            'eip_unique_cidrs' => 1,
        ];

        $rule = new I11(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpsBelongToMultipleNetworks(): void {
        $params = [
            'eip_unique_cidrs' => 2,
        ];

        $rule = new I11(params: $params);

        $this->assertFalse($rule->execute());
    }
}
