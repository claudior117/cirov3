<?php
    //clases propias globales
    $s = new App\Controllers\clases();
    $L = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","X"];
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
      
      <div class="container" data-aos='fade-up' >
            <div class="row">
              <div class="col mb-1 mx-3 LineaTituloP d-flex justify-content-end">
                Actualización de Aranceles por Obra Social desde Excel
              </div>
            </div>         
              
            <!--Botones Superiores -->         
            <div class="row">
              <div class="col-1 d-flex align-items-center">
              </div>
              <div class="col-9"></div>
              <div class="col-2 d-flex justify-content-end">
                        <a class="btn_mc_mini_volver" href="<?= site_url();?>AdminOS" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
              </div>
                       
            </div>
            <!--Fin botones superiores -->   
      
      </div>
      
    
      <!--Formulario de Datos-->
    
      <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-9">
          
          <!-- formulario -->
          <form  action="<?=site_url();?>OsProcesaXls" method="POST" enctype="multipart/form-data">
           
          <div class="row my-2"> <!--Obra social-->
            <div class="col-1"></div>
            <div class="col-9"> 
                  <label for="IdSelOs" class="form-label">Obra Social </label>
                   <?php
                        $s->selectOs("N");
                      ?>
                          
                    <div><p class="text-danger"><small><?=session('errors.nameIdSelOs');?></small></p> </div>

                  </div>
            </div>
          
          
        <div class="row "> 
         <div class="col-1"></div>
          <div class="col-9"> 
              <label for="formFileSm" class="form-label">Planilla con nuevos aranceles </label>
              <input class="form-control form-control-sm" id="formFileSm" name="archivo" type="file">
              <div><p class="text-danger"><small><?=session('errors.archivo');?></small></p> </div>
          </div>    
        </div>                  
        </div>
        
            <div class="row justify-content-around  mb-3"> <!--filas letras columnas-->
            <div class="col-2"> <!--Codigo-->
                  <div class="mb-3">
                    <label for="IdColCodigo" class="form-label">Columna Código </label>
                    <select id="IdColCodigo" name = "nameColCodigo" class="form-select form-select-sm" aria-label=".form-select-sm example">
                       <?php
                       foreach($L as $letras){
                          $s = "";
                          if($letras == 'A') {
                            $s = "selected";
                          }
                          echo('<option value="'. $letras. '" '. $s . '>'.$letras. '</option>');
                       }
                       ?>
                    </select>
                  </div>
            </div>

            <div class="col-2"> <!--Descripcion-->
                  <div class="mb-3">
                    <label for="IdColDesc" class="form-label">Columna Descripción </label>
                    <select id="IdColDesc" name = "nameColDesc" class="form-select form-select-sm" aria-label=".form-select-sm example">
                    <?php
                       foreach($L as $letras){
                          $s = "";
                          if($letras == 'B') {
                            $s = "selected";
                          }
                          echo('<option value="'. $letras. '" '. $s . '>'.$letras. '</option>');
                       }
                       ?>  

                    </select>
                  </div>
            </div>

            <div class="col-2"> <!--Arancel-->
                  <div class="mb-3">
                    <label for="IdColArancel" class="form-label">Columna Arancel </label>
                    <select id="IdColArancel" name = "nameColArancel" class="form-select form-select-sm" aria-label=".form-select-sm example">
                    <?php
                       foreach($L as $letras){
                          $s = "";
                          if($letras == 'C') {
                            $s = "selected";
                          }
                          echo('<option value="'. $letras. '" '. $s . '>'.$letras. '</option>');
                       }
                       ?>
                    </select>
                  </div>
            </div>
            <div class="col-2"> <!--Coseguro-->
                  <div class="mb-3">
                    <label for="IdColArancel" class="form-label">Columna Coseguro </label>
                    <select id="IdColCoseguro" name = "nameColCoseguro" class="form-select form-select-sm" aria-label=".form-select-sm example">
                    <?php
                       foreach($L as $letras){
                          $s = "";
                          if($letras == 'D') {
                            $s = "selected";
                          }
                          echo('<option value="'. $letras. '" '. $s . '>'.$letras. '</option>');
                       }
                       ?>
                    </select>
                  </div>
            </div>


             </div><!--filas letras columnas-->
                      </div>


            <div class="row  justify-content-around mb-3"> <!--Separador de código-->
            
              <div class="col-2"> 
                  <div class="mb-3">
                    <label for="IdSepCodigo" class="form-label">Formato Código </label>
                    <select id="IdSepCodigo" name="nameFormatoCodigo" class="form-select form-select-sm" aria-label=".form-select-sm example">
                          <option value="1">01-01</option>
                          <option value="2">101</option>
                          <option value="3">01.01</option>
                          <option value="4.">O01.01</option>
                          <option value="5">0101</option>
                          <option value="6">O0101</option>
                          <option value="7">1.01</option>
                    </select>
                    <div><p class="text-danger"><small><?=session('errors.nameFormatoCodigo');?></small></p> </div>

                  </div>
              </div>

              <div class="col-2">
               <div class="mb-3">
                  <label for="formFileSm" class="form-label">Número de Hoja</label>
                  <input class="form-control form-control-sm"  value="1" min=1 max=10 id="formFileSm" type="numver" name="nameHoja">
                  <div><p class="text-danger"><small><?=session('errors.nameHoja');?></small></p> </div>
                </div>
              </div>
             
            
            <div class="col-2">
               <div class="mb-3">
                  <label for="formFileSm" class="form-label">Fecha Actualización </label>
                  <input class="form-control form-control-sm" id="formFileSm" type="Date" value="<?=date('d-m-Y');?> " name="nameFecha">
                  <div><p class="text-danger"><small><?=session('errors.nameFecha');?></small></p> </div>
               </div>
             </div>
                   

          
            <div class="col-2">
               <div class="mb-5">
                  <label for="formFileSm" class="form-label">Fila final </label>
                  <input class="form-control form-control-sm"  min=100 max=1000 value = 1000 id="formFileSm" type="number" name="nameFilaFinal">
                  <div><p class="text-danger"><small><?=session('errors.nameFilaFinal');?></small></p> </div>
                </div>
             </div>
          
            </div>    

            <div class="row mb-5">
             <div class="col-1"></div>
                <div class="col-7 align-middle">
                  <input class="form-check-input" type="checkbox" id="chb2" name ="nameChAgregaNuevos" checked>
                  <label class="form-check-label" for="chb1">Agrega prestaciones que aparezcan en el Excel y que no estén en la OS </label>
                </div>   
            </div> 
 


             <!-- botones finales -->
             <div class="row mb-5">
             <div class="col-1"></div>
                <div class="col-7 align-middle">
                  <input class="form-check-input" type="checkbox" id="chb1" name ="nameChEnviaMsj" checked>
                  <label class="form-check-label" for="chb1">Envia mensaje al panel de profesionales</label>
                </div>   
              
              <div class="col-2 align-middle">  
                <div class="d-flex justify-content-end"> <!-- Submit Button -->
                  <button type="submit" id="IdBtnAgregarItemOs"  class="btn btn-sm btn-danger mt-3">Actualizar</button>
               </div>  
               </div>
             </div>   
            
            </form>
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
  


<?= $this->endSection(); ?>
