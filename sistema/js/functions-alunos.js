$('#tableAlunos').DataTable();
var tableAlunos;

document.addEventListener('DOMContentLoaded', function() {
    tableAlunos = $('#tableAlunos').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
        },
        "ajax": {
            "url": "./models/alunos/table_alunos.php",
            "dataSrc": ""
        },
        "columns": [
            { "data": "aluno_id" },
            { "data": "nome" },
            { "data": "apelido" },
            { "data": "idade" },
            { "data": "endereco" },
            { "data": "celula" },
            { "data": "telefone" },
            { "data": "email" },
            { "data": "data_nasc" },
            { "data": "status" },
            { "data": "options" }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "asc"]
        ]
    });

    // CREAR ALUNOS
    var formALunos = document.querySelector('#formAluno');
    formALunos.onsubmit = function(e) {
        e.preventDefault();
        var idAluno = document.querySelector('#idAluno').value;
        var nome = document.querySelector('#txtNome').value;
        var apelido = document.querySelector('#txtApelido').value;
        var idade = document.querySelector('#idade').value;
        var endereco = document.querySelector('#txtEndereco').value;
        var celula = document.querySelector('#celula').value;
        var telefone = document.querySelector('#telefone').value;
        var email = document.querySelector('#email').value;
        var dataNasc = document.querySelector('#dataNasc').value;
        var status = document.querySelector('#listStatus').value;

        if (nome == '' || apelido == '' || idade == '' || endereco == '' || celula == '' || telefone == '' || email == '' || dataNasc == '' || status == '') {
            swal('Atencion', 'Todos los campos son necesarios', 'error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = './models/alunos/ajax-alunos.php';
        var formAluno = new FormData(formALunos);
        request.open('POST', ajaxUrl, true);
        request.send(formAluno);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $('#modalFormAluno').modal('hide');
                    formALunos.reset();
                    swal('Crear ALuno', objData.msg, 'success');
                    tableAlunos.ajax.reload(function() {
                        editAluno();
                        delAluno();
                    })
                } else {
                    swal('Atencion', objData.msg, 'error');
                }
            }
        }
    }
});

window.addEventListener('load', function() {
    editAluno();
    delAluno();
}, false);

function editAluno() {
    var btnEditAluno = document.querySelectorAll('.btnEditAluno');
    btnEditAluno.forEach(function(btnEditAluno) {
        btnEditAluno.addEventListener('click', function() {
            document.querySelector('#titleModal').innerHTML = 'Atualizar Aluno';
            document.querySelector('.modal-header').classList.replace('headerRegister', 'updateRegister');
            document.querySelector('#btnActionForm').classList.replace('btn-primary', 'btn-info');
            document.querySelector('#btnText').innerHTML = 'Atualizar';

            var idAluno = this.getAttribute('rl');

            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = './models/alunos/edit_alunos.php?id=' + idAluno;
            //var strData = 'idAluno='+idAluno;
            request.open('GET', ajaxUrl, true);
            request.send();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    if (request.status) {
                        var objData = JSON.parse(request.responseText);
                        document.querySelector('#idAluno').value = objData.data.aluno_id;
                        document.querySelector('#txtNome').value = objData.data.nome;
                        document.querySelector('#txtApelido').value = objData.data.apelido;
                        document.querySelector('#idade').value = objData.data.idade;
                        document.querySelector('#txtEndereco').value = objData.data.endereco;
                        document.querySelector('#celula').value = objData.data.celula;
                        document.querySelector('#telefone').value = objData.data.telefone;
                        document.querySelector('#email').value = objData.data.email;
                        document.querySelector('#dataNasc').value = objData.data.data_nasc;
                        document.querySelector('#listStatus').value = objData.data.status;

                        $('#modalFormAluno').modal('show');
                    } else {
                        swal('Atenção', objData.msg, 'erro');
                    }
                }
            }
        });
    });
};

function delAluno() {
    var btnDelAluno = document.querySelectorAll('.btnDelAluno');
    btnDelAluno.forEach(function(btnDelAluno) {
        btnDelAluno.addEventListener('click', function() {
            var idAluno = this.getAttribute('rl');
            swal({
                title: "Eliminar Aluno",
                text: "Realmente desea eliminar el aluno?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(confirm) {
                if (confirm) {
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxUrl = './models/alunos/del_alunos.php';
                    var strData = 'idAluno=' + idAluno;
                    request.open('POST', ajaxUrl, true);
                    request.setRequestHeader('Content-type', 'Application/x-www-form-urlencoded');
                    request.send(strData);
                    request.onreadystatechange = function() {
                        if (request.readyState == 4 && request.status == 200) {
                            var objData = JSON.parse(request.responseText);
                            if (objData.status) {
                                swal("Eliminar!", objData.msg, "success");
                                tableAlunos.ajax.reload(function() {
                                    editAluno();
                                    delAluno();
                                });
                            } else {
                                swal("Atencion", objData.msg, "error");
                            }
                        }
                    }
                }
            })
        })
    })
}

function openModalAluno() {
    document.querySelector('#idAluno').value = "";
    document.querySelector('#titleModal').innerHTML = 'Novo ALuno';
    document.querySelector('.modal-header').classList.replace('updateUpdate', 'headerRegister');
    document.querySelector('#btnActionForm').classList.replace('btn-info', 'btn-primary');
    document.querySelector('#btnText').innerHTML = 'Guardar';
    document.querySelector('#formAluno').reset();
    $('#modalFormAluno').modal('show');
}