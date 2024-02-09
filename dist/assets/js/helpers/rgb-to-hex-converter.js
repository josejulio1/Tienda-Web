/**
 * Transforma un texto CSS rgb(x, y, z) a hexadecimal. Utilizado en el apartado de roles en admin
 * @param {string} rgb Texto CSS rgb(x, y, z)
 * @returns Devuelve en una cadena el equivalente en hexadecimal
 */
export function rgbToHex(rgb) {
    const rgbArray = rgb.replace('rgb(', '').replace(')', '').split(', ').map(num => parseInt(num));
    return `${convertHex(rgbArray[0])}${convertHex(rgbArray[1])}${convertHex(rgbArray[2])}`;
}

/**
 * Transforma un número decimal a código hexadecimal
 * @param {number} num Número a convertir a hexadecimal
 * @returns Devuelve el código hexadecimal del número del parámetro
 */
function convertHex(num) {
    let hex;
    const numHex = num.toString(16);
    if (num >= 16) {
        hex = numHex;
    } else {
        hex = `0${numHex}`
    }
    return hex;
}