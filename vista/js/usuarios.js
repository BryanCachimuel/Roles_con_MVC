$(".tablaUsuarios").DataTable({
  deferRender: true,
  retrieve: true,
  processing: true,
  language: {
    sProcessing: "Procesando...",
    sLengthMenu: "Mostrar _MENU_ registros",
    sZeroRecords: "No se encontraron resultados",
    sEmptyTable: "Ningún dato disponible en esta tabla",
    sInfo: "Mostrando registros del _START_ al _END_",
    sInfoEmpty: "Mostrando registros del 0 al 0",
    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    sInfoPostFix: "",
    sSearch: "Buscar:",
    sUrl: "",
    sInfoThousands: ",",
    sLoadingRecords: "Cargando...",
    oPaginate: {
      sFirst: "Primero",
      sLast: "Último",
      sNext: "Siguiente",
      sPrevious: "Anterior",
    },
    oAria: {
      sSortAscending: ": Activar para ordenar la columna de manera ascendente",
      sSortDescending:
        ": Activar para ordenar la columna de manera descendente",
    },
  },
});

/*=============================================
Subir imagen temporal usuarios
=============================================*/

$("input[name='subirImgusuarios']").change(function () {
  var imagen = this.files[0];

  /*===============================================
VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
================================================*/

if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
    $("input[name='subirImgusuarios']").val("");

    swal({
      title: "Error al subir la imagen",
      text: "¡La imagen debe estar en formato JPG o PNG!",
      type: "error",
      confirmButtonText: "¡Cerrar!",
    });
} else if (imagen["size"] > 2000000) {
    $("input[name='subirImgusuarios']").val("");

    swal({
      title: "Error al subir la imagen",
      text: "¡La imagen no debe pesar más de 2MB!",
      type: "error",
      confirmButtonText: "¡Cerrar!",
    });
  } else {
    var datosImagen = new FileReader();
    datosImagen.readAsDataURL(imagen);

    $(datosImagen).on("load", function (event) {
      var rutaImagen = event.target.result;

      $(".previsualizarImgusuarios").attr("src", rutaImagen);
    });
  }
});

/* editar usuario */
$(".tablaUsuarios").on("click",".btnEditarUsuario", function(){
  var idUsuario = $(this).attr("idUsuario");
  var datos = new FormData();
  datos.append("idUsuario", idUsuario);

  $.ajax({
    url:"ajax/usuarios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    proccessData: false,
    dataType: "json",
    success: function(respuesta){
      $("#idPerfilE").val(respuesta["id"]);
      $("#nom_usuariosE").val(respuesta["nombre"]);
      $("#nom_userE").val(respuesta["usuario"]);
      $("#pass_userE").val(respuesta["password"]);
      $(".previsualizarImgusuarios").attr("src", respuesta("foto"));
      $("#fotoActualE").val(respuesta["foto"]);
      $("#pass_userActualE").val(respuesta["password"]);
    }
  });
})
