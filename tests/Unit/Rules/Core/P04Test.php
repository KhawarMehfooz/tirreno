<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\P04;
use PHPUnit\Framework\TestCase;

final class P04Test extends TestCase {
    public function testItMatchesWhenPhoneNumberIsValid(): void {
        $params = [
            'lp_invalid_phone' => false,
            'ep_phone_number' => ['+1234567890'],
        ];

        $rule = new P04(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenPhoneNumberIsInvalid(): void {
        $params = [
            'lp_invalid_phone' => true,
            'ep_phone_number' => ['+1234567890'],
        ];

        $rule = new P04(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenPhoneNumberIsEmpty(): void {
        $params = [
            'lp_invalid_phone' => false,
            'ep_phone_number' => [],
        ];

        $rule = new P04(params: $params);

        $this->assertFalse($rule->execute());
    }
}
