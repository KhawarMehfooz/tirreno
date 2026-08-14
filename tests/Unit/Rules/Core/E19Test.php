<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E19;
use PHPUnit\Framework\TestCase;

final class E19Test extends TestCase {
    public function testItMatchesWhenUserHasChangedMultipleEmails(): void {
        $params = [
            'ee_email' => [
                'first@example.com',
                'second@example.com',
            ],
        ];

        $rule = new E19(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasChangedOneEmail(): void {
        $params = [
            'ee_email' => [
                'first@example.com',
            ],
        ];

        $rule = new E19(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoEmails(): void {
        $params = [
            'ee_email' => [],
        ];

        $rule = new E19(params: $params);

        $this->assertFalse($rule->execute());
    }
}
