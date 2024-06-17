/**
 * Crea un componente DOM de un botón asíncrono que al pulsarlo, le aparece una animación de cargando
 * @author josejulio1
 * @version 1.0
 */
export class LoadingButton {
    /**
     * Constructor de LoadingButton.
     * @param buttonSelector {string} Nombre del selector en el DOM
     * @param pText {string} Texto que se quiere asignar al botón
     * @param onClickListener {function} Operación que se desea realizar al pulsar el botón
     */
    constructor(buttonSelector, pText, onClickListener) {
        this.$button = $(buttonSelector);
        const p = document.createElement('p');
        const img = document.createElement('img');

        p.id = 'button-p';
        p.textContent = pText;
        img.id = 'button-loading';
        img.classList.add('hide');
        img.src = '/assets/img/web/components/loading-button/loading.svg';
        img.alt = 'Loading';

        this.initEvents(onClickListener);
        this.$button.html(p.outerHTML + img.outerHTML);
    }

    /**
     * Establece un evento que al hacer click, accionará el callback pasado como parámetro en el constructor
     * @param onClickListener {function} Callback a ejecutar al pulsar click en el botón
     */
    initEvents(onClickListener) {
        this.$button.on('click', e => {
            e.preventDefault();
            onClickListener($('#button-p'), $('#button-loading'));
        })
    }
}