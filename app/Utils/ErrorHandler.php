<?php

/**
 * tirreno ~ open-source security framework
 * Copyright (c) Tirreno Technologies Sàrl (https://www.tirreno.com)
 *
 * Licensed under GNU Affero General Public License version 3 of the or any later version.
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Tirreno Technologies Sàrl (https://www.tirreno.com)
 * @license       https://opensource.org/licenses/AGPL-3.0 AGPL License
 * @link          https://www.tirreno.com Tirreno(tm)
 */

declare(strict_types=1);

namespace Tirreno\Utils;

class ErrorHandler {
    protected const PROTECTED_ARGS = [
        'password',
        'enrichmentKey',
        'databaseUrl',
        'pw',
        'unverified',
        'token',
        'apiToken',
        'activationKey',
        'renewKey',
        'privateKey',
        'hash',
        'dsn',
    ];

    protected const PROTECTED_FUNCTIONS = [
        'hash_hmac',
        'password_hash',
        'password_verify',
        'hash_pbkdf2',
        'hash',
    ];

    protected const ERRORS = [
        E_ERROR,
        E_CORE_ERROR,
        E_COMPILE_ERROR,
        E_PARSE,
        E_USER_ERROR,
        E_RECOVERABLE_ERROR,
    ];

    protected const FATAL_ERRORS = [
        E_ERROR,
        E_CORE_ERROR,
        E_COMPILE_ERROR,
        E_PARSE,
    ];

    protected const WARNINGS = [
        E_WARNING,
        E_CORE_WARNING,
        E_COMPILE_WARNING,
        E_USER_WARNING,
    ];

    protected const NOTICES = [
        E_NOTICE,
        E_USER_NOTICE,
        E_DEPRECATED,
        E_USER_DEPRECATED,
        E_STRICT,
    ];

    public static function getErrorDetails(): array {
        $errorTrace     = [];
        $errorCode      = tirreno('storage')->get('ERROR.code');
        $errorMessage   = tirreno('storage')->get('ERROR.text');
        $storedError    = tirreno('storage')->get('LAST_ERROR');

        if ($storedError) {
            $errorMessage = $storedError['message'];
            $errorTrace = $storedError['trace'];
            tirreno('log')->debug('LAST_ERROR was set');
            tirreno('storage')->remove('LAST_ERROR');
        } else {
            tirreno('log')->debug('LAST_ERROR was not set');
        }

        $errorMessage = 'ERROR_' . strval($errorCode) . ', ' . $errorMessage;

        return [
            'ip'        => tirreno('request')->getIp(),
            'code'      => $errorCode,
            'message'   => $errorMessage,
            'trace'     => $errorTrace,
            'date'      => date('l jS \of F Y h:i:s A'),
            'post'      => tirreno('storage')->get('POST'),
            'get'       => tirreno('storage')->get('GET'),
        ];
    }

    public static function saveErrorInformation(?array $errorData = null): void {
        if ($errorData === null) {
            $errorData = static::getErrorDetails();
        }

        $debugLevel = tirreno('utils')->variables->getDebugLevel();

        //tirreno('utils')->logger->log(null, $errorData['message']);
        tirreno('log')->error($errorData['message']);

        // print trace to log
        if (tirreno('storage')->get('PRINT_ERROR_TRACE_TO_LOG')) {
            foreach ($errorData['trace'] as $errorFrame) {
                //tirreno('utils')->logger->log(null, $errorFrame);
                tirreno('log')->error($errorFrame);
            }
        }

        // save to database
        if (tirreno('utils')->variables->getLogToDatabase() && tirreno('db')->initConnection()) {
            if (tirreno('utils')->routes->getCurrentRequestOperator()->isLoggedIn()) {
                tirreno('models')->log->insertRecord($errorData);
            }
        }

        // log sql if PRINT_SQL_LOG_AFTER_EACH_SCRIPT_CALL is true
        tirreno('utils')->logger->logSqlIfPossible();

        // send email on 500
        if ($errorData['code'] === 500) {
            $toName = 'Admin';
            $toAddress = tirreno('utils')->variables->getAdminEmail();
            if ($toAddress === null) {
                tirreno('log')->warning('Stop email report sending, ADMIN_EMAIL is not set.');

                return;
            }

            $subject = tirreno('storage')->get('error_email_subject') ?? tirreno('constants')->BASE_ERROR_EMAIL_SUBJECT;
            $subject = sprintf($subject, $errorData['code']);

            $currentTime    = date('d-m-Y H:i:s');
            $errorMessage   = $errorData['message'];
            $errorTrace     = implode('<br>', $errorData['trace']);

            $hosts = json_encode(tirreno('utils')->variables->getHosts());

            $message = tirreno('storage')->get('error_email_body_template') ?? tirreno('constants')->BASE_ERROR_EMAIL_BODY_TEMPLATE;
            $message = sprintf($message, $currentTime, $hosts, $errorMessage, strval($debugLevel), $errorTrace);

            tirreno('utils')->mailer->send($toName, $toAddress, $subject, $message, true);
        }
    }

