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
                <strong>Liquidaciones: </Strong> Ver y Facturar
              </div>
            </div>  
         
           <div class="row">
             
                <div class="col-1 d-flex ">
                        <a class="btn_mc_mini_mostrar " id="idBtMostrar" data-toggle="tooltip" data-placement="top" title="Mostrar liquidaciones"><i class="bi bi-file-text-fill"></i></a>
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
                    <div class="input-group input-group-sm ">
                        <label for="idInNumAño" class="input-group-text labelcss">Periodo </label>
                        <input type="Number" id="idInNumAño" class="form-control ms-1"  min="2023" max="2100" value="<?=date("y");?>">
                        <input type="Number" id="idInNumMes" class="form-control ms-1"  min="0" max="12" value="<?=date("m");?>">
                    </div>
                </div>

           
                <div class="col-3" style="margin:3px;">       
                    <div class="input-group input-group-sm ">
                        <label for="idSelEstado" class="input-group-text labelcss">Estado  </label>
                        <select id="idSelEstado" class="form-control form-select ms-1">
                                <option value="T">**Todas**</option>
                                <option value="E">Enviadas (Sin Facturar)</option>
                                <option value="F">Facturadas (Sin trasnferir)</option>
                                <option value="P">Pagas (Facturadas y Transferidas)</option>
                        </select>  
                    </div>
                </div>

                <div class="col-1 d-flex justify-content-end ">
                    <a class="btn_mc_mini_volver align-middle" href="<?= site_url();?>InicioIntra" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
                </div>
            
            </div> <!--fin fila -->

            <div class="row">
                <div class="col-1 d-flex ">
                </div>
                
                <div class="col-3" style="margin:2px;">       
                    <div class="input-group input-group-sm ">
                        <label for="idSelOS" class="input-group-text labelcss">Profesionales  </label>
                        <?php
                            $s->selectProfesionales("S");
                        ?>
                    </div>
                </div>

                <div class="col-3" style="margin:2px;">       
                    <div class="input-group input-group-sm ">
                        <label for="idSelEstadoPago" class="input-group-text labelcss me-1">Pago </label>
                          <select name="" id="idSelEstadoPago" class="form-control form-select ms-1">
                               <option value="T">***Todas***</option>
                               <option value="N">Sin cobrar</option>
                               <option value="P">Cobrada</option>
                          </select>
                    </div>
                </div>


                <div class="col-3" style="margin:2px;">       
                    <div class="input-group input-group-sm ">
                        <label for="idSelCliente" class="input-group-text labelcss me-1">Cliente </label>
                        <?php
                            $s->selectClientes("S");
                        ?>
                    </div>
                </div>
            
            </div> <!-- fin fila -->
      </div>   

           <!--Tabla de datos-->
    <div class="container">
        <div class="row">
        
            <div class="col-12">
                <table class="table tablacss table-sm table-black-50 table-hover table-bordered m-2" id="MiTabla">
                    <thead class="cabtablacss">
                      
                        <td>Acciones</td>
                        <td>Id</td>
                        <td>Periodo</td>
                        <td>OS</td>
                        <td>Importe</td>
                        <td>Desc.</td>
                        <td>Incr.</td>
                        <td>Total</td>
                        <td>Ant/Bonos</td>
                        <td>Enviada</td>
                        <td>Factura </td>
                        <td>Transf</td>
                        <td>Profesional</td>
                        <td>Estado</td>
                        <td>Pago</td>
                        <td>Factura <input type='checkbox'  id='idSeleccionaTodos'></td>
                        <td>Modif.</td>
                        
                        
                        
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb1" style="font-size:11px;">

                    </tbody>

                </table>
                <div id="idBotonesFactura" class="modal-footer" >
                    <a href="<?= site_url();?>LiquidacionesA"> <button type="button" id="idBtCerrar" class="btn btn-sm btn-secondary me-3">Cerrar</button></a>
                    <?php
                      echo('<button id="idBtFacturar" type="button" class="btn btn-sm btn-danger">Generar Factura</button>');
                    ?>
                </div>
                
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-6"> <p class="ms-3">Estado: [E]nviada -[F]acturada - [P]aga(Transferida)  </p> </div>
                    <div class="col-6"> <p>Pago: [P]aga(Cobrada) - [N]o paga</p> </div>
                    
                    
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
<script src="<?= base_url(); ?>public/js/liq/liqA.js"></script>

<script>
    buscaDatos()
</script>



<!-- Modal Descuentos e Incrementos-->
    <!-- data-bs-target  apunta al id -->
    <div class="modal fade" id="ModalAjuste" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content ">
                <div id="modal-header" class="modal-header headermodalcss">
                    <!--titulo modal-->
                    <h5 class="modal-title" id="exampleModalLabel">Ajuste de liquidaciones pevios a la facturación: Descuentos e Incrementos</h5>
                    <!--X de cierre (se puede sacar) usa la propiedad: data-bs-dismiss -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body modalcss">


                    <!--cuerpo del modal-->
                    <form id="idFrAjuste" class="form-control form-control-sm fondo">

                        <!--Datos Liquidacion-->
                        <div class="row">
                            <div class="col-2 mb-2">
                                <label for="idIdLiq" class="form-label">Liquidación</label>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-2 mb-2">
                                <input type="Text" readonly id="idIdLiq" name="nameIdLiq" class="form-control form-control-sm">
                            </div>
                            <div class="col-5 mb-2">
                                <input type="Text" readonly id="idProf" name="nameProf" class="form-control form-control-sm">
                            </div>
                            <div class="col-3 mb-2">
                                <input type="Text" readonly id="idOs" name="nameOs" class="form-control form-control-sm">
                            </div>
                            <div class="col-2 mb-2">
                                <input type="Text" readonly id="idPeriodo" name="namePeriodo" class="form-control form-control-sm">
                            </div>
                        </div>  
                        <hr>

                        <div class="row mb-4 ">
                           
                            <div class="col-3">
                                <label for="idDescuento" class="form-label">Descuento</label>
                                <input type="Text"  min = "0" id="idDescuento" name="nameDescuento" class="form-control form-control-sm inputcss">
                            </div>
                            <div class="col-3">
                                <label for="idIncremento" class="form-label">Incremento</label>
                                <input type="Text"    id="idIncremento" name="nameIncremento" class="form-control form-control-sm inputcss">
                            </div>

                            <div class="col-6">
                                <label for="idDetalle" class="form-label">Detalle</label>
                                <input type="text"  id="idDetalle" name="nameDetalle" class="form-control form-control-sm inputcss" value="Ajuste ">
                            </div>
                            
                            </div>
                            
                            <div class="row mb-5 ">
                            <div class="col-3">
                                <!--
                                <input  type="checkbox"  id="idGenera" name="nameGenera" class="inputcss form-check-input " >
                                <label for="idGenera" class="form-label">Genera Movimiento</label>
                                -->
                            </div>
                        </div>

                       
                        
                        <div class="row">
                        <div class="col-7"></div>
                        <div class="col-4">    
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button id="idBtAct" type="submit" class="btn btn-sm  btn-danger ">Guardar</button>
                            </div>
                         </div>    
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





