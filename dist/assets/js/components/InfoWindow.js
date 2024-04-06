/**
 * Componente que hace que aparezca una ventana con un texto personalizado en la parte superior
 * de la pantalla.
 */
export class InfoWindow {
    static #infoWindow;

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