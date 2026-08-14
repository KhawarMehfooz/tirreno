import {BasePage} from './Base.js?v=0.10.1';
import {DeleteAccountPopUp} from '../parts/popup/DeleteAccountPopUp.js?v=0.10.1';

export class SettingsPage extends BasePage {
    constructor() {
        super('settings');
    }

    initUi() {
        new DeleteAccountPopUp();
    }
}
