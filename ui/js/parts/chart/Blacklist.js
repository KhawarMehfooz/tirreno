import {BaseLineChart} from './BaseLine.js?v=0.10.1';

export class BlacklistChart extends BaseLineChart {
    getSeries() {
        return [
            this.getDaySeries(),
            this.getSingleSeries('Manually blacklisted entities', 'red'),
            this.getSingleSeries('Auto-blacklisted entities', 'yellow'),
        ];
    }
}
