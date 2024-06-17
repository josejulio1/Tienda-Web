/**
 * Crea un componente DOM que se utiliza para subir una imagen en un formulario y previsualizar la imagen subida
 * antes de subirla al servidor
 * @author josejulio1
 * @version 1.0
 */
export class PreviewImage {
    /**
     * Constructor de PreviewImage.
     * @param htmlSelector {string} Selector del DOM donde se encuentra la etiqueta a situar el componente
     * @param inputId {string} ID que tendrá el input de la imagen
     */
    constructor(htmlSelector, inputId) {
        this.$label = $(htmlSelector);
        const input = document.createElement('input');
        const imgPlus = document.createElement('img');
        const imgPreview = document.createElement('img');

        input.type = 'file';
        input.classList.add('image');
        input.hidden = true;
        input.id = inputId;
        imgPlus.src = '/assets/img/web/components/preview-image/add.svg';
        imgPlus.alt = 'Plus';
        imgPreview.classList.add('photo-preview', 'hide');
        imgPreview.alt = 'Photo Preview';

        this.$label.html(input.outerHTML + imgPlus.outerHTML + imgPreview.outerHTML);
        this.initEvents();
    }

    /**
     * Inicia el evento de la imagen. Al subir la imagen al formulario, se accionará un evento que permitirá
     * previsualizar la imagen en el navegador
     */
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