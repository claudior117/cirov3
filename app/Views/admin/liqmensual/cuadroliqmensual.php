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
                <strong>Cuadro resumen Liquidación mensual a profesionales </Strong> 
              </div>
            </div>  
         
           <div class="row">
             
                <div class="col-1 d-flex ">
                        <a class="btn_mc_mini_imprimir" id="idBtImprimir" data-toggle="tooltip" data-placement="top" title="Imprimir Liquidacion Mensual"><i class="bi bi-printer-fill"></i></a>
                </div>
                
                <div class="col-3" style="margin:3px;">       
                    <div class="input-group input-group-sm ">
                        <label for="idInNumAño" class="input-group-text labelcss">Periodo </label>
                        <input type="Number" id="idInNumAño" class="form-control ms-1"  min="2023" max="2100" value="<?=date("Y");?>">
                        <input type="Number" id="idInNumMes" class="form-control ms-1"  min="1" max="12" value="<?=date("m");?>">
                    </div>
                </div>

                
                <div class="col-3">
                    <div class="input-group input-group-sm ">
                        <label for="idSelTipo" class="input-group-text labelcss">Tipo </label>
                        <select id="idSelTipo" class="form-control form-select ms-1">');
                            <option value="0">Sin transferir</option>
                            <option value="1">Transferido</option>
                        </select>    
                            
                    </div>
                </div>

                <div class="col-2"></div>
                

                <div class="col-1 d-flex justify-content-end ">
                    <a class="btn_mc_mini_volver align-middle" href="<?= site_url();?>InicioIntra" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
                </div>
            
            </div> <!--fin fila -->

            
      </div>   

           <!--Tabla de datos-->
    <div class="container">
        <div class="row">
        
            <div class="col-12">
                <table class="table tablacss table-sm table-black-50 table-hover table-bordered m-2">
                    <thead class="cabtablacss">
                      
                        <td>Acciones</td>
                        <td>Profesional</td>
                        <td>Ingresos</td>
                        <td>Egresos</td>
                        <td></td>
                        <td>Total</td>
                        <td>Transferencia</td>
                        
                       
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb1" style="font-size:11px;">

                    </tbody>

                </table>
                
                
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
<script src="<?= base_url(); ?>js/liqmen/cuadroliqmenA.js"></script>



<?= $this->endSection(); ?>





