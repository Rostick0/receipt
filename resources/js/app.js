import './bootstrap';

export const throttle = (func, ms) => {
    let locked = false

    return function () {
        if (locked) return

        const context = this
        const args = arguments

        locked = true

        setTimeout(() => {
            func.apply(context, args)
            locked = false
        }, ms)
    }
}

(function () {
    const selectAsyncSearch = document.querySelectorAll('.select-async-search');

    selectAsyncSearch?.forEach(item => {
        const selectSwitch = item.querySelector('.select-async-search__switch');
        const selectInput = item.querySelector('.select-async-search__name');
        const selectList = item.querySelector('.select-async-search__list');
        const selectSearch = item.querySelector('.select-async-search__search');

        let isObserve = false;
        let page = 0;

        const toggleActive = () => {
            item.classList.toggle('_active');
        };

        selectSwitch.onclick = () => {
            toggleActive();
        };

        const initialClick = () => {
            const selectItems = item.querySelectorAll('.select-async-search__item');
            selectItems?.forEach(selectItem => {
                const radioInput = selectItem.querySelector('.select-async-search__value')

                radioInput.onclick = () => {
                    selectInput.value = selectItem.textContent.trim();
                    toggleActive();
                }
            });
        };

        initialClick();

        const search = async () => {
            page += 1;

            const response = await fetch(item.getAttribute('data-url') + '?' + new URLSearchParams({
                "filterLIKE[name]": selectSearch.value,
                limit: 40,
                page
            }));
            const { data } = await response?.json();

            data?.data?.forEach(dataItem => {
                selectList.insertAdjacentHTML('beforeend',
                    `<li class="select-async-search__item">
                        <label>
                            ${dataItem?.name}
                            <input class="input select-async-search__value" type="radio" name="okved_id" value="${dataItem?.id}" ${dataItem?.id == item.getAttribute('data-item-id') ? 'checked' : ''} hidden>
                        </label>
                    </li>`
                );
            });

            if (data?.current_page <= data?.last_page) {
                isObserve = true
            } else {
                isObserve = false;
            }

            initialClick();
        };

        const clearList = () => {
            page = 0;
            selectList.innerHTML = "";
        };

        const visibleObserver = () => {
            if (!isObserve) return;

            search();
        };

        const observer = new IntersectionObserver(throttle(visibleObserver, 300), {
            threshold: 1
        });

        const selectObserver = item.querySelector('.select-async-search__observer');
        observer.observe(selectObserver);

        isObserve = true;

        selectSearch.oninput = throttle(() => {
            clearList();
            search();
        }, 1000);
    });
})();

(function () {
    const receiptItems = document.querySelectorAll('.receipt-item');

    receiptItems?.forEach(item => {
        const more = item.querySelector('.receipt-item__more');

        more.onclick = () => item.classList.toggle('_active');
    })
})();

(function () {
    const formUploadJson = document.querySelector('#form-upload-json');

    if (!formUploadJson) return;

    formUploadJson.onsubmit = async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        const formProps = Object.fromEntries(formData);
        console.log(formProps);

        try {
            const res = await axios.post('/api/receipt-upload', formProps, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });

            if (res?.status >= 400) return;

            const { data } = res;

            const formResult = document.querySelector('#form-result');
            const formResultCount = formResult.querySelector('.form-result__count');
            const formResultErrors = formResult.querySelector('.form-result__errors');

            if (!formResult.classList.contains('_active')) formResult.classList.add('_active');

            formResultCount.textContent = data?.count;
            console.log(data?.errors);

            if (data?.errors?.length) {
                data?.errors?.forEach(item => {
                    let divErrors = '';
                    console.log(item);
                    if (item?.errors) {
                        for (const [key, value] of Object.entries(item?.errors)) {
                            divErrors += `${key}:&ensp;${value}<br />`;
                            console.log(key, value);
                        }
                    }

                    formResultErrors.insertAdjacentHTML('beforeend', `
                        <div>Элемент под индексом: ${item?.index}</div>
                        <div>${divErrors}</div>
                        <br />
                        <br />
                `);
                });
            }
        } catch (e) {
            alert('Некорректный файл');
        }
    }

})();

(function () {
    const receiptGetDetails = document.querySelectorAll('.receipt-get-details');

    receiptGetDetails?.forEach(item => {
        const receiptGetDetailsSwitch = item.querySelector('.receipt-get-details__switch');
        const checkboxSummary = item.querySelector('.checkbox__summary');

        receiptGetDetailsSwitch.onclick = () => {
            if (checkboxSummary) checkboxSummary.checked = !checkboxSummary.checked;
        };
    })
})();