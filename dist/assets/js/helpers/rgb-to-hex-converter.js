/**
 * Transforma un texto CSS rgb(x, y, z) a hexadecimal. Utilizado en el apartado de roles en admin
 * @param {string} rgb Texto CSS rgb(x, y, z)
 * @returns Devuelve en una cadena el equivalente en hexadecimal
 */
export function rgbToHex(rgb) {
    const rgbArray = rgb.replace('rgb(', '').replace(')', '').split(', ').map(num => parseInt(num));
    return `${rgbArray[0].toString(16)}${rgbArray[1].toString(16)}${rgbArray[2].toString(16)}`;
}