export class SearchItem {
    constructor(id, rutaImagen, nombreProducto, precioProducto, numValoracion) {
        this.searchItem = document.createElement('div');
        const imagen = document.createElement('img');
        const descripcionContenedor = document.createElement('div');
        const nombreH2 = document.createElement('h2');
        const precioP = document.createElement('p');
        const contenedorEstrellas = document.createElement('div');
        let imagenEstrella;

        this.searchItem.setAttribute('item-id', id);
        this.searchItem.classList.add('search-bar--item');
        imagen.src = rutaImagen;
        imagen.alt = 'Imagen Item';
        descripcionContenedor.classList.add('search-bar--item__description');
        nombreH2.textContent = nombreProducto;
        precioP.classList.add('precio');
        precioP.textContent = `${precioProducto} €`;
        contenedorEstrellas.classList.add('search-bar--item__valoracion');

        this.searchItem.appendChild(imagen);
        descripcionContenedor.appendChild(nombreH2);
        descripcionContenedor.appendChild(precioP);
        descripcionContenedor.appendChild(precioP);
        for (let i = 0; i < 5; i++) {
            imagenEstrella = document.createElement('img');
            imagenEstrella.alt = 'Estrella';
            if (numValoracion-- > 0) {
                imagenEstrella.src = '/assets/img/web/svg/star-filled.svg';
            } else {
                imagenEstrella.src = '/assets/img/web/svg/star-no-filled.svg';
            }
            contenedorEstrellas.appendChild(imagenEstrella);
        }
        descripcionContenedor.appendChild(contenedorEstrellas);
        this.searchItem.appendChild(descripcionContenedor);
        this.searchItem.addEventListener('click', e => {
            window.location.href = `/producto/${e.target.getAttribute('item-id')}`;
        })
    }

    getItem() {
        return this.searchItem;
    }
}