    protected static function getAjaxErrorMessage(array $errorData): string|false {
        return json_encode(
            [
                'status'    => false,
                'code'      => $errorData['code'],
                'message'   => sprintf('Request finished with code %s', $errorData['code']),
            ],
        );
    }

    public static function setRouterErrorHandler(): void {
        tirreno('storage')->set('ONERROR', [static::class, 'routerErrorHandler']);
    }

    public static function setCronErrorHandler(): void {
        tirreno('storage')->set('ONERROR', [static::class, 'cronErrorHandler']);
    }

    public static function routerErrorHandler(): void {
        // both real exceptions/errors and f3->error() occure here

        $errorData = self::getErrorDetails();

        // clean template if anything was rendered already
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        self::saveErrorInformation($errorData);

        $code = $errorData['code'];

        if ($code === 403 && !tirreno('request')->isAjax()) {
            tirreno('response')->redirect('/logout');

            return;
        }

        // Add handling 404 error
        if ($code === 404) {
        }

        if (tirreno('request')->isAjax()) {
            echo self::getAjaxErrorMessage($errorData);

            return;
        }

        $errorData['message'] = 'ERROR_' . $errorData['code'];
        $errorData['raw'] = false;

        if ($code !== 404) {
            $errorData['extra_message'] = tirreno('storage')->get('ErrorPage_extra_message');
            $errorData['raw'] = true;
        }

        if ($code === 400) {
            $errorData['message'] = 'Error code ' . tirreno('utils')->errorCodes->INVALID_HOSTNAME;
            $errorData['extra_message'] = 'Visit page via correct hostname: ' . tirreno('utils')->variables->getHostWithProtocol() . tirreno('request')->getPath();
        }

        if ($code === 503) {
            $errorData['message'] = 'Error code ' . tirreno('utils')->errorCodes->FAILED_DB_CONNECT;
            $errorData['extra_message'] = 'Database connection failed.';
        }

        if ($code === 422) {
            $errorData['message'] = 'Error code ' . tirreno('utils')->errorCodes->INCOMPLETE_CONFIG;
            $errorData['extra_message'] = 'App configuration is incomplete. Check config/local/config.local.ini and possible environment overrides.';
        }

        $debugLevel = tirreno('utils')->variables->getDebugLevel();

        if ($code === 500 && $debugLevel > 0) {
            $errorText = tirreno('storage')->get('ERROR.text');
            if ($errorText) {
                $errorData['extra_message'] = strval($errorText);
                $errorData['raw'] = false;
            }
        }

        if ($code !== 500 || $debugLevel < tirreno('constants')->DEBUG_LVL_TRACE) {
            unset($errorData['trace']);
        }

        $pageParams = tirreno('pages')->error->getPageParams($errorData);
        $response = new \Tirreno\Views\Frontend();

        $response->data = $pageParams;
        echo $response->render();
    }

    public static function cronErrorHandler(): void {
        static::saveErrorInformation();
    }

    public static function setErrorToExceptionHandler(): void {
        set_error_handler([static::class, 'exceptionErrorHandler']);
    }

