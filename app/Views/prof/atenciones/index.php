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
      <div class="col-10 text-center">
        <strong>Carga Atenciones</strong>
      </div>
      <div class="col-1">
        <a class="btn_mc_mini_volver align-middle" href="<?= site_url();?>InicioIntra" 
           id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver">
          <i class="bi bi-box-arrow-in-left"></i>
        </a>
      </div>
    </div>   
    
  

<!-- Datos del paciente -->
<div class="container mb-4 container-v3">
  <div class="row mb-1">
    <!-- DNI -->
    <div class="col-3">       
      <div class="mb-3">
        <label for="idDNI" class="form-label">DNI Paciente:</label>
        <input type="number" id="idDNI" class="form-control form-control-sm" placeholder="Ingrese DNI">
      </div>
    </div> 
       
    <!-- Nombre del Paciente -->
    <div class="col-7">       
      <div class="mb-3">
        <label for="idNom" class="form-label">Paciente:</label>
        <input type="text" id="idNom" class="form-control form-control-sm" disabled>
      </div>
    </div>    
    
    <!-- ID -->
    <div class="col-2">       
      <div class="mb-3">
        <label for="idIdP" class="form-label">Id:</label>
        <input type="text" id="idIdP" class="form-control form-control-sm" disabled>
      </div>
    </div>    
  </div> 

  <div class="row">
    <!-- Fecha -->
    <div class="col-3" style="margin:2px;">       
      <div class="mb-3">
        <label for="idFec" class="form-label">Fecha:</label>
        <input type="date" id="idFec" class="form-control form-control-sm">
      </div>
    </div>    
    
    <!-- Obra Social -->
    <div class="col-6" style="margin:2px;">       
      <div class="mb-3">
        <label for="idSelOs" class="form-label">Obra Social:</label>
        <?php $s->selectOs("N"); ?>
      </div>
    </div>    
    
    <!-- Token -->
    <div class="col-2">       
      <div class="mb-3">
        <label for="idToken" class="form-label">Token:</label>
        <input type="text" id="idToken" class="form-control form-control-sm">
      </div>
    </div>    
  </div>
</div>



    <!-- Cuerpo -->
    <div class="container-fluid  p-3 container py-4 mt-4 bg-light">
      <div class="row g-3">
        <!-- Columna izquierda -->
        <div class="col-md-6 d-flex flex-column ">
          <!-- Radios y select -->
          <div class="mb-3">
            <div class="content-box flex-grow-1">
              
              <div class="form-check form-check-inline me-5">
                <input class="form-check-input" type="radio" name="opcion" id="radio1" value="OS" checked>
                <label class="form-check-label" for="radio1">Códigos OS</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="opcion" id="radio2" value="PROPIOS">
                <label class="form-check-label" for="radio2">Códigos Propios</label>
              </div>
              

                
              <select id="idIOS"></select>    
            </div>  
          </div>

          <!-- Select + checkboxes -->
          <div class="row mb-3 g-2 recuadro-v3">
            <div class="col-md-4">
              <label for="idPie">Pieza</label>
              <select class="form-select" id="idPie">
                <?php
                  echo ('<option value0>00</option>'); 
                  for ($i = 11; $i <= 18; $i++) echo ('<option value' . $i . '>' . $i . '</option>');
                  for ($i = 21; $i <= 28; $i++) echo ('<option value' . $i . '>' . $i . '</option>');
                  for ($i = 31; $i <= 38; $i++) echo ('<option value' . $i . '>' . $i . '</option>');
                  for ($i = 41; $i <= 48; $i++) echo ('<option value' . $i . '>' . $i . '</option>');
                  for ($i = 51; $i <= 55; $i++) echo ('<option value' . $i . '>' . $i . '</option>');
                  for ($i = 61; $i <= 65; $i++) echo ('<option value' . $i . '>' . $i . '</option>');
                  for ($i = 71; $i <= 75; $i++) echo ('<option value' . $i . '>' . $i . '</option>');
                  for ($i = 81; $i <= 85; $i++) echo ('<option value' . $i . '>' . $i . '</option>');
                
                  
                ?>
              </select> 
            </div>
            
            <div class="col-md-8">
              <fieldset id="bloque-caras">              
                <label>Cara</label>
                <div class="row row-cols-3 g-2">
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" value="V" type="checkbox" id="chIdV">
                      <label class="form-check-label" for="chIdV">Vestibular</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" value="P" type="checkbox" id="chIdP">
                      <label class="form-check-label" for="chIdP">Palatina</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" value="L" type="checkbox" id="chIdL">
                      <label class="form-check-label" for="chIdL">Lingual</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" value="I" type="checkbox" id="chIdI">
                      <label class="form-check-label" for="chIdI">Incisal</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" value="O" type="checkbox" id="chIdO">
                      <label class="form-check-label" for="chIdO">Oclusal</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" value="M" type="checkbox" id="chIdM">
                      <label class="form-check-label" for="chIdM">Mesial</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" value="D" type="checkbox" id="chIdD">
                      <label class="form-check-label" for="chIdD">Distal</label>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
            
            <div class="row">
              <div class="col m-3 " id="columna-agregar">
                <button type="button" id="idBAgr" class="btn btn-success btn-sm">Agregar >>></button>
              </div> 
            </div>
          </div>
        </div>

        <!-- Columna derecha -->
        <div class="col-md-6">
          <div class="content-box recuadro-v3">
           
                <?php dibuja(); ?>
           </div>
        </div>
      </div> <!-- cierre row superior -->


      <!-- Nueva fila: tabla centrada -->
      <div class="row mt-4 mb-1 ">
        <div class="col-10 mx-auto ">
          <div class="content-box recuadro-v3 table-container-v3" style="min-height:200px;">
          <p class="text-center">Atenciones sin liquidar </p> 
            <table class="table table-bordered table-striped w-100  table-v3">
              <thead class="th-v3">
                <tr>
                  <th></th>
                  <th>Fecha</th>
                  <th>Pieza/Cara</th>
                  <th>Código / Item</th>
                  <th>Importe</th>
                  <th>Observaciones</th>
                  <th>Token</th>
                </tr>
              </thead>
              <tbody id="tb1" style="font-size:11px;">
              </tbody>    
            </table>
          </div>
        </div>
      </div>

  
    </div> <!-- fin container-fluid -->

    

  </section>
