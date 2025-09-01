<?php
    //clases propias globales
    $s = new App\Controllers\clases();

    use App\Models\RetMesModel;
     

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
      
      <div class="container mb-3 " data-aos="fade-up">
      
          <div class="row">
              <div class="col mb-3 mx-3 LineaTituloP d-flex justify-content-end">
                <strong>Agrega/Modifica retenciones en el período  </Strong> 
              </div>
          </div>  
         
           <div class="row no-print" >
             
            <div class="col-1 d-flex align-items-start">
                      <a class="btn_mc_mini_imprimir" id="idBtImprimir" data-toggle="tooltip" data-placement="top" title="Imprimir Listado de Retenciones"><i class="bi bi-printer-fill"></i></a>
            </div>
            
            <div class="col-3" style="margin:2px;">       
              <div class="input-group input-group-sm ">
              <label for="idSelProf" class="input-group-text labelcss">Profesional  </label>
              <?php
                $s->selectProfesionales("N");
               ?>
               
            </div>
            </div>
            <div class="col-3 d-flex align-items-start">
            <div class="input-group input-group-sm ">
              <label  class="input-group-text labelcss">Periodo:  </label>
              <input type="Number" id="idMes" class="form-control ms-1" min=1 max=12 value="<?=date("m");?>">
              <input type="Number" id="idAño" class="form-control ms-1" min=2023 value="<?=date("Y");?>"> 
            </div>
            </div>
            
            <div class="col-3 d-flex align-items-start">
            <div class="input-group input-group-sm ">
              <label for="idFecha" class="input-group-text labelcss">Fecha:  </label>
              <input type="text" id="idFecha" class="form-control ms-1" readonly value='<?=date("Y-m-d");?>'>
               
            </div>
            </div>
            
            <div class="col-1 d-flex justify-content-end ">
                        <a class="btn_mc_mini_volver align-middle" href="<?= site_url();?>RetencionesMes" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
            </div>


            </div>
        </div>   

           <!--Tabla de datos-->
    
        <div class="row">
          <div class="col-2"></div>
          <div class="col-8">
                <table class="table table-sm table-black-50 table-hover table-bordered  m-2" style="table-layout: fixed;" >
                    <thead class=''>
                   
                        <td class='text-center' style="width:10%;">Id</td>
                        <td class='text-center' style="width:45%;">Retencion</td>
                        <td class='text-center' style="width:15%;">Cantidad</td>
                        <td class='text-center' style="width:15%;">Pu</td>
                        <td class='text-center' style="width:15%;">Importe</td>
                        

                    </thead>
                    <tbody id="tb2" style="font-size:11px;">

           

                    </tbody>

                </table>
          </div>
       </div>



       <div class="row">
        <div class="col-2"></div>
        <div class="col-6">
            <p>Id: <input id="idIdVta" type="text" disabled > Estado Pago: <input id="idEstadoPago" type="text" disabled> </p> 
        </div>
        
        <div class="col-3">
          <p>Total: <input class="text-end" id="idTotal" type="text" disabled></p> 
        </div>
       </div>          
       
       <div class="row">
       <div class="col-10">    
       <div class="modal-footer">
                <a href="<?= site_url();?>InicioIntra"> <button type="button" id="idBtCerrar3" class="btn btn-sm btn-secondary me-3">Cerrar</button></a>
                    <?php
                      echo('<button id="idBtGuardar" type="button" class="btn btn-sm btn-danger">Guardar</button>');
                    ?>
                
         </div>
         </div>
         <center> <div id="idEspere" style="margin:3px; visibility:hidden;  background-color:#FF4A17;height:21px;width:90%; color:white;">| | | | | | | | | | | | | | | procesando . . .</div> </center>
     </div>
        
        <div class="row">
          
          <br>
          <br>
          
        </div>  
    </div>
      
    
</div>

        </div> 









  </section><!-- End About Section -->
 
</main><!-- End #main -->

 <!-- JS  --> 
 <script src="<?= base_url(); ?>public/js/ciro.js"></script>
 <script src="<?= base_url(); ?>public/js/ret/retmesman.js"></script>
 
 


  <?= $this->endSection(); ?> 
  
