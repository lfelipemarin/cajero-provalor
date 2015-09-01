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
    $('#btnClear').click(function() {
        $('#form-register').trigger("reset");
    });
});