<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C05;
use PHPUnit\Framework\TestCase;

final class C05Test extends TestCase {
    public function testItMatchesWhenIpCountryIsPakistan(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_PAKISTAN;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C05(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotPakistan(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_PAKISTAN;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C05(params: $params);

        $this->assertFalse($rule->execute());
    }
}
