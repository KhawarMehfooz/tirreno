import {BaseFilter} from './BaseFilter.js?v=0.10.1';
import {
    renderRuleSelectorItem,
    renderRuleSelectorChoice,
} from '../DataRenderers.js?v=0.10.1';

export class RulesFilter extends BaseFilter {
    constructor() {
        super(
            '#rule-selectors',
            renderRuleSelectorItem,
            renderRuleSelectorChoice,
            'rulesFilterChanged'
        );
    }
}
