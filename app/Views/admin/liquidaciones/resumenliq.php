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
                <strong>Liquidaciones: </Strong> Resumen por periodo
              </div>
            </div>  
         
           <div class="row">
             
                <div class="col-1 d-flex ">
                        <a class="btn_mc_mini_mostrar " id="idBtMostrar" data-toggle="tooltip" data-placement="top" title="Mostrar liquidaciones"><i class="bi bi-file-text-fill"></i></a>
                        <a class="btn_mc_mini_imprimir" id="idBtImprimir" data-toggle="tooltip" data-placement="top" title="Imprimir Listado de Liquidaciones"><i class="bi bi-printer-fill"></i></a>
                </div>
                
                <div class="col-3" style="margin:2px;">       
                    <div class="input-group input-group-sm ">
                    <label for="idSelOS" class="input-group-text labelcss">Obra Social  </label>
                    <?php
                        $s->selectOs("S");
                    ?>
                    </div>
                </div>

                <div class="col-3" style="margin:3px;">       
                    <div class="input-group input-group-sm ">
                        <label for="idInNumAño" class="input-group-text labelcss">Periodo </label>
                        <input type="Number" id="idInNumAño" class="form-control ms-1"  min="2023" max="2100" value="<?=date("y");?>">
                        <input type="Number" id="idInNumMes" class="form-control ms-1"  min="0" max="12" value="<?=date("m");?>">
                    </div>
                </div>

                <div class="col-3" style="margin:2px;">       
                    <div class="input-group input-group-sm ">
                        <label for="idSelOS" class="input-group-text labelcss">Profesionales  </label>
                        <?php
                            $s->selectProfesionales("S");
                        ?>
                    </div>
                </div>

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
                      
                        <td>Periodo</td>
                        <td>Detalle</td>
                        <td>Total</td>
                        <td>Sin Facturar</td>
                        <td>Facturadas</td>
                        <td>Sin cobrar</td>
                        <td>Cobradas</td>
                        <td>Sin Transferir</td>
                        <td>Transferidas</td>
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb1" style="font-size:11px;">

                    </tbody>

                </table>
                
                </div>
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
<script src="<?= base_url(); ?>js/liq/resumen.js"></script>

<script>
    buscaDatos()
</script>








<?= $this->endSection(); ?>





