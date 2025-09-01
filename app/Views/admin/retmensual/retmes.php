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
                <strong>Retenciones mensuales </Strong> 
              </div>
          </div>  
         
           <div class="row no-print" >
             
            <div class="col-2 d-flex align-items-start ">
                      <a href="<?=site_url();?>RetMesProf" class="btn_mc_mini_mostrar " id="idBtMostrar" data-toggle="tooltip" data-placement="top" title="Retenciones por Profesionales"><i class="bi bi-person-vcard-fill"></i></a>
                      <a class="btn_mc_mini_agregar" id="idBtAgregar" data-toggle="tooltip" data-placement="top" title="Nueva Liquidación  de retenciones mensuales(Cálculo Automático)"><i class="bi bi-plus-circle-fill"></i></a>
                      <a href="<?=site_url();?>RetencionesManuales" class="btn_mc_mini_agregar" id="idBtManual" data-toggle="tooltip" data-placement="top" title="Agrega/Modifica Retenciones Mensuales(Proceso Manual)"><i class="bi bi-keyboard"></i></a>
                      <a class="btn_mc_mini_imprimir" id="idBtImprimir" data-toggle="tooltip" data-placement="top" title="Imprimir Listado de Retenciones"><i class="bi bi-printer-fill"></i></a>
            </div>
             
           <div class="col-8"></div>
            

            <div class="col-1 d-flex justify-content-end ">
                        <a class="btn_mc_mini_volver align-middle" href="<?= site_url();?>InicioIntra" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
            </div>


            </div>
        </div>   

           <!--Tabla de datos-->
    <div class="container">
        <div class="row">
          <div class="col-1"></div>
          <div class="col-10">
                <table class="table tablacss table-sm table-black-50 table-hover table-bordered  m-2" >
                    <thead class="cabtablacss">
                        <td></td>
                        <td>Id</td>
                        <td class="col-sm-8">Retención</td>
                        <td >Valor</td>
                        <td class="col-sm-1">Tipo</td>
                        <td class="col-sm-1">Relación %</td>
                        
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb2" style="font-size:11px;">

                    <?php
                            foreach ($arregloItems as $valores){
                             
                                echo("<tr>");

                                $lineainicial = "<td class='centrartexto botonesItems'><i class='bi bi-circle-fill'></i></td>";
                                echo($lineainicial);
                                echo("<td>". $valores['id_retmes']. "</td>");
                                echo("<td>". $valores['retencion']. "</td>");
                                echo("<td ><input style='width: 90%;' type='number' min=0 id='". $valores['id_retmes']."'  class='claseInputItem  fondoInput text-center ' value=" . $valores['valor']. "></td>");
                                echo("<td class='text-center'>". $valores['tipo']. "</td>");
                                echo("<td class='text-center'>". $valores['relacion_porcentaje']. "</td>");
                                
                                echo("</tr>");
                                        
                            }
                            

                    ?>



                    </tbody>

                </table>
                
                  <div class="modal-footer">
                    <a href="<?= site_url();?>InicioIntra"> <button type="button" id="idBtCerrar" class="btn btn-sm btn-secondary me-3">Cerrar</button></a>
                    
                    <?php
                    
                      echo('<button id="idBtGuardar" type="button" class="btn btn-sm btn-danger">Guardar</button>');
                    
                    ?>
                
                </div>
                <div class="row">
                <div class="col-6"><p>[I] Importe fijo - [P] Porcentaje </p></div>
                <div class="col-6"><p>[PM]% sobre pago mensual</p></div>
                
                </div>
                <center> <div id="idEspere" style="margin:3px; visibility:hidden;  background-color:#FF4A17;height:21px;width:90%; color:white;">| | | | | | | | | | | | | | | procesando . . .</div> </center>
     
                </div>
     </div>
        
        <div class="row">
          <br>
          <br>
          
        </div>  
    </div>
      
</div>
    
</div>

        </div> 









  </section><!-- End About Section -->
 
