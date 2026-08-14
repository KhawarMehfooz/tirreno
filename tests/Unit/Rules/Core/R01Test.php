<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\R01;
use PHPUnit\Framework\TestCase;

final class R01Test extends TestCase {
    public function testItMatchesWhenIpIsInBlacklist(): void {
        $params = [
            'eip_has_fraud' => true,
        ];

        $rule = new R01(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpIsNotInBlacklist(): void {
        $params = [
            'eip_has_fraud' => false,
        ];

        $rule = new R01(params: $params);

        $this->assertFalse($rule->execute());
    }
}
