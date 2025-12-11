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
    <!-- ======= Socios Section ======= -->
    <section id="about" class="about">
      
      <div class="container mb-3 " data-aos="fade-up">
      
            <div class="row">
              <div class="col mb-3 LineaTituloP d-flex justify-content-end">
                <strong>Liquidaciones: </Strong> Agregar y enviar
              </div>
            </div>  
         
           <div class="row justify-content-between no-print">
             
            <div class="col-2 d-flex ">
                     <!-- <a class="btn_mc_mini_mostrar " id="idBtMostrar" data-toggle="tooltip" data-placement="top" title="Mostrar liquidaciones"><i class="bi bi-file-text-fill"></i></a>-->
                     <a class="btn_mc_mini_mostrar " id="idBtGenerar" data-toggle="tooltip" data-placement="top" title="Generar liquidaciones de atenciones pendientes"><i class="bi bi-database-up"></i></a>
                      <a class="btn_mc_mini_agregar" id="idBtAgregar" data-toggle="tooltip" data-placement="top" title="Agregar nueva Liquidacion"><i class="bi bi-plus-circle-fill"></i></a>
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
                    <div class="input-group input-group-sm w-75 ">
                        <label for="idInNumAño" class="input-group-text labelcss">Periodo </label>
                        <input type="Number" id="idInNumAño" class="form-control ms-1"  min="2023" max="2100" value="<?=date("y");?>">
                        <input type="Number" id="idInNumMes" class="form-control ms-1"  min="0" max="12" value="<?=date("m");?>">
                    </div>
            </div>

            <div class="col-2" style="margin:3px;">       
              <div class="input-group input-group-sm ">
              <label for="idSelEstado" class="input-group-text labelcss ">Estado  </label>
              <select id="idSelEstado" class="form-control form-select ms-1">
                    <option value="T">**Todas**</option>
                    <option value="B">Borrador</option>
                    <option value="E">Enviadas</option>
                    <option value="F">Facturadas</option>
                    <option value="P">Paga</option>
                    
             </select>  
             
            </div>
            </div>

            <div class="col-1 d-flex justify-content-end ">
                        <a class="btn_mc_mini_volver align-middle" href="<?= site_url();?>InicioIntra" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
            </div>

            </div>
        </div>   

           <!--Tabla de datos-->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table tablacss table-sm table-black-50 table-hover table-bordered m-2">
                    <thead class="cabtablacss">
                        <td></td>
                        <td>Acciones</td>
                        <td>Id</td>
                        <td>Periodo</td>
                        <td>OS</td>
                        <td>Importe</td>
                        <td>Desc.</td>
                        <td>Incr.</td>
                        <td>Total</td>
                        <td>Bonos/Ant</td>
                        <td>Enviada</td>
                        <td>Factura</td>
                        <td>Pago</td>
                        <td>Profesional</td>
                        <td>Estado</td>
                        
                        
                        
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb1" style="font-size:11px;">

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
<script src="<?= base_url(); ?>js/liq/liq.js"></script>

<script>
    buscaDatos()
</script>



<!-- Modal Alta y Actualizacion Liquidaciones-->
    <!-- data-bs-target  apunta al id -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div id="modal-header" class="modal-header headermodalcss">
                    <!--titulo modal-->
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Liquidación</h5>
                    <!--X de cierre (se puede sacar) usa la propiedad: data-bs-dismiss -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body modalcss">
                    <!--cuerpo del modal-->
                    <form id="idFR1" class="form-control form-control-sm fondo">
                    
                        <div class="mb-2">
                            <label for="idSelOS2" class="form-label">Obra Social</label>
                            <?php
                                $s->selectOs("N", "idSelOS2", "nameSelOS2",null,1);
                            ?>
                            <div><p class="text-danger"><small><?=session('errors.nameSelOS2');?></small></p> </div>
         
                        </div>

                        <div class="mb-2">
                            <label for="idNuAño2" class="form-label">Año</label>
                            <input type="Number"  min = "2023" max = "2100" id="idNuAño2" name="nameAño2"class="form-control form-control-sm">
                            <div><p class="text-danger"><small><?=session('errors.Año2');?></small></p> </div>
         
                        </div>

                        <div class="mb-2">
                            <label for="idNuMes2" class="form-label">Mes</label>
                            <input type="Number"  id="idNuMes2" name="nameMes2"class="form-control form-control-sm">
                            <div><p class="text-danger"><small><?=session('errors.nameMes2');?></small></p> </div>
         
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
                <!--
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="idBtAct" type="button" class="btn btn-sm getstarted">Guardar</button>
                </div> -->
            </div>
        </div>
    </div>
    <!--FIN Modal -->



<!-- Modal generar Liquidaciones desde atenciones-->
    <!-- data-bs-target  apunta al id -->
    <div class="modal fade" id="exampleModal21" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div id="modal-header21" class="modal-header headermodalcss">
                    <!--titulo modal-->
                    <h5 class="modal-title" id="exampleModalLabel21">Generar Liquidaciones desde atenciones pendientes</h5>
                    <!--X de cierre (se puede sacar) usa la propiedad: data-bs-dismiss -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body modalcss">
                    <!--cuerpo del modal-->
                    <form id="idFR21" class="form-control form-control-sm fondo">
                    
                        <div class="row justify-content-center mb-2">
                           <div class="col-auto"> 
                            <label for="idNuAño21" class="form-label">Año</label>
                            <input type="Number"  min = "2023" max = "2100" id="idNuAño21" name="nameAño21"class="form-control form-control-sm" required>
                            </div> 
                           <div class="col-auto">
                            <label for="idNuMes21" class="form-label">Mes</label>
                            <input type="Number"  id="idNuMes21" min="1" max="12" name="nameMes21"class="form-control form-control-sm" required>
                           </div>    
                        </div>

                        <div class="mb-2">
                            <input type="Number" name="nameId21" id="idNuId21" hidden class="form-control form-control-sm"></>
                        </div>

                        <div class="mb-2">
                            <input type="text" id="idInFun21" name="nameFuncion21" hidden class="form-control form-control-sm"></>
                        </div>
                        

                        <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="idBtAct21" type="submit" class="btn btn-sm  btn-danger ">Generar</button>
                </div>
                    </form>

                </div>
                <!--
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="idBtAct" type="button" class="btn btn-sm getstarted">Guardar</button>
                </div> -->
            </div>
        </div>
    </div>
    <!--FIN Modal -->







    <?php
     //Mensaje del crud ok  
if(session('message')){
    echo("<script>
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Base de Datos actualizada',
      showConfirmButton: false,
      timer: 1100
    })</script>");}
  
 
    ?>    




<?= $this->endSection(); ?>





