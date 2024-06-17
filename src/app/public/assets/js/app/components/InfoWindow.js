/**
 * Componente que hace que aparezca una ventana con un texto personalizado en la parte superior
 * de la pantalla.
 * @author josejulio1
 * @version 1.0
 */
export class InfoWindow {
    static #infoWindow;

    /**
     * Genera una ventana de información en la parte superior de la pantalla, que mostará el texto que se le pase por parámetrp
     * @param text {string} Texto que se quiere mostrar en el componente
     * @param successWindow {boolean} True si es un mensaje de éxito (color de fondo verde) y false si es de error (color de fondo rojo)
     */
    static make(text, successWindow = false) {
        // Si hay una ventana abierta previamente, borrarla enseguida
        if (InfoWindow.#infoWindow) {
            InfoWindow.#infoWindow.remove();
        }
        const div = document.createElement('div');
        InfoWindow.#infoWindow = div;
        const p = document.createElement('p');

        div.classList.add(successWindow ? 'success' : 'error', 'entry');
        p.textContent = text;

        div.appendChild(p);
        document.body.appendChild(div);

        // Eliminar ventana a los 5 segundos
        setTimeout(() => {
            div.classList.add('leave');
            div.addEventListener('animationend', () => {
                div.remove();
            })
        }, 5000);
    }
}