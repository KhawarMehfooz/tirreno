import {BaseFilter} from './BaseFilter.js?v=0.10.1';
import {
    renderDeviceTypeSelectorItem,
    renderDeviceTypeSelectorChoice,
} from '../DataRenderers.js?v=0.10.1';

export class DeviceTypeFilter extends BaseFilter {
    constructor() {
        super(
            '#device-type-selectors',
            renderDeviceTypeSelectorItem,
            renderDeviceTypeSelectorChoice,
            'deviceTypeFilterChanged'
        );
    }
}
