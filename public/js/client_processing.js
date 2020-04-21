// DataTable
$(document).ready(function () {
    let user_id;
    let action = 2;
    let row;

    // SELECT DATOS
    userTable = $('#dataTable').DataTable({
        'ajax': {
            'url': 'server_processing.php',
            'method': 'POST',
            'data': { action: action },
            'dataSrc': ''
        },
        // Campos de la tabla
        'columns': [
            { 'data': 'user_id' },
            { 'data': 'username' },
            { 'data': 'first_name' },
            { 'data': 'last_name' },
            { 'data': 'gender' },
            { 'data': 'password' },
            { 'data': 'status' },
            { 'data': 'created_on' },
            { 'data': 'last_modified_on' },
            {
                'defaultContent': `<span class="text-center">
                                        <a href="javascript:void(0)" class="edit-icon ml-2" title="Editar usuario">
                                            <i class="material-icons edit">edit</i></a>&nbsp;&nbsp;
                                        <a href="javascript:void(0)" class="delete-icon mr-2" title="Eliminar usuario">
                                            <i class="material-icons delete">delete</i></a>
                                    </span>`
            }
        ]
    });

    //submit para el Alta y Actualización
    $('#registerForm').submit(function (e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        username = $.trim($('#usuario').val());
        first_name = $.trim($('#nombre').val());
        last_name = $.trim($('#apellido').val());
        gender = $('input:radio[name=genero]:checked').val();
        password = $.trim($('#password').val());
        confirm_password = $.trim($('#confirm-password').val());
        status = $.trim($('#status').val());
        $.ajax({
            url: "server_processing.php",
            type: "POST",
            datatype: "json",
            data: {
                user_id: user_id, username: username, first_name: first_name,
                last_name: last_name, gender: gender, password: password,
                confirm_password: confirm_password, status: status, action: action
            },
            success: function (data) {
                userTable.ajax.reload(null, false);
            }
        });
        $('#registerModal').modal('hide');
    });

    //para limpiar los campos antes de dar de Alta una Persona
    $("#newUser").click(function () {
        action = 1; //alta           
        user_id = null;
        $("#registerForm").trigger("reset");
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Alta de Usuario");
        $('#registerModal').modal('show');
    });

    // ELIMINAR
    $(document).on("click", ".delete-icon", function () {
        row = $(this);
        user_id = parseInt($(this).closest('tr').find('td:eq(0)').text());
        action = 4; // acción eliminar
        var response = confirm("¿Está seguro de borrar el registro " + user_id + "?");
        if (response) {
            $.ajax({
                url: "server_processing.php",
                type: "POST",
                datatype: "json",
                data: { action: action, user_id: user_id },
                success: function () {
                    userTable.row(row.parents('tr')).remove().draw();
                }
            });
        }
    });
});