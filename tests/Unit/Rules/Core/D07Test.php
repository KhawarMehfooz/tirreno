<?php

declare(strict_types=1);

namespace Tests\Unit\Rules\Core;

use Tirreno\Rules\Core\D07;
use PHPUnit\Framework\TestCase;

final class D07Test extends TestCase {
    public function testItMatchesWhenUserHasDesktopDevicesWithDifferentOperatingSystems(): void {
        $params = [
            'eup_device_count' => 2,
            'eup_device' => ['desktop', 'desktop'],
            'eup_os_name' => ['Windows', 'GNU/Linux'],
        ];

        $rule = new D07(params: $params);

        $this->assertTrue($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasDesktopDevicesWithSameOperatingSystem(): void {
        $params = [
            'eup_device_count' => 2,
            'eup_device' => ['desktop', 'desktop'],
            'eup_os_name' => ['Windows', 'Windows'],
        ];

        $rule = new D07(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenOnlyOneDeviceIsDesktop(): void {
        $params = [
            'eup_device_count' => 2,
            'eup_device' => ['desktop', 'mobile'],
            'eup_os_name' => ['Windows', 'Android'],
        ];

        $rule = new D07(params: $params);

        $this->assertFalse($rule->execute());
    }

    public function testItDoesNotMatchWhenUserHasNoDesktopDevices(): void {
        $params = [
            'eup_device_count' => 2,
            'eup_device' => ['mobile', 'tablet'],
            'eup_os_name' => ['Android', 'iOS'],
        ];

        $rule = new D07(params: $params);

        $this->assertFalse($rule->execute());
    }
}
