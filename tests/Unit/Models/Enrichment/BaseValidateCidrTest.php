<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Enrichment\Base;

use Tirreno\Models\Enrichment\Base;
use PHPUnit\Framework\TestCase;

class BaseValidateCidrTest extends TestCase {
    private Base $model;

    protected function setUp(): void {
        parent::setUp();

        $this->model = new Base();
    }

    public function testReturnsTrueForValidIpv4Cidr(): void {
        $this->assertTrue(
            $this->model->validateCidr('192.168.1.0/24')
        );
    }

    public function testReturnsTrueForValidIpv6Cidr(): void {
        $this->assertTrue(
            $this->model->validateCidr('2001:db8::/64')
        );
    }

    public function testReturnsFalseWhenSlashIsMissing(): void {
        $this->assertFalse(
            $this->model->validateCidr('192.168.1.0')
        );
    }

    public function testReturnsFalseForNegativeNetmask(): void {
        $this->assertFalse(
            $this->model->validateCidr('192.168.1.0/-1')
        );
    }

    public function testReturnsFalseForIpv4NetmaskGreaterThan32(): void {
        $this->assertFalse(
            $this->model->validateCidr('192.168.1.0/33')
        );
    }

    public function testReturnsFalseForIpv6NetmaskGreaterThan128(): void {
        $this->assertFalse(
            $this->model->validateCidr('2001:db8::/129')
        );
    }

    public function testReturnsFalseForInvalidIp(): void {
        $this->assertFalse(
            $this->model->validateCidr('invalid/24')
        );
    }
}
