<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C11;
use PHPUnit\Framework\TestCase;

final class C11Test extends TestCase {
    public function testItMatchesWhenIpCountryIsRussia(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_RUSSIA;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C11(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotRussia(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_RUSSIA;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C11(params: $params);

        $this->assertFalse($rule->execute());
    }
}
