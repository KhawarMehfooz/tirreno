<?php

declare(strict_types=1);

namespace Tests\Unit\Utils;

use Tirreno\Utils\DictManager;
use PHPUnit\Framework\TestCase;
use Tests\Support\FakeFilesystem;

/**
 * Unit tests for DictManager.
 *
 * Covered:
 * - loading dictionary file
 * - storing dictionary values in storage
 * - ignoring missing file
 * - ignoring file returning false
 *
 * Notes:
 * - filesystem access is isolated via FakeFilesystem helper
 */
final class DictManagerTest extends TestCase {
    private FakeFilesystem $fileSystem;

    protected function setUp(): void {
        parent::setUp();

        $this->fileSystem = new FakeFilesystem('dict_manager');

        tirreno('storage')->remove('DICT_TEST_KEY');
        tirreno('storage')->remove('KEY_1');
        tirreno('storage')->remove('KEY_2');

        tirreno('storage')->set(
            'LOCALES',
            $this->fileSystem->getRoot() . '/'
        );

        tirreno('storage')->set(
            'LANGUAGE',
            'en'
        );
    }

    protected function tearDown(): void {
        $this->fileSystem->cleanup();

        parent::tearDown();
    }

    public function testLoadExistingDictionaryFile(): void {
        $this->fileSystem->put(
            'en/Additional/Test.php',
            <<<'PHP'
    <?php

    return [
        'DICT_TEST_KEY' => 'test-value',
    ];
    PHP
        );

        $path = $this->fileSystem->getRoot() . '/en/Additional/Test.php';

        $this->assertFileExists($path);

        DictManager::load('test');

        $this->assertSame(
            'test-value',
            \Base::instance()->get('DICT_TEST_KEY')
        );

        $this->assertSame(
            'test-value',
            tirreno('storage')->get('DICT_TEST_KEY')
        );
    }

    public function testLoadStoresAllDictionaryValues(): void {
        $this->fileSystem->put(
            'en/Additional/Test.php',
            <<<'PHP'
<?php

return [
    'KEY_1' => 'value-1',
    'KEY_2' => 'value-2',
];
PHP
        );

        DictManager::load('test');

        $this->assertSame(
            [
                'KEY_1' => 'value-1',
                'KEY_2' => 'value-2',
            ],
            include sprintf(
                '%s%s/Additional/Test.php',
                tirreno('storage')->get('LOCALES'),
                tirreno('storage')->get('LANGUAGE')
            )
        );

        $this->assertSame(
            'value-1',
            tirreno('storage')->get('KEY_1')
        );

        $this->assertSame(
            'value-2',
            tirreno('storage')->get('KEY_2')
        );
    }

    public function testLoadIgnoresMissingFile(): void {
        DictManager::load('missing');

        $this->assertNull(
            tirreno('storage')->get('DICT_TEST_KEY')
        );
    }

    public function testLoadIgnoresFileReturningFalse(): void {
        $this->fileSystem->put(
            'en/Additional/invalid.php',
            <<<'PHP'
<?php

return false;
PHP
        );

        DictManager::load('invalid');

        $this->assertNull(
            tirreno('storage')->get('DICT_TEST_KEY')
        );
    }
}
