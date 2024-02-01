const { body } = document;
const $panelInfo = $('.panel--info');
const $openClosePanel = $('.open-close-panel');

$openClosePanel.on('click', () => {
    if ($panelInfo.hasClass('hide')) {
        $panelInfo.removeClass('hide');
        if (window.innerWidth > 1024) {
            body.classList.remove('close-panel');
            body.classList.add('open-panel');
        } else {
            body.classList.remove('close-panel-mobile');
            body.classList.add('open-panel-mobile');
        }
    } else {
        $panelInfo.addClass('hide');
        if (window.innerWidth > 1024) {
            body.classList.add('close-panel');
        } else {
            body.classList.add('close-panel-mobile');
            body.addEventListener('animationend', removeOpenPanelMobileListener);
        }
    }
})

window.addEventListener('load', () => {
    if (window.innerWidth <= 1024) {
        $panelInfo.addClass('hide');
        body.classList.add('close-panel-mobile');
    }
})

function removeOpenPanelMobileListener() {
    body.classList.remove('open-panel-mobile');
    body.removeEventListener('animationend', removeOpenPanelMobileListener);
}