<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E28;
use PHPUnit\Framework\TestCase;

final class E28Test extends TestCase {
    public function testItMatchesWhenEmailHasNoDigits(): void {
        $params = [
            'le_email_has_no_digits' => true,
            'le_local_part_len' => 5,
        ];

        $rule = new E28(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailHasDigits(): void {
        $params = [
            'le_email_has_no_digits' => false,
            'le_local_part_len' => 5,
        ];

        $rule = new E28(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenLocalPartIsEmpty(): void {
        $params = [
            'le_email_has_no_digits' => true,
            'le_local_part_len' => 0,
        ];

        $rule = new E28(params: $params);

        $this->assertFalse($rule->execute());
    }
}
