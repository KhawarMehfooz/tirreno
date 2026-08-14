<?php

declare(strict_types=1);

namespace Tests\Unit\Utils;

use Tirreno\Utils\ErrorHandler;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Tirreno\Utils\ErrorHandler.
 *
 * Covered:
 * - ErrorHandler::getErrorDetails()
 * - ErrorHandler::exceptionErrorHandler()
 *
 * @todo Cover ErrorHandler::saveErrorInformation() after logger, database,
 *       routes, models, variables and mailer dependencies can be replaced in tests.
 *
 * @todo Cover ErrorHandler::routerErrorHandler() after output buffers,
 *       redirect/rendering and response dependencies can be isolated.
 *
 * @todo Cover ErrorHandler::cronErrorHandler() together with
 *       saveErrorInformation() after side effects are isolated.
 *
 * @todo Cover ErrorHandler::getAjaxErrorMessage() after it is extracted
 *       into a pure renderer or made testable through public behavior.
 */
final class ErrorHandlerTest extends TestCase {
    private \Base $f3;

    /** @var array<string, mixed> */
    private array $backup = [];

    /** @var list<string> */
    private array $keys = [
        'ERROR.code',
        'ERROR.text',
        'LAST_ERROR',
        'POST',
        'GET',
        'IP',
    ];

    protected function setUp(): void {
        parent::setUp();

        $this->f3 = \Base::instance();

        $this->backupState();
        $this->clearState();
    }

    protected function tearDown(): void {
        $this->clearState();
        $this->restoreState();

        parent::tearDown();
    }

    public function testGetErrorDetailsUsesStoredErrorMessageAndTrace(): void {
        $trace = [
            '0# [/app/index.php:10] Tirreno\\Service\\Example->run()',
            '1# [/app/bootstrap.php:20] require()',
        ];

        $post = ['a' => 'b'];
        $get = ['q' => 'x'];

        $this->f3->set('IP', '203.0.113.10');
        $this->f3->set('ERROR.code', 500);
        $this->f3->set('ERROR.text', 'Framework error');
        $this->f3->set('LAST_ERROR', [
            'type' => E_ERROR,
            'message' => 'Something went wrong',
            'file' => '/app/index.php',
            'line' => 10,
            'trace' => $trace,
        ]);
        $this->f3->set('POST', $post);
        $this->f3->set('GET', $get);

        $result = ErrorHandler::getErrorDetails();

        $this->assertSame('203.0.113.10', $result['ip']);
        $this->assertSame(500, $result['code']);
        $this->assertSame(
            'ERROR_500, Something went wrong',
            $result['message']
        );
        $this->assertSame($trace, $result['trace']);
        $this->assertSame($post, $result['post']);
        $this->assertSame($get, $result['get']);

        $this->assertIsString($result['date']);
        $this->assertNotSame('', $result['date']);

        $this->assertFalse($this->f3->exists('LAST_ERROR'));
    }

    public function testGetErrorDetailsUsesFrameworkErrorWhenStoredErrorIsAbsent(): void {
        $this->f3->set('IP', '127.0.0.1');
        $this->f3->set('ERROR.code', 404);
        $this->f3->set('ERROR.text', 'Not Found');
        $this->f3->set('POST', []);
        $this->f3->set('GET', []);

        $result = ErrorHandler::getErrorDetails();

        $this->assertSame('127.0.0.1', $result['ip']);
        $this->assertSame(404, $result['code']);
        $this->assertSame('ERROR_404, Not Found', $result['message']);
        $this->assertSame([], $result['trace']);
        $this->assertSame([], $result['post']);
        $this->assertSame([], $result['get']);
    }

    public function testExceptionErrorHandlerThrowsWhenSeverityIsReported(): void {
        $original = error_reporting();

        try {
            error_reporting(E_USER_WARNING);

            $this->expectException(\ErrorException::class);
            $this->expectExceptionMessage('boom');

            ErrorHandler::exceptionErrorHandler(
                E_USER_WARNING,
                'boom',
                __FILE__,
                __LINE__
            );
        } finally {
            error_reporting($original);
        }
    }

    public function testExceptionErrorHandlerReturnsFalseWhenSeverityIsNotReported(): void {
        $original = error_reporting();

        try {
            error_reporting(0);

            $result = ErrorHandler::exceptionErrorHandler(
                E_USER_WARNING,
                'ignored',
                __FILE__,
                __LINE__
            );

            $this->assertFalse($result);
        } finally {
            error_reporting($original);
        }
    }

    private function backupState(): void {
        foreach ($this->keys as $key) {
            if ($this->f3->exists($key)) {
                $this->backup[$key] = $this->f3->get($key);
            }
        }
    }

    private function clearState(): void {
        foreach ($this->keys as $key) {
            $this->f3->clear($key);
        }
    }

    private function restoreState(): void {
        foreach ($this->backup as $key => $value) {
            $this->f3->set($key, $value);
        }
    }
}
