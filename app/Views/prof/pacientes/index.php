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
                <strong>PACIENTES</strong>  
              </div>
            </div>  
         
            <!--Botones Superiores -->         
            <div class="row">
              <div class="col-2 d-flex align-items-center">
                        <a class="btn_mc_mini_mostrar" id="idBtMostrar" data-toggle="tooltip" data-placement="top" title="Mostrar"><i class="bi bi-file-text-fill"></i></a>
                        <a class="btn_mc_mini_agregar" id="idBtAgregar" data-toggle="tooltip" data-placement="top" title="Agregar Paciente"><i class="bi bi-plus-circle-fill"></i></a>
                        <a class="btn_mc_mini_imprimir" href="<?=site_url();?>ReportePacientes" data-toggle="tooltip" data-placement="top" title="Imprimir"><i class="bi bi-printer-fill"></i></a>
              </div>
              <div class="col-2"><input type="text" class="form-control mt-1" id="idSerchDNI" placeholder="Buscar aqui por DNI..."></div>
              <div class="col-4">
                <input type="text" class="form-control mt-1" id="idSerchNombre" placeholder="Buscar aqui por nombre...">
              </div>
              <div class="col-3"> 
                          <?php
                                    $s->selectOs("S", "idSelOS3", "nameSelOS3", "");
                          ?>
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
                        <td>DNI</td>
                        <td >Apellido y Nombre</td>
                        <td>Obra Social</td>
                        <td>Teléfonos</td>
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
<script src="<?= base_url(); ?>js/pacientes/pacP.js"></script>
<script>buscaDatos(1)</script>




<!-- Modal Alta y Actualizacion Liquidaciones-->
    <!-- data-bs-target  apunta al id -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      
    
        <div class="modal-dialog modal-lg">  <!--ancho modal-lg (grande) modal-xl(extra) sin nada normal --> 
            <div class="modal-content">
                <div id="modal-header" class="modal-header headermodalcss">
                    <!--titulo modal-->
                    <h5 class="modal-title" id="exampleModalLabel">PACIENTES</h5>
                    <!--X de cierre (se puede sacar) usa la propiedad: data-bs-dismiss -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body modalcss">
                    <!--cuerpo del modal-->
                    <form id="idFR1" class="form-control form-control-sm fondo">
                        
                    <div class="row mb-1">
                           <div class="col-3"> 
                                <label for="idCu" class="form-label">Dni</label>
                                <input type="Number"  id = "idCu" name="nameCu"class="form-control form-control-sm" value= "" min=500000 pattern="[0-9]{9}" placeholder="Ingresar DNI" required>
                            </div>
                    </div>

                    <div class="row mb-2">
                           <div class="col-10">
                            <label for="idDe" class="form-label">Denominación:</label>
                            <input type="Text"  id = "idDe" name="nameDe"class="form-control form-control-sm" required>
                           </div>
                    </div>    
                    <div class="row mb-3">
                           <div class="col-7"> 
                                <label for="idselectOS" class="form-label">Obra Social</label>
                                <?php
                                    $s->selectOs("N", "idSelOS2", "nameSelOS2", "required");
                                ?>
                                
                            </div>

                            <div class="col-3"> 
                                <label for="idFN" class="form-label">Fecha Nacimiento</label>
                                <input type="Date"  id = "idFN" name="nameFN"class="form-control form-control-sm" required>
                            </div>
                        </div>
                    <div class="row mb-1">
                           <div class="col-10"> 
                                <label for="idDi" class="form-label">Dirección</label>
                                <input type="Text"  id = "idDi" name="nameDi"class="form-control form-control-sm">
                            </div>
                    </div>
                    
                    <div class="row mb-1">
                           <div class="col-10"> 
                                <label for="idLo" class="form-label">Localidad</label>
                                <input type="Text"  id = "idLo" name="nameLo"class="form-control form-control-sm">
                            </div>
                    </div>
                        
                    <div class="row mb-1">
                           <div class="col-10"> 
                                <label for="idTe" class="form-label">Teléfonos</label>
                                <input type="tel"  id = "idTe" name="nameTe"class="form-control form-control-sm">
                            </div>
                    </div>
                    
                    <div class="row mb-1">
                           <div class="col-10"> 
                                <label for="idEm" class="form-label">Email</label>
                                <input type="email"  id = "idEm" name="nameEm"class="form-control form-control-sm">
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
