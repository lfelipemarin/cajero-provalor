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