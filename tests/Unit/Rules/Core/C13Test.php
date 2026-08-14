<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C13;
use PHPUnit\Framework\TestCase;

final class C13Test extends TestCase {
    public function testItMatchesWhenIpCountryIsInNorthAmerica(): void {
        $countryCodes = tirreno('constants')->COUNTRY_CODES_NORTH_AMERICA;

        $params = [
            'eip_country_id' => [$countryCodes[0]],
        ];

        $rule = new C13(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenAnyIpCountryIsInNorthAmerica(): void {
        $countryCodes = tirreno('constants')->COUNTRY_CODES_NORTH_AMERICA;

        $params = [
            'eip_country_id' => [999, $countryCodes[0]],
        ];

        $rule = new C13(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotInNorthAmerica(): void {
        $params = [
            'eip_country_id' => [999],
        ];

        $rule = new C13(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenNoIpCountriesAreInNorthAmerica(): void {
        $params = [
            'eip_country_id' => [998, 999],
        ];

        $rule = new C13(params: $params);

        $this->assertFalse($rule->execute());
    }
}
