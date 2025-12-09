<?php
    //clases propias globales
    $s = new App\Controllers\clases();

?>

<?= $this->extend('Views/plantilla/plantilla');?>




<!--declaracion de la seccion a incrustar en la plantilla -->
<?= $this->section('Principal'); ?>

<div class="container"> 
 
  <main id="main">
   
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">
            <div class="row">
              <div class="col-11 titulo-v3">
                <strong>Historia Clínica (Consulta de atenciones)</Strong>
              </div>
              <div class="col-1 d-flex justify-content-end">
                        <a class="btn_mc_mini_volver" href="<?= site_url();?>InicioIntra" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
              </div>
            </div>    
         
            <!--Botones Superiores -->         
            <div class="row">
              <div class="col-1 d-flex align-items-center">
                      <a id="idBtImprimir" class="btn_mc_mini_imprimir" data-toggle="tooltip" data-placement="top" title="Imprimir Historia Clínica"><i class="bi bi-printer-fill"></i></a>
                      <a id="idBtImprimir2" class="btn_mc_mini_borrar" data-toggle="tooltip" data-placement="top" title="Imprimir Estado de Cuenta"><i class="bi bi-printer-fill"></i></a>
              </div>
                <div class="col-2">
                    <div class="input-group input-group-sm ">
                        <label for="idFec" class="input-group-text mt-1 me-1 ">Desde:</label>
                        <input type="date" class="form-control mt-1" id="idFec">
                    </div>     
                </div>
              
                <div class="col-3"> 
                          <?php
                                    $s->selectPacientes("S", "idSelPac", "nameSelPac", "");
                          ?>
              </div>
              <div class="col-2"> 
                          <?php
                                    $s->selectOs("S", "idSelOS3", "nameSelOS3", "");
                          ?>
              </div>
              <div class="col-2"> 
                <select id="idSelEstado"  name="nameSelEstado" class="form-control form-select ms-1" >
                    <option value="T">Todas</option>
                    <option value="L">Liquidadas</option>
                    <option value="S">Sin liquidar</option>
                </select>    
              </div>
              
              <div class="col-2"> 
                <select id="idSelTipo"  name="nameSelTipo" class="form-control form-select ms-1" >
                    <option value="T">Todas</option>
                    <option value="P">Sin OS</option>
                    <option value="O">Por OS</option>
                </select>    
              </div>
              
                       
            </div>
            <!--Fin botones superiores -->   
      </div>
      
   
   
      <!--Tabla de datos-->
    <div class="container"> 
        <div class="row">
            <div class="col-2"></div>
            <div class="col-12">
                <table class="table tablacss table-sm  table-black-50 table-hover table-bordered m-2">
                    <thead class="cabtablacss">
                        <td>Acciones</td>
                        <td>Fecha</td>
                        <td>Paciente</td>
                        <td>Cod.</td>
                        <td>Item</td>
                        <td>Detalle</td>
                        <td>Obs</td>
                        <td>Importe</td>
                        <td>Estado</td>
                        <td>Paga</td>
                        <td>Token</td>
                        
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb1" style="font-size:13px;">

                    </tbody>

                </table>
                
                <br>
                <br>
               
            </div>
           
        </div>
    </div>


      <!--Tabla Totales-->
    <div class="container"> 
        <div class="row">
            <div class="col-5"></div>
            <div class="col-7">
                <table class="table tablacss table-sm  table-black-50 table-hover table-bordered m-2">
                    <thead class="cabtablacss">
                        <td>ESTADO CUENTA </td>
                        <td>Cobrado</td>
                        <td>Saldo</td>
                        <td>Total</td>
                        
                       
                    </thead>
                    <tbody id="tbTot" style="font-size:13px;">

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
<script src="<?= base_url(); ?>js/ciro.js"></script>  
<script src="<?= base_url(); ?>js/historias/hisP.js"></script>



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