    public static function exceptionErrorHandler(int $errno, string $errstr, string $errfile, int $errline): bool {
        if (!(error_reporting() & $errno)) {
            return false;
        }
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

    public static function setBaseErrorHandler(): void {
        restore_error_handler();

        set_error_handler([static::class, 'baseErrorHandler']);
    }

    public static function setBaseExceptionHandler(): void {
        restore_exception_handler();

        set_exception_handler([static::class, 'baseExceptionHandler']);
    }

    public static function setBaseShutdownHandler(): void {
        // do not use native php register_shutdown_function
        tirreno('storage')->set('UNLOAD', [static::class, 'baseShutdownHandler']);
    }

    public static function initHandlers(): void {
        static::setBaseShutdownHandler();
        static::setBaseExceptionHandler();
        static::setBaseErrorHandler();
    }

    public static function baseErrorHandler(int $errno, string $errstr, string $errfile, int $errline): bool {
        if (!(error_reporting() & $errno)) {
            return false;
        }

        static::logError($errno, $errstr, $errfile, $errline);

        error_clear_last();

        return false;
    }

    public static function baseExceptionHandler(\Throwable $exception): void {
        $errno      = E_ERROR;
        $errstr     = $exception::class . ': ' . $exception->getMessage();
        $errfile    = $exception->getFile();
        $errline    = $exception->getLine();
        $trace      = $exception->getTrace();

        static::logError($errno, $errstr, $errfile, $errline, $trace);

        tirreno('router')->error(500, $errstr, $trace);
    }

    public static function baseShutdownHandler(): bool {
        // fatal errors
        $error = error_get_last();

        if ($error === null) {
            return false;
        }

        $errno = $error['type'];

        if (!in_array($errno, static::FATAL_ERRORS) && $errno !== E_COMPILE_WARNING) {
            return false;
        }

        $errstr     = $error['message'];
        $errfile    = $error['file'];
        $errline    = $error['line'];

        static::logError($errno, $errstr, $errfile, $errline);

        return false;
    }

    protected static function logError(int $errno, string $errstr, string $errfile, int $errline, ?array $trace = null): void {
        $traceStr = '';
        $debugLevel = tirreno('utils')->variables->getDebugLevel();

        $fullDebug = $debugLevel >= tirreno('constants')->DEBUG_LVL_FULL;

        if ($debugLevel > tirreno('constants')->DEBUG_LVL_BASIC) {
            $traceStack = $trace ?? ($fullDebug ? debug_backtrace() : debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
            if ($trace === null) {
                array_shift($traceStack);
                array_shift($traceStack);
            }
            $trace = static::formatTrace($traceStack, $fullDebug);
            $traceStr = PHP_EOL . ' Trace: ' . PHP_EOL . implode(PHP_EOL, $trace);
        }

        if ($debugLevel === tirreno('constants')->DEBUG_LVL_BASIC || in_array($errno, static::ERRORS)) {
            tirreno('log')->error('%s in %s:%d %s', $errstr, $errfile, $errline, $traceStr);
        }

        tirreno('storage')->set('LAST_ERROR', [
            'type'      => $errno,
            'message'   => $errstr,
            'file'      => $errfile,
            'line'      => $errline,
            'trace'     => $debugLevel > tirreno('constants')->DEBUG_LVL_BASIC ? $trace : [],
        ]);
    }

    protected static function formatTrace(array $trace, bool $includeArgs = false): array {
        $lines = [];

        foreach ($trace as $idx => $level) {
            $function = ($level['class'] ?? '') . ($level['type'] ?? '') . ($level['function'] ?? '');
            $args = $includeArgs && ($level['args'] ?? []) ? static::formatArgs($level) : '';
            $lines[] = sprintf('%d# [%s:%d] %s(%s)', $idx, $level['file'] ?? 'internal', $level['line'] ?? 0, $function, $args);
        }

        return $lines;
    }

    protected static function formatArgs(array $level): string {
        $reflection = null;
        $args = [];
        $class = $level['class'] ?? null;
        $function = $level['function'];

        try {
            $reflection = $class ? new \ReflectionMethod($class, $function) : $reflection = new \ReflectionFunction($function);
        } catch (\ReflectionException) {
        }

        $params = $reflection?->getParameters();

        if (!$params) {
            return '';
        }

        foreach ($level['args'] ?? [] as $idx => $arg) {
            $param = $params[$idx] ?? $params[count($params) - 1];

            $mask = in_array($function, static::PROTECTED_FUNCTIONS) || in_array($param->name, static::PROTECTED_ARGS);
            $args[] = static::formatArg($arg, $mask);
        }

        return implode(', ', $args);
    }

    protected static function formatArg(mixed $arg, bool $mask): string {
        return match (true) {
            $mask                           => '***',
            $arg === null                   => 'null',
            is_bool($arg)                   => $arg ? 'true' : 'false',
            is_int($arg) || is_float($arg)  => strval($arg),
            is_string($arg)                 => '\'' . str_replace(["\r", "\n"], ' ', $arg) . '\'',
            is_array($arg)                  => 'array(' . strval(count($arg)) . ')',
            is_object($arg)                 => get_class($arg),
            is_resource($arg)               => get_resource_type($arg),
            default                         => gettype($arg),
        };
    }
}
