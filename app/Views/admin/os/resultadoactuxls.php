<?php
    //clases propias globales
    $s = new App\Controllers\clases();

?>

<?= $this->extend('Views/plantilla/plantillaAdmin');?>




<!--declaracion de la seccion a incrustar en la plantilla -->
<?= $this->section('Principal'); ?>

<div class="container"> 
      <div class="copyright d-flex justify-content-end">
       <strong><span>Bienvenido<?= " " . session('usuario'); ?></span></strong> 
      </div>    
    
    </div>    

  <main id="main">
   
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">
            <div class="row">
              <div class="col mb-1 mx-3 LineaTituloP d-flex justify-content-end">
                RESULTADO ACTUALIZACIÓN DE ARANCELES  :  
              </div>
            </div>  
         
            <!--Botones Superiores -->         
            <div class="row">
              <div class="col-1 d-flex align-items-center">
              </div>
              <div class="col-9"></div>
              <div class="col-2 d-flex justify-content-end">
                        <a class="btn_mc_mini_volver" href="<?= site_url();?>AdminOS" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
              </div>
                       
            </div>
            <!--Fin botones superiores -->   
      </div>
      
   
   
      <!--Tabla de datos-->
    <div class="container"> 
        <div class="row">
            <div class="col-2"></div>
            <div class="col-5">
            <?php
                echo("<p>Procesados        : " . $Procesados . "</p>");
                echo("<p>Modificados       : " . $Modificados. "</p>");
                echo("<p>No existe en OS   : " .  $NuevosOs. "</p>");
                echo("<p>No existe en Min  : " .  $NuevosOs. "</p>");
                echo("<p>Errores     : " .  $Errores. "</p>");
            ?>

               
            </div>
           
        </div>
    </div>
    </div>
    
</div>

        </div> 

  </section><!-- End About Section -->
 <center> <div id="idEspere" style="margin:3px; visibility:hidden;background-color:#FF4A17;height:21px;width:90%; color:white;">| | | | | | | | | | | | | | | procesando . . .</div> </center>
 
</main><!-- End #main -->



<!-- JS -->
<script src="<?= base_url(); ?>js/minimos/min.js"></script>
  
<?php
//Mensaje del crud ok  
  echo("<script>
  Swal.fire({
    position: 'center',
    icon: 'success',
    title: 'Aranceles actualizados',
    showConfirmButton: false,
    timer: 1100
  })</script>");
?>




<?= $this->endSection(); ?>




<?php

?>