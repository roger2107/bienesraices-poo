<?php
    // mostrar errores de php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require 'includes/app.php';

    use App\Propiedad;

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id){
        header('Location: /bienesraices-poo/index.php');
    }

    $propiedad = Propiedad::find($id);
    
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad->titulo;  ?></h1>

        <img loading="lazy" src="/bienesraices-poo/imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio">

        <div class="resumen-propiedad">
            <p class="precio">$<?php echo $propiedad->precio;  ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="/bienesraices-poo/build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad->wc;  ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="/bienesraices-poo/build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad->estacionamiento;  ?></p>
                </li>
                <li>
                    <img class="icono"  loading="lazy" src="/bienesraices-poo/build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad->habitaciones;  ?></p>
                </li>
            </ul>

            <p><?php echo $propiedad->descripcion;  ?></p>

           
        </div>
    </main>

    <?php
        incluirTemplate('footer');
    ?>