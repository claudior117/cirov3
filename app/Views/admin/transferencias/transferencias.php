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
      
      <div class="container mb-3 " data-aos="fade-up">
      
            <div class="row">
              <div class="col mb-3 LineaTituloP d-flex justify-content-end">
                <strong>TRANSFERENCIAS a Profesionales </Strong>
              </div>
            </div>  
         
           <div class="row mb-5">
             
                <div class="col-2 d-flex ">
                        <a class="btn_mc_mini_imprimir" id="idBtImprimir" data-toggle="tooltip" data-placement="top" title="Imprimir Listado de Liquidaciones"><i class="bi bi-printer-fill"></i></a>
                </div>
                
                <div class="col-3" style="margin:3px;">       
                    <div class="input-group input-group-sm ">
                        <label for="idInNumAño" class="input-group-text labelcss">Periodo </label>
                        <input type="Number" id="idInNumAño" class="form-control ms-1"  min="2023" max="2100" value="<?=date("y");?>">
                        <input type="Number" id="idInNumMes" class="form-control ms-1"  min="1" max="12" value="<?=date("m");?>">
                    </div>
                </div>

                <div class="col-4"></div>    
                
                <div class="col-2 d-flex justify-content-end ">
                    <a class="btn_mc_mini_volver align-middle" href="<?= site_url();?>InicioIntra" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
                </div>
            
            </div> <!--fin fila -->

            
           <!--Tabla de datos-->
    <div class="container">
        <div class="row">
             <div class="col-2"></div>
            <div class="col-8">
                Comprobantes a cancelar
                <table class="table tablacss table-sm table-black-50 table-hover table-bordered m-2">
                    <thead class="cabtablacss">
                        <td></td>
                        <td>Id</td>
                        <td>Fecha</td>
                        <td>Prestador</td>
                        <td>Comprobante</td>
                        <td>Período</td>
                        <td>Importe</td>
                        <td class='text-center'><input type='checkbox'  id='idSeleccionaTodos'></td>
                        <!--<td>$.Deuda</td>-->
                        <td>Recibo</td>
                        
                        
                    </thead>
                    <tbody id="tb1" style="font-size:11px;">

                    </tbody>

                </table>
                <div class="row">
                        <div class="col-5 text-end">
                            <input id="idChRet" type="checkbox"> Quitar las retenciones en la transferencia
                        </div>
                </div>               
                <div id="idBotonesFactura" class="modal-footer" >
                            <?php
                            echo(' <button id="idBtArma" type="button" class="btn btn-sm btn-danger">Armar transferencia</button>');
                            ?>
                </div>
                
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
<script src="<?= base_url(); ?>js/pagos/transf.js"></script>

<script>
    buscaDatos()
</script>









<?= $this->endSection(); ?>





