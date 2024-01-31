export class ErrorWindow {
    static #errorWindow;

    static make(text) {
        // Si hay una ventana abierta previamente, borrarla enseguida
        if (ErrorWindow.#errorWindow) {
            ErrorWindow.#errorWindow.remove();
        }
        const div = document.createElement('div');
        ErrorWindow.#errorWindow = div;
        const p = document.createElement('p');

        div.classList.add('error', 'entry');
        p.textContent = text;

        div.appendChild(p);
        document.body.appendChild(div);

        setTimeout(() => {
            div.classList.add('leave');
            div.addEventListener('animationend', () => {
                div.remove();
            })
        }, 5000);
    }
}