function delay(f, ms) {
    return new Proxy(f, {
        apply(target, thisArg, args) {
            setTimeout(() => target.apply(thisArg, args), ms);
        }
    });
}

function searchInCalendar(e) {
    if (e.target.classList.contains('js-search-categories-input')) {

        let parentContainer;
        if (!document.querySelector('.tab-label-user')) {
            parentContainer = document.querySelector('.js-main-container');
        } else {
            parentContainer = document.querySelector('.tab-section:not(.hidden) .js-main-container');
        }
        let input = e.target;

        /** everything to uppercase, and remove accents */
        let filter = input.value.toUpperCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

        let i;
        let divEl;
        let txtValue;
        let rows = parentContainer.querySelectorAll('.js-row');

        for (i = 0; i < rows.length; i++) {

            divEl = rows[i].querySelector(".js-search-text");
            txtValue = divEl.textContent || divEl.innerText;

            if (txtValue.toUpperCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").indexOf(filter) > -1) {
                /** show if match */
                rows[i].classList.remove('hidden');
            } else {
                /** hide if not match */
                rows[i].classList.add('hidden');
            }
        }
    }
}