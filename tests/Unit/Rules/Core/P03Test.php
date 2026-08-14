<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\P03;
use PHPUnit\Framework\TestCase;

final class P03Test extends TestCase {
    public function testItMatchesWhenPhoneNumberIsShared(): void {
        $params = [
            'ep_shared_phone' => true,
        ];

        $rule = new P03(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenPhoneNumberIsNotShared(): void {
        $params = [
            'ep_shared_phone' => false,
        ];

        $rule = new P03(params: $params);

        $this->assertFalse($rule->execute());
    }
}
