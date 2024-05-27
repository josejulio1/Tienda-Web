import {ajax} from "../api/ajax.js";
import {END_POINTS} from "../api/end-points.js";
import {ActiveRecord} from "./ActiveRecord";

export class Cliente extends ActiveRecord {
    static tableName = 'Cliente';

    Cliente(data = []) {
        this.id = data['id'] ?? 0;
        this.nombre = data['nombre'] ?? '';
        this.apellidos = data['apellidos'] ?? '';
        this.telefono = data['telefono'] ?? '';
        this.direccion = data['direccion'] ?? '';
        this.correo = data['correo'] ?? '';
        this.contrasenia = data['contrasenia'] ?? '';
        this.rutaImagenPerfil = data['ruta_imagen_perfil'] ?? '';
    }

    #validate() {

    }

    create() {
        if (this.#validate()) {

        }
        return ajax();
    }
}