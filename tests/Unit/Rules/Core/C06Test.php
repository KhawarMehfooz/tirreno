<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C06;
use PHPUnit\Framework\TestCase;

final class C06Test extends TestCase {
    public function testItMatchesWhenIpCountryIsIndonesia(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_INDONESIA;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C06(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotIndonesia(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_INDONESIA;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C06(params: $params);

        $this->assertFalse($rule->execute());
    }
}
