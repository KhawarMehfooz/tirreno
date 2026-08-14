import {EventPanel} from './EventPanel.js?v=0.10.1';
import {renderJsonTextarea} from '../DataRenderers.js?v=0.10.1';

export class FieldPanel extends EventPanel {
    constructor() {
        let eventParams = {
            enrichmentUrl: false,
            type: 'field',
            url: `${window.app_base}/fieldEventDetails`,
            cardId: 'field-card',
            panelClosed: 'fieldPanelClosed',
            closePanel: 'closeFieldPanel',
            rowClicked: 'fieldTableRowClicked',
        };
        super(eventParams);
    }
}
