<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E02;
use PHPUnit\Framework\TestCase;

final class E02Test extends TestCase {
    public function testItMatchesWhenDomainIsNewEmailHasNoBreachesAndLocalPartIsPresent(): void {
        $params = [
            'ld_days_since_domain_creation' => 10,
            'le_has_no_data_breaches' => true,
            'le_local_part_len' => 5,
        ];

        $rule = new E02(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainAgeIsUnknown(): void {
        $params = [
            'ld_days_since_domain_creation' => -1,
            'le_has_no_data_breaches' => true,
            'le_local_part_len' => 5,
        ];

        $rule = new E02(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenDomainIsThirtyDaysOld(): void {
        $params = [
            'ld_days_since_domain_creation' => 30,
            'le_has_no_data_breaches' => true,
            'le_local_part_len' => 5,
        ];

        $rule = new E02(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailHasDataBreaches(): void {
        $params = [
            'ld_days_since_domain_creation' => 10,
            'le_has_no_data_breaches' => false,
            'le_local_part_len' => 5,
        ];

        $rule = new E02(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenLocalPartIsEmpty(): void {
        $params = [
            'ld_days_since_domain_creation' => 10,
            'le_has_no_data_breaches' => true,
            'le_local_part_len' => 0,
        ];

        $rule = new E02(params: $params);

        $this->assertFalse($rule->execute());
    }
}
