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
              ¡¡ATENCION: Está por eliminar de forma permanente una prestación de los Mínimos Odontológicos de la Base de datos. Realize esta operación con responsabilidad!!!
              </div>
            </div> 
              
            <!--Botones Superiores -->         
            <div class="row">
              <div class="col-1 d-flex align-items-center">
              </div>
              <div class="col-9"></div>
              <div class="col-2 d-flex justify-content-end">
                        <a class="btn_mc_mini_volver" href="<?= site_url();?>Minimos" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
              </div>
                       
            </div>
            <!--Fin botones superiores -->   
      
      </div>
      
    
      <!--Formulario de Datos-->
    
      <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-9">
            <form id="FormularioCrud" action="<?=site_url('/MinGuardar/D');?>" method="POST">
                <div class ="form-group d-flex justify-content-end">
                    <input  type="text" size="7" class="" id="idIdItem" name="nameIdItem" readonly value='<?= $arregloItems['id_item']; ?>'>
                </div>
              
              <div class="form-group"> 
                <label for="idItem" class="control-label fs-6">Mínimo:</label>
                <input type="text" class="form-control" id="idItem" name="nameItem" value='<?= $arregloItems['item']; ?>'>
                <div><p class="text-danger"><small><?=session('errors.nameItem');?></small></p> </div>
              </div>    

              <div class="form-group d-flex justify-content-end"> <!-- Submit Button -->
                  <button type="submit" class="btn btn-sm btn-danger mt-3">Eliminar</button>
              </div>  
            </form>

            <!-- Alerta de confirmacion--> 
            <script type="text/javascript">
              (function() {
                var form = document.getElementById('FormularioCrud');
                form.addEventListener('submit', function(event) {
               if (!confirm('Confirma eliminar?')) {
                  event.preventDefault();
                }
                }, false);
              })();
            </script>
            

            

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
<script src="<?= base_url(); ?>public/js/ciro.js"></script>
<script src="<?= base_url(); ?>public/js/os/os.js"></script>
  


<?= $this->endSection(); ?>
