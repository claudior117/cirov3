<?php
    //clases propias globales
    $s = new App\Controllers\clases();

   
?>



<?= $this->extend('Views/plantilla/plantillaAdmin');?>

<!--declaracion de la seccion a incrustar en la plantilla -->
<?= $this->section('Principal'); ?>

<div class="container "> 
        <div class="copyright d-flex justify-content-end" >
           <strong>Bienvenido<?= " " . session('usuario'); ?></strong> 
        </div>    
</div>    

<main id="main">
  <section id="about" class="about">
      
      <div class="container" data-aos='fade-up' >
            <div class="row">
              <div class="col mb-1 mx-3 LineaTituloP d-flex justify-content-end">
                Modificar datos de la Obra Social
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
      
    
      <!--Formulario de Datos-->
    
      <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-9">
            <form action="<?=site_url();?>OsGuardar/U" method="POST">
                <div class ="form-group d-flex justify-content-end">
                    <input  type="text" size="7" class="" id="idIdOs" name="nameIdOs" readonly value='<?= $arregloItems->id_os; ?>'>
                </div>
              
              <div class="form-group"> 
                <label for="idOs" class="control-label fs-6">Obra Social:</label>
                <input type="text" class="form-control" id="idOs" name="nameOs" value='<?= $arregloItems->os; ?>'>
                <div><p class="text-danger"><small><?=session('errors.nameOs');?></small></p> </div>
              </div>    

              <div class="form-group d-flex justify-content-end"> <!-- Submit Button -->
                  <button type="submit" class="btn btn-sm btn-danger mt-3">Guardar</button>
              </div>  
            </form>
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
<script src="<?= base_url(); ?>js/os/os.js"></script>
  


<?= $this->endSection(); ?>
