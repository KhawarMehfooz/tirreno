<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C14;
use PHPUnit\Framework\TestCase;

final class C14Test extends TestCase {
    public function testItMatchesWhenIpCountryIsAustralia(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_AUSTRALIA;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C14(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotAustralia(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_AUSTRALIA;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C14(params: $params);

        $this->assertFalse($rule->execute());
    }
}
