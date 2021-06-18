$('#tableInscricoes').DataTable();
var tableInscricoes;

window.addEventListener('DOMContentLoaded', function() {
    tableInscricoes = $('#tableInscricoes').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
        },
        "ajax": {
            "url": "./models/inscricoes/table_inscricoes.php",
            "dataSrc": ""
        },
        "columns": [
            { "data": "inscricao_id" },
            { "data": "nome" },
            { "data": "nome_materia" },
            { "data": "tipo_turno" },
            { "data": "statusI" },
            { "data": "options" },
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "asc"]
        ]
    });

    // CREAR INSCRicao
    var formInscricao = document.querySelector('#formInscricao');
    formInscricao.onsubmit = function(e) {
        e.preventDefault();

        var idInscricao = document.querySelector('#idInscricao').value;
        var aluno = document.querySelector('#listAluno').value;
        var curso = document.querySelector('#listCurso').value;
        var turno = document.querySelector('#listTurno').value;
        var status = document.querySelector('#listStatus').value;

        if (aluno == '' || curso == '' || turno == '' || status == '') {
            swal('Atencão', 'Todos os campos são necessarios', 'error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = './models/inscricoes/ajax_inscricoes.php';
        var formData = new FormData(formInscricao);
        request.open('POST', ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $('#modalFormInscricao').modal('hide');
                    formInscricao.reset();
                    swal('Criar Inscricao', objData.msg, 'success');
                    tableInscricoes.ajax.reload(function() {
                        editInscricao();
                        delInscricao();
                    })
                } else {
                    swal('Atencão', objData.msg, 'error');
                }
            }
        }

    }
});

window.addEventListener('load', function() {
    editInscricao();
    delInscricao();
    getOptionAlunos();
    getOptionCursos();
    getOptionTurnos();
}, false);

function getOptionAlunos() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = './models/options/options-alunos.php';
    request.open('GET', ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var option = JSON.parse(request.responseText);
            option.forEach(function(valor) {
                option += '<option value="' + valor.aluno_id + '">' + valor.nome + ' ' + valor.apelido + '</option>';
            });
            document.querySelector('#listAluno').innerHTML = option;
        }
    }
}

function getOptionCursos() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = './models/options/options-cursos.php';
    request.open('GET', ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var option = JSON.parse(request.responseText);
            option.forEach(function(valor) {
                option += '<option value="' + valor.curso_id + '">Materia: ' + valor.nome_materia + ', Profesor: ' + valor.nome + '</option>';
            });
            document.querySelector('#listCurso').innerHTML = option;
        }
    }
}

function getOptionTurnos() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = './models/options/options-turnos.php';
    request.open('GET', ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var option = JSON.parse(request.responseText);
            option.forEach(function(valor) {
                option += '<option value="' + valor.turno_id + '">' + valor.tipo_turno + '</option>';
            });
            document.querySelector('#listTurno').innerHTML = option;
        }
    }
}

function editInscricao() {
    var btnEditInscricao = document.querySelectorAll('.btnEditInscricao');
    btnEditInscricao.forEach(function(btnEditInscricao) {
        btnEditInscricao.addEventListener('click', function() {
            document.querySelector('#titleModal').innerHTML = 'Atualizar Inscricao';
            document.querySelector('.modal-header').classList.replace('headerRegister', 'updateRegister');
            document.querySelector('#btnActionForm').classList.replace('btn-primary', 'btn-info');
            document.querySelector('#btnText').innerHTML = 'Atualizar';

            var idInscricao = this.getAttribute('rl');

            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = './models/inscricoes/edit_inscricoes.php?id=' + idInscricao;
            request.open('GET', ajaxUrl, true);
            request.send();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        document.querySelector('#idInscricao').value = objData.data.inscricao_id;
                        document.querySelector('#listAluno').value = objData.data.aluno_id;
                        document.querySelector('#listCurso').value = objData.data.curso_id;
                        document.querySelector('#listTurno').value = objData.data.turno_id;
                        document.querySelector('#listStatus').value = objData.data.statusI;

                        if (objData.data.statusI == 1) {
                            var optionSelect = '<option value="1" selected class="notBlock">Ativo</option>';
                        } else {
                            var optionSelect = '<option value="2" selected class="notBlock">Inativo</option>';
                        }
                        var htmlOption = `${optionSelect}
                                    <option value="1">Ativo</option>
                                    <option value="2">Inativo</option>
                                        `;
                        document.querySelector('#listStatus').innerHTML = htmlOption;

                        $('#modalFormInscricao').modal('show');
                    } else {
                        swal('Atencão', objData.msg, 'error');
                    }
                }
            }
        })
    })
}

function delInscricao() {
    var btnDelInscricao = document.querySelectorAll('.btnDelInscricao');
    btnDelInscricao.forEach(function(btnDelInscricao) {
        btnDelInscricao.addEventListener('click', function() {
            var idInscricao = this.getAttribute('rl');

            swal({
                title: "Excluir Inscricao",
                text: "Realmente deseja excluir a inscricão?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim, excluir",
                cancelButtonText: "Não, cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(Confirm) {
                if (Confirm) {
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxDelInscricao = './models/inscricoes/delet_inscricao.php';
                    var strData = "idInscricao=" + idInscricao;
                    request.open('POST', ajaxDelInscricao, true);
                    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function() {
                        if (request.readyState == 4 && request.status == 200) {
                            var objData = JSON.parse(request.responseText);
                            if (objData.status) {
                                swal("Excluir!", objData.msg, "success");
                                tableInscricoes.ajax.reload(function() {
                                    delInscricao();
                                    editInscricao();
                                });
                            } else {
                                swal("Atencão", objData.msg, "error");
                            }
                        }
                    }
                }
            })
        })
    })
}

function openModalInscricao() {
    document.querySelector('#idInscricao').value = "";
    document.querySelector('#titleModal').innerHTML = 'Nova Inscrição';
    document.querySelector('.modal-header').classList.replace('updateRegister', 'headerRegister');
    document.querySelector('#btnActionForm').classList.replace('btn-info', 'btn-primary');
    document.querySelector('#btnText').innerHTML = 'Guardar';
    document.querySelector('#formInscricao').reset();
    $('#modalFormInscricao').modal('show');
}