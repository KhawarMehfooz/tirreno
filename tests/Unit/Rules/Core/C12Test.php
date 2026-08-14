<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C12;
use PHPUnit\Framework\TestCase;

final class C12Test extends TestCase {
    public function testItMatchesWhenIpCountryIsInEurope(): void {
        $countryCodes = tirreno('constants')->COUNTRY_CODES_EUROPE;

        $params = [
            'eip_country_id' => [$countryCodes[0]],
        ];

        $rule = new C12(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenAnyIpCountryIsInEurope(): void {
        $countryCodes = tirreno('constants')->COUNTRY_CODES_EUROPE;

        $params = [
            'eip_country_id' => [999, $countryCodes[0]],
        ];

        $rule = new C12(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotInEurope(): void {
        $params = [
            'eip_country_id' => [999],
        ];

        $rule = new C12(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenNoIpCountriesAreInEurope(): void {
        $params = [
            'eip_country_id' => [998, 999],
        ];

        $rule = new C12(params: $params);

        $this->assertFalse($rule->execute());
    }
}
