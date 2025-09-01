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
    <!-- ======= Socios Section ======= -->
    <section id="about" class="about">
      
      <div class="container mb-3 " >
      
            <div class="row">
              <div class="col mb-3 LineaTituloP d-flex justify-content-end">
                <strong>Flujo prestasdores percapita</Strong> 
              </div>
            </div>  
         
           <div class="row ">
             
            <div class="col-1">
                      <a class="btn_mc_mini_imprimir" id="idBtImprimir" data-toggle="tooltip" data-placement="top" title="Imprimir "><i class="bi bi-printer-fill"></i></a>
            </div>
             
            <div class="col-3" style="margin:2px;">       
              <div class="input-group input-group-sm ">
              <label for="idSelCliente" class="input-group-text labelcss">Prestador</label>
              <?php
                $s->selectClientesPercapita("S");
               ?>
               
            </div>
            </div>

            <div class="col-3" style="margin:3px;">       
              <div class="input-group input-group-sm w-75 ">

                <label for="idFecha" class="input-group-text labelcss">Desde: </label>
                <input type="Date" id="idFecha" class="form-control ms-1">
                
              </div>
            </div>

           

            <div class="col-3 d-flex justify-content-end ">
                        <a class="btn_mc_mini_volver align-middle" href="<?= site_url();?>InicioIntra" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
            </div>

            </div>


            
           <!--Tabla de datos-->
    <div class="container">
        <div class="row">
        <div class="col-1"> </div>
            <div class="col-10">
                <table class="table tablacss table-sm table-black-50 table-hover table-bordered m-2">
                    <thead class="cabtablacss">
                        <td></td>
                        <td class='text-center'>Fecha</td>
                        <td>Prestador</td>
                        <td>Detalle</td>
                        <td>Periodo</td>
                        <td class='text-end'>Subtotal</td>
                        <td class='text-end'>Otros Tributos</td>
                        <td class='text-end'>Importe Percapita</td>
                        <td class='text-end'>Total</td>
                        <td class='text-end'>Acum. Percapita</td>
                        
                        
                        
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
<script src="<?= base_url(); ?>public/js/ciro.js"></script>  
<script src="<?= base_url(); ?>public/js/percapita/percapita.js"></script>


<?= $this->endSection(); ?>





