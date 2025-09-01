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
   
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">
            <div class="row">
              <div class="col mb-1 mx-3 LineaTituloP2 d-flex justify-content-end">
                <?php 
                  echo (strtoupper($arregloOs->os) . ": Prestaciones NO cuviertas. Seleccione y agregue a la covertura");
                ?>
              </div>
            </div>  
         
            <!--Botones Superiores -->         
            <div class="row">
              <div class="col-1 d-flex align-items-center">
              </div>
              <div class="col-9"></div>
              <div class="col-2 d-flex justify-content-end">
                        <a class="btn_mc_mini_volver" href="<?=site_url() . "BuscarItemsOs/" . $arregloOs->id_os ;?>" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
              </div>
                       
            </div>
            <!--Fin botones superiores -->   
      </div>
      
      
           <!--Tabla de datos-->
    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table table-sm table-black-50 table-striped table-hover table-bordered table-striped m-2">
                    <thead>
                        <td>Agregar</td>
                        <td>Código</td>
                        <td>Prestación</td>
                        <td>Interno</td>
                        
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb2" style="font-size:11px;">

                    <?php
                            $i = 0;
                            foreach ($arregloItems as $valores){
                                echo("<tr class='align-middle'>");
                                echo("<td><input type='checkbox' min=0 id='". $valores['id_item']."' class='chbagregaritemos'></td>");
                                echo("<td>". $valores['codigo']. "</td>");
                                echo("<td>". $valores['item']. "</td>");
                                echo("<td>". $valores['id_item']. "</td>");
                                echo("</tr>");
                                         
                            }
                            echo('<input id="idIdOs" value="'. $arregloOs->id_os . '" hidden >'); 
                            
                    ?>

                    </tbody>

                </table>
                
                                
                <br>
                <br>
               
            </div>
           
        </div>
        
              <div class="row">
                <div class="col-9 align-middle">
                  <input class="form-check-input" type="checkbox" id="chb1" checked>
                  <label class="form-check-label" for="chb1">Envia mensaje al panel de profesionales</label>
                </div>   
              
              <div class="col-2 align-middle">  
                <div class="d-flex justify-content-end"> <!-- Submit Button -->
                  <button type="button" id="IdBtnAgregarItemOs" class="btn btn-sm btn-danger mt-3">Agregar</button>
               </div>  
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
<script src="<?= base_url(); ?>public/js/ciro.js"></script>
<script src="<?= base_url(); ?>public/js/os/itemos.js"></script>
  


  <?= $this->endSection(); ?> 
  
