import {BaseGrid} from './Base.js?v=0.10.1';
import {
    renderTime,
    renderDate,
    renderBlacklistSource,
    renderBlacklistButtons,
    renderClickableImportantUserWithScore,
} from '../DataRenderers.js?v=0.10.1';

export class BlacklistGrid extends BaseGrid {
    get orderConfig() {
        return [[1, 'desc']];
    }

    onDateFilterChanged() {}

    get columnDefs() {
        const columnDefs = [
            {
                className: 'blacklist-user-col',
                targets: 0
            },
            {
                className: 'blacklist-timestamp-col',
                targets: 1
            },
            {
                className: 'blacklist-timestamp-col',
                targets: 2
            },
            {
                className: 'blacklist-date-col',
                targets: 3
            },
            {
                className: 'blacklist-status-col',
                targets: 4
            },
            {
                className: 'blacklist-button-col',
                targets: 5
            }
        ];

        return columnDefs;
    }

    get columns() {
        const columns = [
            {
                data: 'score',
                render: (data, type, record) => {
                    return renderClickableImportantUserWithScore(record, 'medium');
                }
            },
            {
                data: 'latest_decision',
                render: renderTime
            },
            {
                data: 'lastseen',
                render: renderTime
            },
            {
                data: 'created',
                render: (data, type, record) => {
                    return renderDate(data);
                },
            },
            {
                data: 'reviewed',
                render: (data, type, record) => {
                    return renderBlacklistSource(record);
                }
            },
            {
                data: 'accountid',
                orderable: false,
                render: (data, type, record) => {
                    return renderBlacklistButtons(record);
                }
            }
        ];

        return columns;
    }
}
