import {BaseFilter} from './BaseFilter.js?v=0.10.1';
import {
    renderIpTypeSelectorItem,
    renderIpTypeSelectorChoice,
} from '../DataRenderers.js?v=0.10.1';

export class IpTypeFilter extends BaseFilter {
    constructor() {
        super(
            '#ip-type-selectors',
            renderIpTypeSelectorItem,
            renderIpTypeSelectorChoice,
            'ipTypeFilterChanged'
        );
    }
}
