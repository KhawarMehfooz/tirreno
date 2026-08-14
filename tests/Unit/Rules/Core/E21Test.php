<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\E21;
use PHPUnit\Framework\TestCase;

final class E21Test extends TestCase {
    public function testItMatchesWhenEmailUsernameHasNoVowels(): void {
        $params = [
            'le_email_has_vowels' => false,
            'le_local_part_len' => 5,
        ];

        $rule = new E21(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenEmailUsernameHasVowels(): void {
        $params = [
            'le_email_has_vowels' => true,
            'le_local_part_len' => 5,
        ];

        $rule = new E21(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenLocalPartIsEmpty(): void {
        $params = [
            'le_email_has_vowels' => false,
            'le_local_part_len' => 0,
        ];

        $rule = new E21(params: $params);

        $this->assertFalse($rule->execute());
    }
}
