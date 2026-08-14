<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C09;
use PHPUnit\Framework\TestCase;

final class C09Test extends TestCase {
    public function testItMatchesWhenIpCountryIsPhilippines(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_PHILIPPINES;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C09(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotPhilippines(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_PHILIPPINES;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C09(params: $params);

        $this->assertFalse($rule->execute());
    }
}
