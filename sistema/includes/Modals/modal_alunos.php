<div class="modal fade" id="modalFormAluno" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Novo Aluno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile-body">
                <form id="formAluno" name="formAluno">
                    <input type="hidden" name="idAluno" id="idAluno" value="">
                    <div class="form-group">
                    <label class="control-label">Nome</label>
                    <input class="form-control" id="txtNome" name="txtNome" type="text" placeholder="Nome do aluno" required>
                    </div>
                    <div class="form-group">
                    <label class="control-label">Apelido</label>
                    <input type="text" class="form-control" id="txtApelido" name="txtApelido" placeholder="Apelido" required>
                    </div>
                    <div class="form-group">
                    <label class="control-label">Idade</label>
                    <input type="number" class="form-control" id="idade" name="idade" placeholder="idade">
                    </div>
                    <div class="form-group">
                    <label class="control-label">Endereço</label>
                    <input type="text" class="form-control" id="txtEndereco" name="txtEndereco" placeholder="Endereco">
                    </div>
                    <div class="form-group">
                    <label class="control-label">Celular</label>
                    <input type="text" class="form-control" id="celula" name="celula" placeholder="Celular">
                    </div>
                    <div class="form-group">
                    <label class="control-label">Telefone</label>
                    <input class="form-control" type="number" id="telefone" name="telefone" required>
                    </div>
                    <div class="form-group">
                    <label class="control-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
                    </div>
                    <div class="form-group">
                    <label class="control-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="dataNasc" name="dataNasc" placeholder="Data de Nascimento">
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