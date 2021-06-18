<div class="modal fade" id="modalFormCurso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Novo Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile-body">
                <form id="formCurso" name="formCurso">
                    <input type="hidden" name="idCurso" id="idCurso" value="">
                    <div class="form-group">
                        <label for="exampleSelect1">Materia</label>
                        <select class="form-control" name="listMateria" id="listMateria" required>
                            <!-- CONTENIDO AJAX -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Professor</label>
                        <select class="form-control" name="listProfessor" id="listProfessor" required>
                            <!-- CONTENIDO AJAX -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Estado</label>
                        <select class="form-control" name="listStatus" id="listStatus" required>
                            <option value="1">Ativo</option>
                            <option value="2">Inativo</option>
                        </select>
                    </div>
                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
