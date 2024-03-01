window.addEventListener('load', () => {
    $('.hero').trigger('play');
})

// Al pulsar sobre un producto, redirigir a la página de visualizar el producto
$('.producto__item').on('click', e => {
    window.location.href = `/views/producto.php?id=${e.target.getAttribute('item-id')}`
})