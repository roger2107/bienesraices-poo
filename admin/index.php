<?php
    // mostrar errores de php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //require '../includes/funciones.php';
    require '../includes/app.php';
    estaAutenticado();

    use App\Propiedad;
    use App\Vendedor;

    //Implementar un método para obtener todas las propiedades
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();
  
    //Muestra mensaje condicional
    $resultado = $_GET['resultado']??null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){

            $tipo = $_POST['tipo'];
            
            if(validarTipoContenido($tipo)){
                //Comparar lo que se va a eliminar
                if($tipo === 'vendedor'){
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }else if($tipo === 'propiedad'){
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }  
        }
    }

    //echo $_GET['resultado'];
    
    //Incluye un template
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de BienesRaices</h1>  
        
        <?php
            $mensaje = mostrarNotificacion(intval($resultado));

            if($mensaje){ ?>
                <p class="alerta exito"> <?php echo s($mensaje) ?> </p>
            <?php }?>

        <a href="/bienesraices-poo/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
        <a href="/bienesraices-poo/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo Vendedor</a>

        <h2>Propiedades</h2>
        <table class="propiedades">
            <thead>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </thead>
            <tbody> <!-- Mostrar los resulados -->

                <?php  foreach($propiedades as $propiedad): ?>
                <tr>
                    <td> <?php echo $propiedad->id; ?> </td>
                    <td> <?php echo $propiedad->titulo; ?> </td>
                    <td><img src="/bienesraices-poo/imagenes/<?php echo $propiedad->imagen; ?>" alt="imagen casa" class="imagen-tabla"></td>   
                    <td>$<?php echo $propiedad->precio; ?></td>
                    <td> 
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php  echo $propiedad->id ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/bienesraices-poo/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Vendedores</h2>
        <table class="propiedades">
            <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </thead>
            <tbody> <!-- Mostrar los resulados -->

                <?php  foreach($vendedores as $vendedor): ?>
                <tr>
                    <td> <?php echo $vendedor->id; ?> </td>
                    <td> <?php echo $vendedor->nombre . " " . $vendedor->apellido; ?> </td>
                    <td> <?php echo $vendedor->telefono; ?></td>
                    <td> 
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php  echo $vendedor->id ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/bienesraices-poo/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    
    
<?php

   
    
    incluirTemplate('footer');
?>