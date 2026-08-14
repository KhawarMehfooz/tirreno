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

namespace Tirreno\Updates;

class Update010 extends Base {
    public static string $version = 'v0.10.1';

    public static function apply(\DB\SQL $database): void {
        $queries = [
            self::regularSequence('event_review_queue_id_seq'),
            ('CREATE TABLE event_review_queue (
                id bigint NOT NULL DEFAULT nextval(\'event_review_queue_id_seq\'::regclass),
                account bigint NOT NULL,
                created timestamp without time zone DEFAULT now() NOT NULL,
                key smallint NOT NULL
            )'),
            'ALTER SEQUENCE event_review_queue_id_seq OWNED BY event_review_queue.id',
            'CREATE UNIQUE INDEX event_review_queue_account_uidx ON event_review_queue USING btree (account)',
            'CREATE INDEX event_review_queue_key_idx ON event_review_queue USING btree (key)',
            'ALTER TABLE ONLY event_review_queue ADD CONSTRAINT event_review_queue_id_pkey PRIMARY KEY (id)',
            'ALTER TABLE ONLY event_review_queue ADD CONSTRAINT event_review_queue_key_fkey FOREIGN KEY (key) REFERENCES dshb_api(id) ON DELETE CASCADE',
            'CREATE TRIGGER restrict_update BEFORE UPDATE ON event_review_queue FOR EACH ROW EXECUTE FUNCTION restrict_update()',
            'ALTER TABLE ONLY event_review_queue ADD CONSTRAINT event_review_queue_account_key_fkey FOREIGN KEY (account, key) REFERENCES event_account(id, key) ON UPDATE CASCADE ON DELETE CASCADE',
        ];

        foreach ($queries as $sql) {
            $database->exec($sql);
        }

        $sql = ('
            INSERT INTO event_review_queue (account, created, key)
            SELECT
                id              AS account,
                added_to_review AS created,
                key
            FROM
                event_account
            WHERE
                event_account.added_to_review IS NOT NULL AND
                event_account.fraud IS NULL
            ORDER BY event_account.added_to_review ASC
        ');

        $database->exec($sql);

        $queries = [
            'ALTER TABLE event_isp ADD COLUMN total_fraud_account integer DEFAULT 0',
            ('
                UPDATE event_isp
                SET
                    total_fraud_account = COALESCE(sub.total_fraud_account, 0)
                FROM (
                    SELECT
                        event_ip.isp,
                        COUNT(DISTINCT CASE WHEN event_account.fraud IS TRUE THEN account END) AS total_fraud_account
                    FROM event
                    LEFT JOIN event_ip ON event.ip = event_ip.id
                    LEFT JOIN event_account ON event.account = event_account.id
                    GROUP BY event_ip.isp
                ) AS sub
                RIGHT JOIN event_isp sub_isp ON sub.isp = sub_isp.id
                WHERE
                    event_isp.id = sub_isp.id
            '),
        ];

        foreach ($queries as $sql) {
            $database->exec($sql);
        }
    }
}
