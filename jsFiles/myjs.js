function updateMovs() {
    $.ajax({
        type: "POST",
        url: "actualizar_movs.php",
        success: function (msg) {
            alert("Movimientos Aceptados");
            location.reload();
        }
    });
}
$(document).ready(function () {
    function highlight(e) {
        if (selected[0])
            selected[0].className = '';
        e.target.parentNode.className = 'selected';
    }
    var table = document.getElementById('records_table'),
            selected = table.getElementsByClassName('selected');
    table.onclick = highlight;
    function fnselect() {
        var $row = $(this).parent().find('td');
        var clickeedID = $row.eq(0).text();
        alert(clickeedID);
    }

    //Accion del boton 
    $('#btnClear').click(function () {
        $('#form-register').trigger("reset");
    });

//Codigo para implementar los componentes de primeui
//    $('#tblremotelazy').puidatatable({
//        lazy: true,
//        caption: 'Remote Restful Webservice - Lazy',
//        paginator: {
//            rows: 5,
//            totalRecords: 200
//        },
//        columns: [
//            {field: 'codigo_asociado', headerText: 'Codigo Asociado', sortable: true},
//            {field: 'nombres_completos', headerText: 'Nombre', sortable: true},
//            {field: 'usuario', headerText: 'Usuario', sortable: true},
//            {field: 'tipo_usuario', headerText: 'Tipo Usuario', sortable: true},
//            {field: 'codigo_tarjeta', headerText: 'Codigo Tarjeta', sortable: true}
//        ],
//        datasource: function (callback, ui) {
//            var uri = '../controller/loadTable.php';
//
//            $.ajax({
//                type: "GET",
//                url: uri,
//                dataType: "json",
//                context: this,
//                success: function (response) {
//                    callback.call(this, response);
//                }
//            });
//        }
//    });
//    $('#messages').puigrowl();

});