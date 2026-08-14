<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C01;
use PHPUnit\Framework\TestCase;

final class C01Test extends TestCase {
    public function testItMatchesWhenIpCountryIsNigeria(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_NIGERIA;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C01(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotNigeria(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_NIGERIA;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C01(params: $params);

        $this->assertFalse($rule->execute());
    }
}
