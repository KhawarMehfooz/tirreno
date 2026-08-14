<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E23;
use PHPUnit\Framework\TestCase;

final class E23Test extends TestCase {
    public function testItMatchesWhenUserHasEducationalEmail(): void {
        $params = [
            'ee_email' => [
                'john@example.com',
                'student@mit.edu',
            ],
        ];

        $rule = new E23(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoEducationalEmails(): void {
        $params = [
            'ee_email' => [
                'john@example.com',
                'alice@gmail.com',
            ],
        ];

        $rule = new E23(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoEmails(): void {
        $params = [
            'ee_email' => [],
        ];

        $rule = new E23(params: $params);

        $this->assertFalse($rule->execute());
    }
}