</main><!-- End #main -->

 <!-- JS --> 
 <script src="<?= base_url(); ?>public/js/ciro.js"></script>
 <script src="<?= base_url(); ?>public/js/ret/retmes.js"></script>
  
 
 <!-- Modal Alta retenciones mensuales-->
    <!-- data-bs-target  apunta al id -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="modal-header" class="modal-header headermodalcss">
                    <!--titulo modal-->
                    <h5 class="modal-title" id="exampleModalLabel">Liquidar Retenciones(Proceso Automático)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body modalcss">
                    <!--cuerpo del modal-->
                    <form id="idFR1" class="form-control form-control-sm">
                      <div class="row">  
                        <div class="col-3 mb-2">
                            <label for="idNuAño2" class="form-label">Año</label>
                            <input type="Number"  min = "2023" max = "2100" id="idNuAño2" name="nameAño2"class="form-control form-control-sm">
                            <div><p class="text-danger"><small><?=session('errors.nameAño2');?></small></p> </div>
                        </div>

                        <div class="col-3 mb-2">
                            <label for="idNuMes2" class="form-label">Mes</label>
                            <input type="Number"  id="idNuMes2" name="nameMes2"class="form-control form-control-sm">
                            <div><p class="text-danger"><small><?=session('errors.nameMes2');?></small></p> </div>
         
                        </div>

                        </div>
                        <div class="row">    
                            <div class="col-3">
                                <div class="mb-2">
                                    <label for="idFecha" class="form-label">Fecha</label>
                                    <input type="Date"  id="idFecha" name="nameFecha"class="form-control form-control-sm" value="<?=date('Y-m-d');?>">
                                    <div><p class="text-danger"><small><?=session('errors.nameFecha');?></small></p> </div>
                
                                </div>
                            </div>
                        </div>
                        <div ><p class="text-justify"><i class="bi bi-exclamation-circle-fill"></i>Las retenciones se realizan sobre todos los recibos realizados entre el primer y último día del período indicado </p> </div>    
                        <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="idBtAct" type="submit" class="btn btn-sm  btn-danger ">Liquidar</button>
                </div>
                    </form>

                </div>
                
            </div>
        </div>
    </div>
    <!--FIN Modal -->




 <!-- Modal2 agrega retenciones manuales-->
    <!-- data-bs-target  apunta al id -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="modal-header3" class="modal-header">
                    <!--titulo modal-->
                    <h5 class="modal-title" id="exampleModalLabel">Agrega/Modifica Retenciones(Proceso Manual)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body modalcss">
                    <!--cuerpo del modal-->
                    <form id="idFR3" class="form-control form-control-sm fondo" method="post" action="<?=site_url();?>RetencionesManuales">
                        <div class="mb-2">
                            <label for="idNuAño3" class="form-label">Año</label>
                            <input type="Number"  min = "2023" max = "2100" id="idNuAño3" name="nameAño3"class="form-control form-control-sm">
                            <div><p class="text-danger"><small><?=session('errors.nameAño3');?></small></p> </div>
                        </div>

                        <div class="mb-2">
                            <label for="idNuMes3" class="form-label">Mes</label>
                            <input type="Number"  id="idNuMes3" name="nameMes3"class="form-control form-control-sm">
                            <div><p class="text-danger"><small><?=session('errors.nameMes3');?></small></p> </div>
         
                        </div>
                        <div class="mb-2">
                            <label for="idFecha3" class="form-label">Fecha</label>
                            <input type="Date"  id="idFecha3" name="nameFecha3"class="form-control form-control-sm" value="<?=date('Y-m-d');?>">
                            <div><p class="text-danger"><small><?=session('errors.nameFecha3');?></small></p> </div>
         
                        </div>
                        <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="idBtManual" type="submit" class="btn btn-sm  btn-danger ">Ingresar</button>
                </div>
                    </form>

                </div>
                
            </div>
        </div>
    </div>
    <!--FIN Modal -->
   









  <?= $this->endSection(); ?> 
  
