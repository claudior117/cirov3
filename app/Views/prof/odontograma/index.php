<?php
    //clases propias globales
    $s = new App\Controllers\clases();
    require 'dibuja.php';
    
?>



<?= $this->extend('Views/plantilla/plantilla');?>

<!--declaracion de la seccion a incrustar en la plantilla -->
<?= $this->section('Principal'); ?>


<main id="main">
    <!-- ======= Socios Section ======= -->
  <section id="about" class="about">
      
    
            <div class="row">
              <div class="col-1"></div>  
              <div class="col-10 titulo-v3">
                <strong>Carga Atenciones</Strong>
              </div>
              <div class="col-1">
                <a class="btn_mc_mini_volver align-middle" href="<?= site_url();?>InicioIntra" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
                
              </div>
            </div>  
    
    <div class="container mb-4 container-v3" >
            <div class="row mb-1">
                <div class="col-3" >       
                    <div class="input-group input-group-sm ">
                        <label for="idDNI" >DNI Paciente:  </label>
                        <input type="Number" id="idDNI" class="form-control ms-1">
                    </div>
                </div>    
                <div class="col-7" >       
                    <div class="input-group input-group-sm ">
                        <label for="idNom" >Paciente:  </label>
                        <input type="Text" id="idNom" class="form-control ms-1" disabled>
                    </div>
                </div>    
                <div class="col-2" >       
                    <div class="input-group input-group-sm ">
                        <label for="idIdP" >Id:  </label>
                        <input type="Text" id="idIdP" class="form-control ms-1" disabled>
                    </div>
                </div>    
            </div> 
        
            <div class="row">
                <div class="col-3" style="margin:2px;">       
                    <div class="input-group input-group-sm ">
                        <label for="idFec" >Fecha:  </label>
                        <input type="Date" id="idFec" class="form-control ms-1">
                    </div>
                </div>    
            
                <div class="col-7" style="margin:2px;">       
                    <div class="input-group input-group-sm ">
                        <label for="idSelOs" >Obra Social:</label>
                        <?php
                            $s->selectOs("N");
                        ?>
                    </div>
                </div>    
            
            
            
            </div>
        
        
    </div> <!--fin container-->   

<!-- Cuerpo -->
  
<div class="container-fluid vh-100 p-3      container py-4 mt-4 bg-light">
    <div class="row h-100 g-3">
      <!-- Columna izquierda -->
      <div class="col-md-6 d-flex flex-column h-100">
        <!-- Fila 1: Select -->
        <div class="mb-3">
            <div class="content-box flex-grow-1">
                <label for="idIOS">Código</label>
                <select id="idIOS">
                </select>    
            </div>  

        </div>

        <!-- Fila 2: Select + Checkboxes (3 columnas) -->
        <div class="row mb-3 g-2 recuadro-v3">
          <div class="col-md-4">
                <!-- Fila 2: Select -->
                <label for="idPie">Pieza</label>
                    <select class="form-select"  id="idPie">
                        <?php
                            echo ('<option value0>00</option>'); 
                            for ($i = 11; $i <= 18; $i++) {
                                echo ('<option value' . $i . '>'. $i .'</option>');
                            }
                            for ($i = 21; $i <= 28; $i++) {
                                echo ('<option value' . $i . '>'. $i .'</option>');
                            }
                            for ($i = 31; $i <= 38; $i++) {
                              echo ('<option value' . $i . '>'. $i .'</option>');
                            }
                            for ($i = 41; $i <= 48; $i++) {
                                echo ('<option value' . $i . '>'. $i .'</option>');
                            }
                            
                        ?>
                  </select> 
          </div>
          
          
              <div class="col-md-8" >
              <fieldset id="bloque-caras">              
                <label>Cara</label>
                <div class="row row-cols-3 g-2">
                  <!-- Checkboxes (9 en total) -->
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input " value = 'V' type="checkbox" id="chIdV">
                      <label class="form-check-label" for="check1">Vestibular</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input " value = 'P' type="checkbox" id="chIdP">
                      <label class="form-check-label" for="check2">Palatina</label>
                    </div>
                  </div>
                  <!-- Repetir para los 9 checkboxes -->
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" value = 'L' type="checkbox" id="chIdL">
                      <label class="form-check-label" for="check3">Lingual</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" value = 'I' type="checkbox" id="chIdI">
                      <label class="form-check-label" for="check4">Incisal</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" value = 'O' type="checkbox" id="chIdO">
                      <label class="form-check-label" for="check5">Oclusal</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" value = 'M' type="checkbox" id="chIdM">
                      <label class="form-check-label" for="check6">Mesial</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" value = 'D' type="checkbox" id="chIdD">
                      <label class="form-check-label" for="check7">Distal</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                    </div>
                  </div> 
              </div>
              </fieldset>
          </div>
          
          <div class="row">
            <div class="col" id="columna-agregar">
              <button type="button" id="idBAgr" class="btn btn-success btn-sm">Agregar >>></button>
            </div> 
          </div>
        
        </div>

        <!-- Fila 3: Imagen -->
        <div class="content-box flex-grow-1">
            <?php
                dibuja();
            ?> 
        
    </div>
        
        
    
    </div>

      <!-- Columna derecha: Tabla -->
      <div class="col-md-6 h-100">
                <div class="content-box h-100 recuadro-v3">
                    <p class="text-center">Atenciones del paciente sin liquidar</p>
                    <div class="table-container-v3 flex-grow-1" >
                        <!--Histgoria-->
                        <table class='table-v3'>
                            <thead class='th-v3'>
                                <tr>
                                    <th></th>
                                    <th>Fecha</th>
                                    <th>Pieza/Cara</th>
                                    <th>Código / Item</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>
                            <tbody id="tb1" style="font-size:11px;">
                            </tbody>    
                        </table>
                    </div>
                </div>
            </div>                          

    </div>
  </div>

</section><!-- End About Section -->
 
</main><!-- End #main -->



<!-- JS -->
<script src="<?= base_url(); ?>public/js/ciro.js"></script>  
<script src="<?= base_url(); ?>public/js/odonto/odonto.js"></script>











<?= $this->endSection(); ?>





