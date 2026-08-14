import {BaseLineChart} from './BaseLine.js?v=0.10.1';

export class DomainsChart extends BaseLineChart {
    getSeries() {
        return [
            this.getDaySeries(),
            this.getSingleSeries('Total domains', 'green'),
            this.getSingleSeries('New domains', 'yellow'),
        ];
    }
}
