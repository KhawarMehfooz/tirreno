import {BasePage} from './Base.js?v=0.10.1';

import {DatesFilter} from '../parts/DatesFilter.js?v=0.10.1';
import {SearchFilter} from '../parts/SearchFilter.js?v=0.10.1';
import {EventPanel} from '../parts/panel/EventPanel.js?v=0.10.1';
import {WatchlistTags} from '../parts/WatchlistTags.js?v=0.10.1';
import {EventsGrid} from '../parts/grid/Events.js?v=0.10.1';

export class WatchlistPage extends BasePage {
    constructor() {
        super('watchlist');
    }

    initUi() {
        const datesFilter   = new DatesFilter();
        const searchFilter  = new SearchFilter();

        this.setBaseFilters(datesFilter, searchFilter);

        const gridParams = {
            url:            `${window.app_base}/loadEvents?watchlist=true`,
            tileId:         'totalEvents',
            tableId:        'user-events-table',
            panelType:      'event',

            dateRangeGrid:  true,
            isSortable:     false,

            getParams:      this.getParamsSection,
        };

        new EventPanel();
        new WatchlistTags();
        new EventsGrid(gridParams);
    }
}
