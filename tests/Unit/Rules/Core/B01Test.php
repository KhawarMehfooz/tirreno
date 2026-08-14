<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B01;
use PHPUnit\Framework\TestCase;

final class B01Test extends TestCase {
    public function testItMatchesWhenUserHasMoreThanThreeCountries(): void {
        $params = [
            'ea_total_country' => 4,
        ];

        $rule = new B01(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasExactlyThreeCountries(): void {
        $params = [
            'ea_total_country' => 3,
        ];

        $rule = new B01(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasLessThanThreeCountries(): void {
        $params = [
            'ea_total_country' => 2,
        ];

        $rule = new B01(params: $params);

        $this->assertFalse($rule->execute());
    }
}
