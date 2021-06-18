function validar() {
    var usuario = document.getElementById('usuario').value.trim();
    var password = document.getElementById('password').value.trim();

    if (usuario === '' || password === '') {
        Swal.fire(
            'Atencão...',
            'Todos os campos são necesarios',
            'erro'
        );
        return false;
    }
}