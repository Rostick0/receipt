import axios from 'axios';
import './bootstrap';

const throttle = (func, ms) => {
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

const classOnce = {
    remove: function (elem, className) {
        if (elem?.classList?.toggle(className)) {
            elem.classList.remove(className)
        }
    },
    add: function (elem, className) {
        if (!elem?.classList?.toggle(className)) {
            elem.classList.add(className)
        }
    }
}

const useState = (defaultValue = null) => {
    let value = defaultValue;
    const getValue = () => value;
    const setValue = newValue => value = newValue;
    return [getValue, setValue];
}

const [receiptActiveId, setReceiptActiveId] = useState();
const [selectedFolderStar, setSelectedFolderStar] = useState();

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
    const modals = document.querySelectorAll('.modal');

    modals.forEach(item => {
        item.onclick = function (e) {
            if (e.target == this) {
                classOnce.remove(item, '_active')
            }
        }
    });
})();

(function () {
    const receiptItems = document.querySelectorAll('.receipt-item');
    const modalFolders = document.querySelector('.modal-folders');
    const modalFoldersList = document.querySelector('.modal-folders__list');

    const getFolder = async (params = {}, hasEmptyFolders = false) => {
        const res = await axios.get('/api/folder', {
            params: {
                ...params,
                limit: 5
            },
        });

        const data = res?.data?.data?.data;

        if (hasEmptyFolders && !res?.data?.data.total) {
            modalFoldersList.innerHTML = `<span>Отсутствуют папки, вы можете <a class="link" href="/folder/create">создать</a></span>`;
        } else {
            data?.forEach(item => {
                modalFoldersList.insertAdjacentHTML('beforeend',
                    `<label class="checbox modal-folders__checkbox">
                    <input class="checbox__input modal-folders__input" ${item?.folder_receipts?.length ? 'checked' : ''} type="checkbox" value="${item?.id}">
                    <span class="checbox__icon"></span>
                    <span class="label__title">${item?.name}</span>
                </label>`);
            })
        }

        return res;
    }

    receiptItems?.forEach(item => {
        const more = item.querySelector('.receipt-item__more');
        const folderStar = item.querySelector('.receipt-item__star');

        if (more) more.onclick = () => item.classList.toggle('_active');

        if (folderStar && modalFolders) {

            const [isTotalPage, setIsTotalPage] = useState(false);
            const [page, setPage] = useState(1);

            folderStar.onclick = async function () {
                classOnce.add(modalFolders, '_active');

                setSelectedFolderStar(folderStar);

                const id = folderStar.getAttribute('data-id');
                setReceiptActiveId(id);

                modalFoldersList.innerHTML = "";

                getFolder({
                    receipt_id: id
                }, true);

                modalFoldersList.onscroll = throttle(async function (e) {
                    if (isTotalPage()) {
                        modalFoldersList.onscroll = null;
                    }

                    setPage(page() + 1);
                    if (this.scrollTop > (this.scrollHeight - this.clientHeight) - this.lastElementChild.getBoundingClientRect().height * 3) {
                        const res = await getFolder({
                            receipt_id: id,
                            page: page(),
                        })

                        if (res?.data?.data?.current_page >= res?.data?.data?.last_page) {
                            setIsTotalPage(true);
                        }
                    }
                }, 200);
            };
        }

        if (folderStar?.classList?.contains('_remove')) {
            folderStar.onclick = async () => {
                const folderReceiptId = folderStar.getAttribute('data-folder-receipt-id');
                const res = await axios.delete(`/api/folder-receipt/${folderReceiptId}`);

                item?.remove()
            }
        }
    })

    if (modalFolders) {
        const modalFolderBtn = modalFolders.querySelector('.modal-folders__btn');

        modalFolderBtn.onclick = async () => {
            const modalFoldersInputs = document.querySelectorAll('.modal-folders__input');

            const folderStar = selectedFolderStar();

            const folders = [...modalFoldersInputs]?.filter(item => item.checked).map(item => item?.value)?.join(',');

            const res = await axios.post('/api/folder-receipt', {
                folders,
                receipt_id: receiptActiveId(),
            });

            if (folders) {
                classOnce.add(folderStar, '_active')
            } else {
                classOnce.remove(folderStar, '_active')
            }

            classOnce.remove(modalFolders, '_active');
        };
    }
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

            classOnce.add(formResult, '_active');

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

                    formResultErrors.insertAdjacentHTML('beforeend',
                        `<div>Элемент под индексом: ${item?.index}</div>
                        <div>${divErrors}</div>
                        <br />
                        <br />`);
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

(function () {
    const inputProductDisable = document.querySelector('.input-product__disable');
    const checkboxProdictDisable = document.querySelector('.checkbox-prodict__disable');
    const exactTitle = document.querySelector('#exact_title');

    if (!inputProductDisable) return;

    if (checkboxProdictDisable) {
        checkboxProdictDisable.onchange = e => {
            inputProductDisable.disabled = e.target?.checked;
        }
    }

    const setExactTitle = () => {
        inputProductDisable.name = exactTitle?.checked ? 'filterEQ[products.name]' : 'filterLIKE[products.name]';
    };

    if (exactTitle) {
        exactTitle.onchange = setExactTitle;
   
        setExactTitle();
    }

})();

