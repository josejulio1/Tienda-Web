export class PreviewImage {
    constructor(htmlSelector, inputId) {
        this.$label = $(htmlSelector);
        const input = document.createElement('input');
        const imgPlus = document.createElement('img');
        const imgPreview = document.createElement('img');

        input.type = 'file';
        input.classList.add('image');
        input.hidden = true;
        input.id = inputId;
        imgPlus.src = '/assets/img/web/svg/add.svg';
        imgPlus.alt = 'Plus';
        imgPreview.classList.add('photo-preview', 'hide');
        imgPreview.alt = 'Photo Preview';

        this.$label.html(input.outerHTML + imgPlus.outerHTML + imgPreview.outerHTML);
        this.initEvents();
    }

    initEvents() {
        this.$label.on('change', e => {
            const target = e.target;
            const imagenMostrar = target.nextElementSibling.nextElementSibling;
            const reader = new FileReader();
            reader.addEventListener('loadend', () => {
                imagenMostrar.src = reader.result;
            })
            reader.readAsDataURL(target.files[0]);
            target.nextElementSibling.classList.add('hide'); // Ocultar foto de suma
            imagenMostrar.classList.remove('hide');
        })
    }
}