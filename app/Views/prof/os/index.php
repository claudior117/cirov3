<?php
    //clases propias globales
    $s = new App\Controllers\clases();

?>

<?= $this->extend('Views/plantilla/plantilla');?>




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
              <strong>OBRAS SOCIALES y ARANCELES </strong> 
              </div>
            </div>  
         
            <!--Botones Superiores -->         
            <div class="row">
              <div class="col-1 d-flex align-items-center">
                        <a class="btn_mc_mini_mostrar" id="idBtMostrar" data-toggle="tooltip" data-placement="top" title="Mostrar"><i class="bi bi-file-text-fill"></i></a>
                        <a class="btn_mc_mini_imprimir" id="idBtImprimir" data-toggle="tooltip" data-placement="top" title="Imprimir"><i class="bi bi-printer-fill"></i></a>
              </div>
              
              <div class="col-9"></div>
              <div class="col- d-flex justify-content-end">
                        <a class="btn_mc_mini_volver" href="<?= site_url();?>InicioIntra" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
              </div>
                       
            </div>
            <!--Fin botones superiores -->   
      </div>
      
   
   
      <!--Tabla de datos-->
    <div class="container"> 
        <div class="row">
            <div class="col-2"></div>
            <div class="col-7">
                <table class="table tablacss table-sm table-black-50 table-hover table-bordered m-2">
                    <thead class="cabtablacss">
                        <td>Acciones</td>
                        <td>Id</td>
                        <td>Obras Social</td>
                        <td>Ult.Actu</td>
                        
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb1" style="font-size:13px;">

                    </tbody>

                </table>
                
                <br>
                <br>
               
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
<script src="<?= base_url(); ?>js/ciro.js"></script>
<script src="<?= base_url(); ?>js/os/osP.js"></script>
<script>buscaDatos()</script>





<?= $this->endSection(); ?>
