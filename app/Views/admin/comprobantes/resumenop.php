<?php
    //clases propias globales
    $s = new App\Controllers\clases();
   
    
?>



<?= $this->extend('Views/plantilla/plantillaAdmin');?>

<!--declaracion de la seccion a incrustar en la plantilla -->
<?= $this->section('Principal'); ?>

<div class="container">
      <div class="copyright d-flex justify-content-end">
       <strong><span>Hola<?= " " . session('usuario'); ?></span></strong> 
      </div>    
      
    </div>    

  <main id="main">
    <!-- ======= Socios Section ======= -->
    <section id="about" class="about">
      
      <div class="container mb-3 " >
      
            <div class="row">
              <div class="col mb-3 LineaTituloP d-flex justify-content-end">
                <strong>Ingresos(Rbos) por profesional</Strong> 
              </div>
            </div>  
         
           <div class="row ">
             
            <div class="col-1 d-flex ">
                      <a class="btn_mc_mini_imprimir" id="idBtImprimir" data-toggle="tooltip" data-placement="top" title="Imprimir Listado de Liquidaciones"><i class="bi bi-printer-fill"></i></a>
            </div>
             
            <div class="col-3" style="margin:2px;">       
              <div class="input-group input-group-sm ">
              <label for="idSelCliente" class="input-group-text labelcss">Cliente:  </label>
              <?php
                $s->selectClientes("S");
               ?>
               
            </div>
            </div>

            <div class="col-4" style="margin:3px;">       
              <div class="input-group input-group-sm ">
                <label for="idFechaD" class="input-group-text labelcss">Desde: </label>
                <input type="Date" id="idFechaD" class="form-control ms-1 me-5">
              
                <label for="idFechaH" class="input-group-text labelcss">Hasta: </label>
                <input type="Date" id="idFechaH" class="form-control ms-1 fs-8">
              </div>
            </div>

            <div class="col-2">
            <div class="input-group input-group-sm ">
              <label for="idSelTrans" class="input-group-text labelcss">Estado:</label>
              <select id="idSelTrans" class="form-control form-select">
                <option value="T">**Todos**</option>
                <option value="P">Transferidos</option>
                <option value="N">Sin Transferir</option>
              </select>
            </div>


            </div>

            <div class="col-1 d-flex justify-content-end ">
                        <a class="btn_mc_mini_volver align-middle" href="<?= site_url();?>InicioIntra" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
                     
                      </div>

            </div>
        
        
           <!--Tabla de datos-->
    <div class="container">
        <div class="row">
        
            <div class="col-12">
                <table class="table tablacss table-sm table-black-50 table-hover table-bordered m-2">
                    <thead class="cabtablacss">
                        
                        <td class='text-center'>Profesional</td>
                        <td class='text-center'>Recibo</td>
                        <td class='text-center'>Liq</td>
                        <td class='text-center'>Factura</td>
                        <td class='text-center'>Liquidado</td>
                        <td class='text-center'>Descuento</td>
                        <td class='text-center'>Incremento</td>
                        <td class='text-center'>Anticipo</td>
                        <td class='text-center'>Ingresado(Rbo)</td>
                        <td class='text-center'>Tran</td>
                        <td class='text-center'>F.Rbo</td>
                        <td class='text-center'>F.Tran</td>
                        
                        

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
<script src="<?= base_url(); ?>public/js/comprobantes/resumenop.js"></script>






<?= $this->endSection(); ?>





