<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\C16;
use PHPUnit\Framework\TestCase;

final class C16Test extends TestCase {
    public function testItMatchesWhenIpCountryIsJapan(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_JAPAN;

        $params = [
            'eip_country_id' => [$countryCode],
        ];

        $rule = new C16(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenIpCountryIsNotJapan(): void {
        $countryCode = tirreno('constants')->COUNTRY_CODE_JAPAN;

        $params = [
            'eip_country_id' => [$countryCode + 1000],
        ];

        $rule = new C16(params: $params);

        $this->assertFalse($rule->execute());
    }
}
