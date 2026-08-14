<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\P02;
use PHPUnit\Framework\TestCase;

final class P02Test extends TestCase {
    public function testItMatchesWhenPhoneCountryDoesNotMatchIpCountry(): void {
        $params = [
            'lp_country_code' => 840,
            'eip_country_id' => [276, 250],
        ];

        $rule = new P02(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenPhoneCountryMatchesIpCountry(): void {
        $params = [
            'lp_country_code' => 840,
            'eip_country_id' => [276, 840],
        ];

        $rule = new P02(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenPhoneCountryIsUnknown(): void {
        $params = [
            'lp_country_code' => null,
            'eip_country_id' => [276, 840],
        ];

        $rule = new P02(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenPhoneCountryIsZero(): void {
        $params = [
            'lp_country_code' => 0,
            'eip_country_id' => [276, 840],
        ];

        $rule = new P02(params: $params);

        $this->assertFalse($rule->execute());
    }
}
