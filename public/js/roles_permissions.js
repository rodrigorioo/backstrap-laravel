/** FUNCIONES */

function initTable(roleId) {

    $.ajax({
        url: "/api/roles/" + roleId,
        method: 'GET',
    }).done( (response) => {

        let permissions = [];
        response.permissions.forEach( (permission, iPermission) => {
            permissions.push(permission.id);
        });

        table.rows( ( idx, data, node) => {

            if(permissions.includes(parseInt(data[1]))) {

                let set = $(node).find('td:first-child .checkable');
                $(set).prop('checked', true);
                $(node).toggleClass('active');
            }
        });

    }).fail( () => {
        Swal.fire("¡Error!", "Error al obtener el rol del usuario", "error");
    });
}

/** END HELPER FUNCTIONS */

let table = null;

$(document).ready( () => {

    table = $('table').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },

        headerCallback: function(thead, data, start, end, display) {
            thead.getElementsByTagName('th')[0].innerHTML = `
                    <label class="checkbox checkbox-single">
                        <input type="checkbox" value="" class="group-checkable"/>
                        <span></span>
                    </label>`;
        },

        columnDefs: [
            {
                targets: 0,
                width: '30px',
                className: 'dt-left',
                orderable: false,
                render: function(data, type, full, meta) {
                    return `
                        <label class="checkbox checkbox-single">
                            <input type="checkbox" value="" class="checkable"/>
                            <span></span>
                        </label>`;
                },
            },
            {
                targets: 1,
                visible: false,
                searchable: false
            },
        ],
    });

    table.on('change', '.group-checkable', function() {
        let set = $(this).closest('table').find('td:first-child .checkable');
        let checked = $(this).is(':checked');

        $(set).each(function() {
            if (checked) {
                $(this).prop('checked', true);
                $(this).closest('tr').addClass('active');
            }
            else {
                $(this).prop('checked', false);
                $(this).closest('tr').removeClass('active');
            }
        });
    });

    table.on('change', 'tbody tr .checkbox', function() {
        $(this).parents('tr').toggleClass('active');
    });

    $('form').submit( (e) => {

        let selectedRows = table.rows('.active').data();

        const selected_permissions = $('#selected-permissions');
        selected_permissions.empty();
        for(let i = 0; i < selectedRows.length; i++) {
            let row = selectedRows[i];

            selected_permissions.append(
                '<input type="hidden" name="permissions[]" value="' + parseInt(row[1]) + '">'
            );
        }
    });

    initTable($('input[name="id"]').val());
});
