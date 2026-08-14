<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\R02;
use PHPUnit\Framework\TestCase;

final class R02Test extends TestCase {
    public function testItMatchesWhenEmailIsInBlacklist(): void {
        $params = [
            'le_fraud_detected' => true,
        ];

        $rule = new R02(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailIsNotInBlacklist(): void {
        $params = [
            'le_fraud_detected' => false,
        ];

        $rule = new R02(params: $params);

        $this->assertFalse($rule->execute());
    }
}
