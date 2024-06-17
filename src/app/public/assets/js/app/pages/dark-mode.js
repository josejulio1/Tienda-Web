const $darkButton = $('#dark-button');
const $lightButton = $('#light-button');

// Fichero que se encarga de la lógica del modo claro-oscuro

window.addEventListener('load', () => {
    const isDarkModeEnabled = window.sessionStorage.getItem('dark-mode');
    if (isDarkModeEnabled && isDarkModeEnabled === 'false') {
        return;
    }

    // Recuperar la preferencia del usuario en caso de que exista
    // Detectar si el usuario tiene puesto el modo oscuro en su sistema operativo o navegador
    if (isDarkModeEnabled === 'true' || window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.body.classList.add('dark-mode');
        $darkButton.addClass('hide');
        $lightButton.removeClass('hide');
    }
})

$darkButton.on('click', () => {
    $lightButton.removeClass('hide');
    $darkButton.addClass('hide');
    document.body.classList.add('dark-mode');
    window.sessionStorage.setItem('dark-mode', 'true');
})

$lightButton.on('click', () => {
    $darkButton.removeClass('hide');
    $lightButton.addClass('hide');
    document.body.classList.remove('dark-mode');
    window.sessionStorage.setItem('dark-mode', 'false');
})