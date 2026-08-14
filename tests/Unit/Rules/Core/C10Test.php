<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C10;
use PHPUnit\Framework\TestCase;

final class C10Test extends TestCase {
    public function testItMatchesWhenIpCountryIsRomania(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_ROMANIA;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C10(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotRomania(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_ROMANIA;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C10(params: $params);

        $this->assertFalse($rule->execute());
    }
}
