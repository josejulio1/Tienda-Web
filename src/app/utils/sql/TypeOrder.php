<?php
namespace Util\SQL;

use Model\Base\AbstractActiveRecord;

/**
 * Clase que define constantes para indicar al ORM el tipo de orden que se desea aplicar. Vea {@see AbstractActiveRecord}
 * @author josejulio1
 * @version 1.0
 */
class TypeOrder {
    public const ASC = 'ASC';
    public const DESC = 'DESC';
}