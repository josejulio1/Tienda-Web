<div class="modal modal-unique fade" id="modal-info" tabindex="-1" aria-labelledby="modal-info" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img id="modal-info-correcto" class="hide" src="/assets/img/web/admin/modal/success.svg" alt="Correcto">
                <img id="modal-info-incorrecto" class="hide" src="/assets/img/web/admin/modal/error.svg" alt="Error">
                <p id="modal-info-mensaje"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-unique fade" id="modal-choice" tabindex="-1" aria-labelledby="modal-choice" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img src="/assets/img/web/admin/modal/choice.svg" alt="Decisión">
                <div class="modal-body__info">
                    <p>¿Está seguro de que desea eliminar el registro?</p>
                    <p class="modal-body__info--important">No podrá revertir los cambios</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="modal-choice-accept">Aceptar</button>
                <button class="btn btn-secondary" id="modal-choice-cancel">Cancelar</button>
            </div>
        </div>
    </div>
</div>