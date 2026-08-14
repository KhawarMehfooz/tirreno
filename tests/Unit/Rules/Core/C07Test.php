<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C07;
use PHPUnit\Framework\TestCase;

final class C07Test extends TestCase {
    public function testItMatchesWhenIpCountryIsVenezuela(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_VENEZUELA;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C07(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotVenezuela(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_VENEZUELA;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C07(params: $params);

        $this->assertFalse($rule->execute());
    }
}
