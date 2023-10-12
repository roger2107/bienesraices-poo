<?php
  // mostrar errores de php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require '../../includes/app.php';

    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;
 
    estaAutenticado();

    $propiedad = new Propiedad;
    
    //Consulta para obtener todos los vendedores
    $vendedores = Vendedor::all();
    //Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    //Ejecutar el codigo despues que el usuarrio envía el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $propiedad = new Propiedad($_POST['propiedad']);

        /**Subida de archivos */
        //Crear carpeta
        
        //Generar nombre unico
        $nombreImagen = md5( uniqid(rand(), true) ) . ".jpg";

        //Setear la imagen
        //Realiza un rezise con Intervention
        if($_FILES['propiedad']['tmp_name']['imagen']){
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }

        //Validar
        $errores = $propiedad->validar();
        //Revisar que el arreglo de errores esté vacío

        if(empty($errores)){
            

            //Crear la carpeta para subir imagenes
            if(!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }
            //Guarda la imagen en el servidor
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            //Guardar en la base de datos
            $propiedad->guardar();

            
        } 
    }
    
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/bienesraices-poo/admin/index.php" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach ?>

        <form class="formulario" method="POST" action="/bienesraices-poo/admin/propiedades/crear.php" enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php' ?>    

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>