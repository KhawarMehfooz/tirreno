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

namespace Tirreno\Models\Chart;

class Blacklist extends Base {
    public function getData(int $apiKey): array {
        $field1 = 'ts_users_manual_blacklisted';
        $data1  = $this->getFirstLine($apiKey);

        $field2 = 'ts_users_auto_blacklisted';
        $data2  = $this->getSecondLine($apiKey);

        $data0 = $this->concatDataLines($data1, $field1, $data2, $field2);

        $indexedData    = array_values($data0);
        $timestamps     = array_column($indexedData, 'ts');
        $line1          = array_column($indexedData, $field1);
        $line2          = array_column($indexedData, $field2);

        return $this->addEmptyDays([$timestamps, $line1, $line2]);
    }

    private function getFirstLine(int $apiKey): array {
        $query = (
            'SELECT
                EXTRACT(EPOCH FROM date_trunc(:resolution, event_account.latest_decision + :offset))::bigint AS ts,
                COUNT(event_account.id) as ts_users_manual_blacklisted
            FROM
                event_account

            WHERE
                event_account.key = :api_key AND
                event_account.fraud IS TRUE AND
                event_account.reviewed IS TRUE AND
                event_account.latest_decision >= :start_time AND
                event_account.latest_decision <= :end_time

            GROUP BY ts
            ORDER BY ts'
        );

        return $this->execute($query, $apiKey);
    }

    private function getSecondLine(int $apiKey): array {
        $query = (
            'SELECT
                EXTRACT(EPOCH FROM date_trunc(:resolution, event_account.latest_decision + :offset))::bigint AS ts,
                COUNT(event_account.id) as ts_users_auto_blacklisted
            FROM
                event_account

            WHERE
                event_account.key = :api_key AND
                event_account.fraud IS TRUE AND
                event_account.reviewed IS NOT TRUE AND
                event_account.latest_decision >= :start_time AND
                event_account.latest_decision <= :end_time

            GROUP BY ts
            ORDER BY ts'
        );

        return $this->execute($query, $apiKey);
    }
}
