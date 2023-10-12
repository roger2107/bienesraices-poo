<?php
// mostrar errores de php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../includes/app.php';
use App\Vendedor;
estaAutenticado();

//Validar que sea un ID valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id){
    header('Location: /bienesraices-poo/admin/index.php');
}

//Obtener el arreglo del vendedor
$vendedor = Vendedor::find($id);

//Arreglo con mensajes de errores
$errores = Vendedor::getErrores();

//Ejecutar el codigo despues que el usuarrio envía el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Asignar los valores
    $args = $_POST['vendedor'];

    //Sincrinizar objeto en memoria con lo que el objeto escribió 
    $vendedor->sincronizar($args);
    
    //Validacion
    $errores = $vendedor->validar();

    if(empty($errores)){
        $vendedor->guardar();
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
	<h1>Actualizar Vendedor</h1>
	<a href="/bienesraices-poo/admin/index.php" class="boton boton-verde">Volver</a>

	<?php foreach($errores as $error): ?>
		<div class="alerta error">
			<?php echo $error; ?>
		</div>
		
	<?php endforeach ?>

	<form class="formulario" method="POST" >
		<?php include '../../includes/templates/formulario_vendedores.php' ?>    

		<input type="submit" value="Guardar Cambios" class="boton boton-verde">
	</form>
</main>

<?php
    incluirTemplate('footer');
?>