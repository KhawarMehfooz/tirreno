<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C15;
use PHPUnit\Framework\TestCase;

final class C15Test extends TestCase {
    public function testItMatchesWhenIpCountryIsUae(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_UAE;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C15(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotUae(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_UAE;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C15(params: $params);

        $this->assertFalse($rule->execute());
    }
}
