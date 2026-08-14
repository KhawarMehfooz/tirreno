<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C02;
use PHPUnit\Framework\TestCase;

final class C02Test extends TestCase {
    public function testItMatchesWhenIpCountryIsIndia(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_INDIA;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C02(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotIndia(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_INDIA;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C02(params: $params);

        $this->assertFalse($rule->execute());
    }
}
