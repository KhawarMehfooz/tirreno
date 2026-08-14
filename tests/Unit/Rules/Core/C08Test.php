<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C08;
use PHPUnit\Framework\TestCase;

final class C08Test extends TestCase {
    public function testItMatchesWhenIpCountryIsSouthAfrica(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_SOUTH_AFRICA;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C08(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotSouthAfrica(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_SOUTH_AFRICA;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C08(params: $params);

        $this->assertFalse($rule->execute());
    }
}
