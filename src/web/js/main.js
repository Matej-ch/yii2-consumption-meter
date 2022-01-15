document.addEventListener('DOMContentLoaded', () => {

    document.querySelector('body').addEventListener('change', e => {
        if (e.target.id === 'year-checkbox') {

        }
    })

    document.querySelector('body').addEventListener('click', e => {
        if (e.target.classList.contains('js-select-full-day')) {

        }
    });

    let savePrice = debounce(function (e) {
        if (e.target.classList.contains('js-price-input')) {
            console.log('hello');
        }
    }, 700);

    document.querySelector('body').addEventListener('input', savePrice);


    const debounce = (func, wait) => {
        let timeout;

        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };

            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };

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

})
