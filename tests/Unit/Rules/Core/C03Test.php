<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C03;
use PHPUnit\Framework\TestCase;

final class C03Test extends TestCase {
    public function testItMatchesWhenIpCountryIsChina(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_CHINA;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C03(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotChina(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_CHINA;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C03(params: $params);

        $this->assertFalse($rule->execute());
    }
}
