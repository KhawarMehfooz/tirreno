<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\B05;
use PHPUnit\Framework\TestCase;

final class B05Test extends TestCase {
    public function testItMatchesWhenUserHasMoreThanMaximumNumberOf4xxErrors(): void {
        $maximum = tirreno('constants')->RULE_MAXIMUM_NUMBER_OF_404_CODES;

        $params = [
            'event_multiple_4xx_http' => $maximum + 1,
        ];

        $rule = new B05(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenUserHasExactlyMaximumNumberOf4xxErrors(): void {
        $maximum = tirreno('constants')->RULE_MAXIMUM_NUMBER_OF_404_CODES;

        $params = [
            'event_multiple_4xx_http' => $maximum,
        ];

        $rule = new B05(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasLessThanMaximumNumberOf4xxErrors(): void {
        $maximum = tirreno('constants')->RULE_MAXIMUM_NUMBER_OF_404_CODES;

        $params = [
            'event_multiple_4xx_http' => $maximum - 1,
        ];

        $rule = new B05(params: $params);

        $this->assertFalse($rule->execute());
    }
}
