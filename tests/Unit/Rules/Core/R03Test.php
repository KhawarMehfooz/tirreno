<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\R03;
use PHPUnit\Framework\TestCase;

final class R03Test extends TestCase {
    public function testItMatchesWhenPhoneIsInBlacklist(): void {
        $params = [
            'lp_fraud_detected' => true,
        ];

        $rule = new R03(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenPhoneIsNotInBlacklist(): void {
        $params = [
            'lp_fraud_detected' => false,
        ];

        $rule = new R03(params: $params);

        $this->assertFalse($rule->execute());
    }
}
