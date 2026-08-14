<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B17;
use PHPUnit\Framework\TestCase;

final class B17Test extends TestCase {
    public function testItMatchesWhenUserHasSingleCountry(): void {
        $params = [
            'ea_total_country' => 1,
        ];

        $rule = new B17(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoCountries(): void {
        $params = [
            'ea_total_country' => 0,
        ];

        $rule = new B17(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasMultipleCountries(): void {
        $params = [
            'ea_total_country' => 2,
        ];

        $rule = new B17(params: $params);

        $this->assertFalse($rule->execute());
    }
}
