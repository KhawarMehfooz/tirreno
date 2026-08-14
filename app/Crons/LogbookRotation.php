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

namespace Tirreno\Crons;

class LogbookRotation extends Base {
    public function process(): void {
        $this->logInfo('Start logbook rotation.');
        $timer = tirreno('request')->setTimer();
        $keys = tirreno('models')->apiKeys->getAllApiKeyIds();
        // rotate events for unauthorized requests
        $keys[] = ['id' => null];

        $cnt = 0;
        foreach ($keys as $key) {
            $cnt += tirreno('models')->logbook->rotateRequests($key['id']);
        }

        $timer = tirreno('request')->getTimer($timer);

        $this->logInfo('Deleted %s events for %s keys in logbook in %f.', $cnt, count($keys), $timer);
        $this->summary = sprintf('Deleted %s events for %s keys in logbook in %f.', $cnt, count($keys), $timer);
    }
}
