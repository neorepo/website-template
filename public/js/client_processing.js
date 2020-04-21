// DataTable
$(document).ready(function () {
    let user_id;
    let action = 2;

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
            { 'data': 'user_name' },
            { 'data': 'first_name' },
            { 'data': 'last_name' },
            { 'data': 'gender' },
            { 'data': 'password' },
            { 'data': 'status' },
            { 'data': 'created_on' },
            { 'data': 'last_modified_on' },
            {
                'defaultContent': `<div class="text-center">
                                        <a href="javascript:void(0)" class="edit-icon" title="Editar usuario">
                                            <i class="material-icons edit">edit</i></a>&nbsp;&nbsp;
                                        <a href="javascript:void(0)" class="delete-icon" title="Eliminar usuario">
                                            <i class="material-icons delete">delete</i></a>
                                    </div>`
            }
        ]
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

    function capital_letters(str) {
        str = str.split(" ");
        let n = str.length;
        for (var i = 0, x = n; i < x; i++) {
            str[i] = str[i][0].toUpperCase() + str[i].substr(1);
        }
        return str.join(" ");
    }
});