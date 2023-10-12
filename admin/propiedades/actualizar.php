<?php

    require '../../includes/app.php';
    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    estaAutenticado();
    // $auth = estaAutenticado();
    // if(!$auth){
    //     header('Location: /bienesraices-poo/index.php');
    // }

    //Validar el id en la URL
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /bienesraices-poo/admin/index.php');
    }

    //Consulta para obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);
    
    //Consulta para obtener todos los vendedores
    $vendedores = Vendedor::all();

    //Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    //Ejecutar el codigo despues que el usuarrio envía el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //Asignar los atributos
        $args=$_POST['propiedad'];
        
        $propiedad->sincronizar($args);
        
        //Validacion
        $errores = $propiedad->validar();

        //Subida de archivos
        //Generar nombre unico
        $nombreImagen = md5( uniqid(rand(), true) ) . ".jpg";

        if($_FILES['propiedad']['tmp_name']['imagen']){
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }
        //Revisar que el arreglo de errores esté vacío
        if(empty($errores)){
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $image->save(CARPETA_IMAGENES . $nombreImagen);
            }
            $propiedad->guardar(); 
        }      
    }

    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>
        <a href="/bienesraices-poo/admin/index.php" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
            
        <?php endforeach ?>

        <form class="formulario" method="POST"  enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php' ?>      
            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>