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
                <strong>Aplicar Retenciones Mensuales a Profesionales </Strong> 
              </div>
          </div>  
         
           <div class="row no-print" >
             
            <div class="col-2 d-flex align-items-start">
                      <a class="btn_mc_mini_imprimir" id="idBtImprimir" data-toggle="tooltip" data-placement="top" title="Imprimir Listado de Retenciones"><i class="bi bi-printer-fill"></i></a>
            </div>
             
           <div class="col-8"></div>
            <div class="col-1 d-flex justify-content-end ">
                        <a class="btn_mc_mini_volver align-middle" href="<?= site_url();?>RetencionesMes" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
            </div>


            </div>
        </div>   

           <!--Tabla de datos-->
    <div class="container">
        <div class="row">
          <div class="col-1"></div>
          <div class="col-10">
                <table class="table tablacss table-sm table-black-50  table-hover table-bordered  m-2" >
                    <thead class='cabtablacss'>
                        <td >Profesional</td>
                        <?php
                             foreach ($arregloRet as $valores){
                                echo("<td >". $valores['abreviatura'] . "</td>");
                             }
                              
                       ?>
                    </thead>
                    <tbody id="tb2" style="font-size:11px;">

                    <?php
                      $MRMProf = new RetMesModel;
                      $cant = 0;
                      $iditem = 0;
                      foreach ($arregloProf as $prof){
                                echo("<tr id='". $prof['id_usuario'] . "'>");
                                echo("<td><b>". $prof['nombre']. "</b></td>");
                                foreach ($arregloRet as $valores){
                                  $r = $MRMProf -> getRetMesProf($prof['id_usuario'], $valores['id_retmes']);   
                                  if (isset($r)){
                                    $cant = $r->cantidad;
                                    $iditem = $r->id_usuario_retmes;
                                    $lineaestado = "";
                                  }else{
                                    $cant = -1;
                                    $iditem = $valores['id_retmes'];
                                    $lineaestado = "readonly";
                                  }

                                     echo("<td class='text-center'><b><input ". $lineaestado . " style='width: 70%;' type='number' min=0 id='". $iditem ."'  class='claseInputItem fondoInput  text-center ' value=" . $cant. "></b></td>");
                                }  
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
                <p> [-1] Retención sin crear para el usuario, GUARDAR para agregar retención con valor uno </p>
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

 <!-- JS  --> 
 <script src="<?= base_url(); ?>js/ciro.js"></script>
 <script src="<?= base_url(); ?>js/ret/cantretmes.js"></script>
 
 


  <?= $this->endSection(); ?> 
  
