<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B04;
use PHPUnit\Framework\TestCase;

final class B04Test extends TestCase {
    public function testItMatchesWhenUserHasMoreThanMaximumNumberOf5xxErrors(): void {
        $maximum = tirreno('constants')->RULE_MAXIMUM_NUMBER_OF_500_CODES;

        $params = [
            'event_multiple_5xx_http' => $maximum + 1,
        ];

        $rule = new B04(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasExactlyMaximumNumberOf5xxErrors(): void {
        $maximum = tirreno('constants')->RULE_MAXIMUM_NUMBER_OF_500_CODES;

        $params = [
            'event_multiple_5xx_http' => $maximum,
        ];

        $rule = new B04(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasLessThanMaximumNumberOf5xxErrors(): void {
        $maximum = tirreno('constants')->RULE_MAXIMUM_NUMBER_OF_500_CODES;

        $params = [
            'event_multiple_5xx_http' => $maximum - 1,
        ];

        $rule = new B04(params: $params);

        $this->assertFalse($rule->execute());
    }
}
