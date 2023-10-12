<?php
// mostrar errores de php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../includes/app.php';

use App\Vendedor;

estaAutenticado();



//Arreglo con mensajes de errores
$errores = Vendedor::getErrores();
$vendedor = new Vendedor;

//Ejecutar el codigo despues que el usuarrio envía el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Crear una nueva instancia
    $vendedor = new Vendedor($_POST['vendedor']);
    
    //Validar que no haya campos vacíos
    $errores = $vendedor->validar();

    if(empty($errores)){
        $vendedor->guardar();
    }
    
}

incluirTemplate('header');
?>

	<main class="contenedor seccion">
        <h1>Registrar Vendedor</h1>
        <a href="/bienesraices-poo/admin/index.php" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
            
        <?php endforeach ?>

        <form class="formulario" method="POST" action="/bienesraices-poo/admin/vendedores/crear.php">
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>    
            <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
        </form>
	</main>

<?php
    incluirTemplate('footer');
?>