<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E25;
use PHPUnit\Framework\TestCase;

final class E25Test extends TestCase {
    public function testItMatchesWhenUserHasMilitaryEmail(): void {
        $params = [
            'ee_email' => [
                'john@example.com',
                'soldier@army.mil',
            ],
        ];

        $rule = new E25(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoMilitaryEmails(): void {
        $params = [
            'ee_email' => [
                'john@example.com',
                'alice@gmail.com',
            ],
        ];

        $rule = new E25(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoEmails(): void {
        $params = [
            'ee_email' => [],
        ];

        $rule = new E25(params: $params);

        $this->assertFalse($rule->execute());
    }
}
