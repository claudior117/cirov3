<?php
    //clases propias globales
    $s = new App\Controllers\clases();

?>

<?= $this->extend('Views/plantilla/plantilla');?>




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
              <div class="col mb-1 mx-3 LineaTituloP d-flex justify-content-end">
                <strong>ARANCELES PROPIOS</strong>  
              </div>
            </div>  
         
            <!--Botones Superiores -->         
            <div class="row">
              <div class="col-2 d-flex align-items-center">
                        <a class="btn_mc_mini_mostrar" id="idBtMostrar" data-toggle="tooltip" data-placement="top" title="Mostrar"><i class="bi bi-file-text-fill"></i></a>
                        <a class="btn_mc_mini_agregar" id="idBtAgregar" data-toggle="tooltip" data-placement="top" title="Agregar Paciente"><i class="bi bi-plus-circle-fill"></i></a>
                        <a class="btn_mc_mini_imprimir" href="<?=site_url();?>ReportePropios" data-toggle="tooltip" data-placement="top" title="Imprimir"><i class="bi bi-printer-fill"></i></a>
              </div>
              <div class="col-2"><input type="text" class="form-control mt-1" id="idSerchCod" placeholder="Buscar aqui por codigo..."></div>
              <div class="col-4">
                <input type="text" class="form-control mt-1" id="idSerchNombre" placeholder="Buscar aqui por nombre...">
              </div>
              
              <div class="col-1 d-flex justify-content-end">
                        <a class="btn_mc_mini_volver" href="<?= site_url();?>InicioIntra" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
              </div>
                       
            </div>
            <!--Fin botones superiores -->   
      </div>
      
   
   
      <!--Tabla de datos-->
    <div class="container"> 
        <div class="row">
            <div class="col-2"></div>
            <div class="col-9">
                <table class="table tablacss table-sm  table-black-50 table-hover table-bordered m-2">
                    <thead class="cabtablacss">
                        <td>Acciones</td>
                        <td>Id</td>
                        <td>Código</td>
                        <td >Item propio</td>
                        <td>Precio</td>
                        <td>Aplica</td>
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
    </div>
    
</div>

        </div> 

  </section><!-- End About Section -->
 <center> <div id="idEspere" style="margin:3px; visibility:hidden;background-color:#FF4A17;height:21px;width:90%; color:white;">| | | | | | | | | | | | | | | procesando . . .</div> </center>
 
</main><!-- End #main -->



<!-- JS -->
<script src="<?= base_url(); ?>js/ciro.js"></script>  
<script src="<?= base_url(); ?>js/arancelespropios/pro.js"></script>
<script>buscaDatos()</script>




<!-- Modal Alta y Actualizacion Liquidaciones-->
    <!-- data-bs-target  apunta al id -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      
    
        <div class="modal-dialog modal-lg">  <!--ancho modal-lg (grande) modal-xl(extra) sin nada normal --> 
            <div class="modal-content">
                <div id="modal-header" class="modal-header headermodalcss">
                    <!--titulo modal-->
                    <h5 class="modal-title" id="exampleModalLabel">ARANCELES PROPIOS</h5>
                    <!--X de cierre (se puede sacar) usa la propiedad: data-bs-dismiss -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body modalcss">
                    <!--cuerpo del modal-->
                    <form id="idFR1" class="form-control form-control-sm fondo">
                        
                    <div class="row mb-1">
                           <div class="col-3"> 
                           <label for="idCod" class="form-label">Código</label> 
                            <div class="d-flex gap-2">
                                <input type="Text"  id = "idCod1" name="nameCod1"class="form-control form-control-sm" value= "61" pattern="[0-9]{9}" required readonly>
                                <input type="Number"  id = "idCod2" name="nameCod2"class="form-control form-control-sm" value= "01" max="99" min="01" pattern="[0-9]{9}" required>
                                <input type="Number"  id = "idCod3" name="nameCod3"class="form-control form-control-sm" value= "01" max="99" min="01" pattern="[0-9]{9}" required>
                               
                            </div>
                                
                                 
                        </div>
                    </div>

                    <div class="row mb-2">
                           <div class="col-10">
                            <label for="idIte" class="form-label">Item:</label>
                            <input type="Text"  id = "idIte" name="nameIte"class="form-control form-control-sm" required>
                           </div>
                    </div>    
                    <div class="row mb-3">
                           <div class="col-7"> 
                                <label for="idselA" class="form-label">Aplica a</label>
                                <select name="nameSelApl" id="idSelApl">
                                        <option value="S">(S) No requiere Pieza ni Carca</option>
                                        <option value="P">(P) Requiere solo Pieza</option>
                                        <option value="C">(C) Requiere Pieza y Cara</option>
                                </select>
                            </div>

                    </div>
                    <div class="row mb-1">
                           <div class="col-3"> 
                                <label for="idPre" class="form-label">Precio</label>
                                <input type="Number"  id = "idPre" name="namePre"class="form-control form-control-sm" required>
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
                    <button id="idBtAct" type="submit" class="btn btn-sm  btn-danger ">Agregar</button>
                </div>
                   
            
            </form>

                </div>
            </div>
        </div>
    </div>
    <!--FIN Modal -->










<?= $this->endSection(); ?>