</main>
 
</main><!-- End #main -->



<!-- JS -->
<script src="<?= base_url(); ?>js/ciro.js"></script>  
<script src="<?= base_url(); ?>js/atenciones/aten.js"></script>





<!-- Modal Alta y Actualizacion Liquidaciones-->
    <!-- data-bs-target  apunta al id -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      
    
        <div class="modal-dialog modal-lg">  <!--ancho modal-lg (grande) modal-xl(extra) sin nada normal --> 
            <div class="modal-content">
                <div id="modal-header" class="modal-header headermodalcss">
                    <!--titulo modal-->
                    <h5 class="modal-title" id="exampleModalLabel">ATENCIONES</h5>
                    <!--X de cierre (se puede sacar) usa la propiedad: data-bs-dismiss -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body modalcss">
                    <!--cuerpo del modal-->
                    <form id="idFR1" class="form-control form-control-sm fondo">
                        
                    
                    <div class="row mb-2">
                           <div class="col-10">
                            <label for="idObs" class="form-label">Observaciones:</label>
                            <input type="Text"  id = "idObs" name="nameObs"class="form-control form-control-sm">
                           </div>
                    </div>    
                    <div class="row mb-1">
                           <div class="col-3"> 
                                <label for="idPre" class="form-label">Precio</label>
                                <input type="Number"  id = "idPre" name="namePre" step="any" min="0" class="form-control form-control-sm" required>
                            </div>
                    </div>
                    
                    <div class="row mb-1">
                           <div class="col-3"> 
                                <label for="idTok" class="form-label">Token</label>
                                <input type="Text"  id = "idTok" name="nameTok"  class="form-control form-control-sm" >
                            </div>
                    </div>

                        <div class="mb-2">
                            <input type="Number" name="nameId" id="idNuId" hidden class="form-control form-control-sm"></>
                        </div>

                        <div class="mb-2">
                            <input type="text" id="idInFun" name="nameFuncion" hidden class="form-control form-control-sm"></>
                        </div>
                        

                        <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="idBtAct" type="submit" class="btn btn-sm  btn-danger ">Modificar</button>
                </div>
                   
            
            </form>

                </div>
            </div>
        </div>
    </div>
    <!--FIN Modal -->










<?= $this->endSection(); ?>





