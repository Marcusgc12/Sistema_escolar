$('#tableProfessores').DataTable();
var tableProfessores;

document.addEventListener('DOMContentLoaded', function() {
    tableProfessores = $('#tableProfessores').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
        },
        "ajax": {
            "url": "./models/professores/table_professores.php",
            "dataSrc": ""
        },
        "columns": [
            { "data": "professor_id" },
            { "data": "nome" },
            { "data": "apelido" },
            { "data": "endereco" },
            { "data": "celula" },
            { "data": "telefone" },
            { "data": "email" },
            { "data": "nivel_est" },
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

    // CREAR PROFESsOR
    var formProfessor = document.querySelector('#formProfessor');
    formProfessor.onsubmit = function(e) {
        e.preventDefault();
        var idProfessor = document.querySelector('#idProfessor').value;
        var nome = document.querySelector('#txtNome').value;
        var apelido = document.querySelector('#txtApelido').value;
        var endereco = document.querySelector('#txtEndereco').value;
        var celula = document.querySelector('#celula').value;
        var telefone = document.querySelector('#telefone').value;
        var email = document.querySelector('#email').value;
        var nivelEst = document.querySelector('#nivelEst').value;
        var status = document.querySelector('#listStatus').value;

        if (nome == '' || apelido == '' || endereco == '' || celula == '' || telefone == '' || email == '' || nivelEst == '' || status == '') {
            swal('Atencion', 'Todos os campos são necessarios', 'erro');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = './models/professores/ajax-professores.php';
        var formData = new FormData(formProfessor);
        request.open('POST', ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $('#modalFormProfessor').modal('hide');
                    formProfessor.reset();
                    swal('Criar Professor', objData.msg, 'success');
                    tableProfessores.ajax.reload(function() {
                        editProfessor();
                        delProfessor();
                    });
                } else {
                    swal('Atencão', objData.msg, 'erro');
                }
            }
        }
    }
});

function editProfessor() {
    var btnEditProfessor = document.querySelectorAll('.btnEditProfessor');
    btnEditProfessor.forEach(function(btnEditProfessor) {
        btnEditProfessor.addEventListener('click', function() {
            document.querySelector('#titleModal').innerHTML = 'Actualizar Professor';
            document.querySelector('.modal-header').classList.replace('headerRegister', 'updateRegister');
            document.querySelector('#btnActionForm').classList.replace('btn-primary', 'btn-info');
            document.querySelector('#btnText').innerHTML = 'Actualizar';

            var idProfessor = this.getAttribute('rl');

            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = './models/professores/edit_professores.php?id=' + idProfessor;
            request.open('GET', ajaxUrl, true);
            request.send();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        document.querySelector('#idProfessor').value = objData.data.professor_id;
                        document.querySelector('#txtNome').value = objData.data.nome;
                        document.querySelector('#txtApelido').value = objData.data.apelido;
                        document.querySelector('#txtEndereco').value = objData.data.endereco;
                        document.querySelector('#celula').value = objData.data.celula;
                        document.querySelector('#telefone').value = objData.data.telefone;
                        document.querySelector('#email').value = objData.data.email;
                        document.querySelector('#nivelEst').value = objData.data.nivel_est;
                        document.querySelector('#listStatus').value = objData.data.status;

                        if (objData.data.status == 1) {
                            var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
                        } else {
                            var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
                        }

                        var htmlSelect = `${optionSelect}
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option> 
                                        `;
                        document.querySelector("#listStatus").innerHTML = htmlSelect;

                        $("#modalFormProfessor").modal("show");
                    } else {
                        swal('Atencion', objData.msg, 'error');
                    }
                }
            }
        })
    })
};

function delProfessor() {
    var btnDelProfessor = document.querySelectorAll('.btnDelProfessor');
    btnDelProfessor.forEach(function(btnDelProfessor) {
        btnDelProfessor.addEventListener('click', function() {
            var idProfessor = this.getAttribute('rl');
            swal({
                title: "Eliminar Professor",
                text: "Realmente desea eliminar el professor?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(Confirm) {
                if (Confirm) {
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxDelProfessor = './models/professores/delet_professor.php';
                    var strData = "idProfessor=" + idProfessor;
                    request.open('POST', ajaxDelProfessor, true);
                    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function() {
                        if (request.readyState == 4 && request.status == 200) {
                            var objData = JSON.parse(request.responseText);
                            if (objData.status) {
                                swal("Eliminar!", objData.msg, "success");
                                tableProfessores.ajax.reload(function() {
                                    editProfessor();
                                    delProfessor();
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

window.addEventListener('load', function() {
    editProfessor();
    delProfessor();
}, false);

function openModalProfessor() {
    document.querySelector('#idProfessor').value = "";
    document.querySelector('#titleModal').innerHTML = 'Nuevo Professor';
    document.querySelector('.modal-header').classList.replace('updateRegister', 'headerRegister');
    document.querySelector('#btnActionForm').classList.replace('btn-info', 'btn-primary');
    document.querySelector('#btnText').innerHTML = 'Guardar';
    document.querySelector('#formProfessor').reset();
    $('#modalFormProfessor').modal('show');
}