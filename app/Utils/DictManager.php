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

class DictManager {
    public static function load(string $file): void {
        $locale = tirreno('storage')->get('LOCALES');
        $language = tirreno('storage')->get('LANGUAGE');

        $path = sprintf(
            '%s%s/Additional/%s.php',
            $locale,
            $language,
            ucfirst($file),
        );

        if (!file_exists($path)) {
            return;
        }

        $values = include $path;

        if ($values === false) {
            return;
        }

        foreach ($values as $key => $value) {
            tirreno('storage')->set($key, $value);
        }
    }
}
