<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E13;
use PHPUnit\Framework\TestCase;

final class E13Test extends TestCase {
    public function testItMatchesWhenDomainIsLessThanNinetyDaysOld(): void {
        $params = [
            'ld_days_since_domain_creation' => 89,
        ];

        $rule = new E13(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainAgeIsUnknown(): void {
        $params = [
            'ld_days_since_domain_creation' => -1,
        ];

        $rule = new E13(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainIsNinetyDaysOld(): void {
        $params = [
            'ld_days_since_domain_creation' => 90,
        ];

        $rule = new E13(params: $params);

        $this->assertFalse($rule->execute());
    }
}
