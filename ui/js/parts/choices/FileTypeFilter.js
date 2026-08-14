import {BaseFilter} from './BaseFilter.js?v=0.10.1';
import {
    renderFileTypeSelectorItem,
    renderFileTypeSelectorChoice,
} from '../DataRenderers.js?v=0.10.1';

export class FileTypeFilter extends BaseFilter {
    constructor() {
        super(
            '#file-type-selectors',
            renderFileTypeSelectorItem,
            renderFileTypeSelectorChoice,
            'fileTypeFilterChanged'
        );
    }
}
