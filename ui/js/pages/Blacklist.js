import {BasePage} from './Base.js?v=0.10.1';
import {SequentialLoad} from '../parts/SequentialLoad.js?v=0.10.1';
import {DatesFilter} from '../parts/DatesFilter.js?v=0.10.1';
import {SearchFilter} from '../parts/SearchFilter.js?v=0.10.1';
import {RulesFilter} from '../parts/choices/RulesFilter.js?v=0.10.1';
import {BlacklistGridActionButtons} from '../parts/button/BlacklistGridActionButtons.js?v=0.10.1';
import {BlacklistChart} from '../parts/chart/Blacklist.js?v=0.10.1';
import {BlacklistGrid} from '../parts/grid/Blacklist.js?v=0.10.1';

export class BlacklistPage extends BasePage {
    constructor() {
        super('blacklist');
    }

    initUi() {
        this.tableId = 'blacklist-table';

        const datesFilter   = new DatesFilter();
        const searchFilter  = new SearchFilter();
        const rulesFilter   = new RulesFilter();

        this.filters = {
            dateRange:      datesFilter,
            searchValue:    searchFilter,
            ruleUids:       rulesFilter,
        };

        const gridParams = {
            url:            `${window.app_base}/loadBlacklist`,
            tileId:         'totalBlacklist',
            tableId:        'blacklist-table',

            dateRangeGrid:  true,

            choicesFilterEvents: [rulesFilter.getEventType()],

            getParams: this.getParamsSection,
        };

        const chartParams = {
            url:        `${window.app_base}/loadBlacklistChart`,
            getParams: this.getParamsSection,
        };

        new BlacklistGridActionButtons(this.tableId);

        const elements = [
            [BlacklistChart,    chartParams],
            [BlacklistGrid,     gridParams],
        ];

        new SequentialLoad(elements);
    }
}
