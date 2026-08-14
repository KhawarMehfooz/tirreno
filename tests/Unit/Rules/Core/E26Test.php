<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E26;
use PHPUnit\Framework\TestCase;

final class E26Test extends TestCase {
    public function testItMatchesWhenUserHasIcloudEmail(): void {
        $params = [
            'ee_email' => [
                'john@gmail.com',
                'user@icloud.com',
            ],
        ];

        $rule = new E26(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenUserHasMeEmail(): void {
        $params = [
            'ee_email' => [
                'user@me.com',
            ],
        ];

        $rule = new E26(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItMatchesWhenUserHasMacEmail(): void {
        $params = [
            'ee_email' => [
                'user@mac.com',
            ],
        ];

        $rule = new E26(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoAppleEmails(): void {
        $params = [
            'ee_email' => [
                'john@gmail.com',
                'alice@example.com',
            ],
        ];

        $rule = new E26(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoEmails(): void {
        $params = [
            'ee_email' => [],
        ];

        $rule = new E26(params: $params);

        $this->assertFalse($rule->execute());
    }
}
