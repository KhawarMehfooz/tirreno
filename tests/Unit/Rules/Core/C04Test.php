<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C04;
use PHPUnit\Framework\TestCase;

final class C04Test extends TestCase {
    public function testItMatchesWhenIpCountryIsBrazil(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_BRAZIL;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C04(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotBrazil(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_BRAZIL;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C04(params: $params);

        $this->assertFalse($rule->execute());
    }
}
