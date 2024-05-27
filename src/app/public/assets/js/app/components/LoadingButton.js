export class LoadingButton {
    constructor(buttonSelector, pText, onClickListener) {
        this.$button = $(buttonSelector);
        const p = document.createElement('p');
        const img = document.createElement('img');

        p.id = 'button-p';
        p.textContent = pText;
        img.id = 'button-loading';
        img.classList.add('hide');
        img.src = '/assets/img/web/svg/loading.svg';
        img.alt = 'Loading';

        this.initEvents(onClickListener);
        this.$button.html(p.outerHTML + img.outerHTML);
    }

    initEvents(onClickListener) {
        this.$button.on('click', e => {
            e.preventDefault();
            onClickListener($('#button-p'), $('#button-loading'));
        })
    }
}