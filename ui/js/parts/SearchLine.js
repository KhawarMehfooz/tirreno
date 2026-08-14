import {Loader} from './Loader.js?v=0.10.1';
import {Tooltip} from './Tooltip.js?v=0.10.1';
import {handleAjaxError} from './utils/ErrorHandler.js?v=0.10.1';
import {padZero} from './utils/Date.js?v=0.10.1';
import {formatSearchResult} from './DataRenderers.js?v=0.10.1';

export class SearchLine {
    constructor() {
        this.loader = new Loader();

        Tooltip.addTooltipsToClock();

        const me = this;
        const token = document.head.querySelector('[name=\'csrf-token\'][content]').content;
        const url = `${window.app_base}/search?token=${token}`;

        $('#auto-complete').autocomplete({
            serviceUrl: url,
            deferRequestBy: 300,
            minChars: 3,
            groupBy: 'category',
            showNoSuggestionNotice: true,
            noSuggestionNotice: 'Sorry, no matching results',
            formatResult: formatSearchResult,

            onSelect: function(suggestion) {
                window.open(`${window.app_base}/${suggestion.entityId}/${suggestion.id}`, '_self');
            },

            onSearchStart: function(params) {
                params.query = params.query.trim();
                me.loaderDiv.classList.remove('is-hidden');
                me.loader.start(me.loaderDiv);

            },
            onSearchComplete: function(query, suggestions) {
                me.loader.stop();
                me.loaderDiv.classList.add('is-hidden');
            },

            onSearchError: handleAjaxError,
        });
    }

    onTypeLinkClick(e) {
        e.preventDefault();

        this.queryTypeLinks.forEach(link => link.classList.remove('active'));
        e.target.classList.add('active');

        return false;
    }

    getActiveQueryTypeItem() {
        const activeLink = this.queryTypeControl.querySelector('a.active');
        const activeType = activeLink.dataset.value;

        return activeType;
    }

    get loaderDiv() {
        return document.querySelector('.searchline').querySelector('div.text-loader');
    }

    get queryTypeLinks() {
        return this.queryTypeControl.querySelectorAll('A');
    }

    get queryTypeControl() {
        return document.querySelector('nav.filters-form.search');
    }
}
