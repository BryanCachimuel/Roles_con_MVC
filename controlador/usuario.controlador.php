<?php

class ctrlUsuarios
{

    static public function ctrlMostrarUsuarios()
    {
        $tabla = "usuarios";
        $respuesta = mdlUsuarios::mdlMostrarUsuarios($tabla);

        return $respuesta;
    }

    static public function ctrlMostrarUsuarios1($item, $valor)
    {
        $tabla = "usuarios";
        $respuesta = mdlUsuarios::mdlMostrarUsuarios1($tabla, $item, $valor);

        return $respuesta;
    }

    static public function ctrGuardarusuarios()
    {
        if (isset($_POST["nom_usuarios"])) {
            if (isset($_FILES["subirImgusuarios"]["tmp_name"]) && !empty($_FILES["subirImgusuarios"]["tmp_name"])) {
                list($ancho, $alto) = getimagesize($_FILES["subirImgusuarios"]["tmp_name"]);
                $nuevoAncho = 480;
                $nuevoAlto = 382;

                /* se crea el directorio donde se va a guardar la foto del usuario */
                $directorio = "vista/imagenes/usuarios";

                /* de acuerdo al tipo de imagen aplicamos las funciones por defecto de php */
                if ($_FILES["subirImgusuarios"]["type"] == "image/jpeg") {
                    $aleatorio = mt_rand(100, 999);
                    $ruta = $directorio . "/" . $aleatorio . ".jpg";
                    $origen = imagecreatefromjpeg($_FILES["subirImgusuarios"]["tmp_name"]);
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                    imagejpeg($destino, $ruta);
                } else if ($_FILES["subirImgusuariosE"]["type"] == "image/png") {
                    $aleatorio = mt_rand(100, 999);
                    $rutas = $directorio . "/" . $aleatorio . ".png";
                    $origen = imagecreatefrompng($_FILES["subirImgusuariosE"]["tmp_name"]);
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagealphablending($destino, FALSE);
                    imagesavealpha($destino, TRUE);
                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                    imagepng($destino, $rutas);
                } else {
                    echo '<script>
							swal({
									type:"error",
								  	title: "¡CORREGIR!",
								  	text: "¡No se permiten formatos diferentes a JPG y/o PNG!",
								  	showConfirmButton: true,
									confirmButtonText: "Cerrar"		  
							}).then(function(result){

									if(result.value){   
									    history.back();
									  } 
							});
						</script>';

                    return;
                }

                /* se encripa la contraseña */
                $encriptarPassword = crypt($_POST["pass_user"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                $datos = array(
                    "nom_usuario" => $_POST["nom_usuarios"],
                    "nom_user" => $_POST["nom_user"],
                    "pass_user" => $encriptarPassword,
                    "rol_user" => $_POST["rol_user"],
                    "foto" => $ruta
                );

                //echo "</pre>";  print_r($datos); echo "</pre>";
                $tabla = "usuarios";
                $respuesta = mdlUsuarios::mdlguardarUsuarios($tabla, $datos);

                if ($respuesta == "ok") {
                    echo '<script>
                    swal({
                            type:"success",
                              title: "¡CORRECTO!",
                              text: "El usuario ha sido creado correctamente",
                              showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                          
                    }).then(function(result){

                            if(result.value){   
                                history.back();
                              } 
                    });
                </script>';
                } else {
                    echo "<div class='alert alert-danger mt-3 small'>registro fallido</div>";
                }
            }
        }
    }

    static public function ctrEditarusuarios()
    {
        if (isset($_POST["idPerfilE"])) {
            if (isset($_FILES["subirImgUsuarios"]["tmp_name"]) && !empty($_FILES["subirImgUsuarios"]["tmp_name"])) {
                list($ancho, $alto) = getimagesize($_FILES["subirImgUsuarios"]["tmp_name"]);
                $nuevoAncho = 480;
                $nuevoAlto = 382;

                /* creamos el directorio donde vamos a guardar la foto del usuario */
                $directorio = "vista/images/usuarios";

                /* primer se pregunta si existe otra imagen en la base de datos */
                if (isset($_POST["fotoActualE"])) {
                    unlink($_POST["fotoActualE"]);
                }

                /* de acuerdo al tipo de imagen se aplica las funciones por defecto de php */
                if ($_FILES["subirImgusuariosE"]["type"] == "image/jpeg") {
                    $aleatorio = mt_rand(100, 999);
                    $rutas = $directorio . "/" . $aleatorio . ".jpg";
                    $origen = imagecreatefromjpeg($_FILES["subirImgusuariosE"]["tmp_name"]);
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                    imagejpeg($destino, $rutas);
                } else if ($_FILES["subirImgusuariosE"]["type"] == "image/png") {
                    $aleatorio = mt_rand(100, 999);
                    $rutas = $directorio . "/" . $aleatorio . ".png";
                    $origen = imagecreatefrompng($_FILES["subirImgusuariosE"]["tmp_name"]);
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagealphablending($destino, FALSE);
                    imagesavealpha($destino, TRUE);
                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                    imagepng($destino, $rutas);
                } else {
                    echo '<script>
							swal({
									type:"error",
								  	title: "¡CORREGIR!",
								  	text: "¡No se permiten formatos diferentes a JPG y/o PNG!",
								  	showConfirmButton: true,
									confirmButtonText: "Cerrar"
								  
							}).then(function(result){

									if(result.value){   
									    history.back();
									  } 
							});
						 </script>';
                    return;
                }

                if ($rutas != "") {
                    $r = $rutas;
                } else {
                    $r = $_POST["fotoActualE"];
                }
                if ($_POST["pass_userE"] != "") {
                    $password = crypt($_POST["pass_userE"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                } else {
                    $password = $_POST["pass_userActualE"];
                }

                $datos = array(
                    "idE" => $_POST["idPerfilE"],
                    "nom_usuarioE" => $_POST["nom_usuarioE"],
                    "nom_userE" => $_POST["nom_userE"],
                    "passE" => $password,
                    "rol_userE" => $_POST["rol_userE"],
                    "img" => $r
                );

                $tabla = "usuarios";
                $respuesta = mdlUsuarios::mdlEditarUsuarios($tabla, $datos);

                if ($respuesta == "ok") {

                    echo '<script>
                            swal({
                                    type:"success",
                                    title: "¡CORRECTO!",
                                    text: "El usuario ha sido editado correctamente",
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar"
                                
                            }).then(function(result){

                                    if(result.value){   
                                        history.back();
                                    } 
                            });
                            </script>';
                } else {

                    echo "<div class='alert alert-danger mt-3 small'>editada fallida</div>";
                }
            }
        }
    }

    static public function  ctrEliminarUsuarios($id ,$rutafoto){

		unlink("../".$rutafoto);		
		$tabla = "usuarios";
		$respuesta = mdlUsuarios::mdlEliminarUsuarios($tabla, $id);

		return $respuesta;

}

}
