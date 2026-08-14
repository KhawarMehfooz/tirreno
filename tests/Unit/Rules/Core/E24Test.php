<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E24;
use PHPUnit\Framework\TestCase;

final class E24Test extends TestCase {
    public function testItMatchesWhenUserHasGovernmentEmail(): void {
        $params = [
            'ee_email' => [
                'john@example.com',
                'employee@agency.gov',
            ],
        ];

        $rule = new E24(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoGovernmentEmails(): void {
        $params = [
            'ee_email' => [
                'john@example.com',
                'alice@gmail.com',
            ],
        ];

        $rule = new E24(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoEmails(): void {
        $params = [
            'ee_email' => [],
        ];

        $rule = new E24(params: $params);

        $this->assertFalse($rule->execute());
    }
}
