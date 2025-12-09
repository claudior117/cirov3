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
                <strong>
                <?php 
                  echo (strtoupper($arregloOs->os) . " </strong>  COBERTURA: Modificar cobertura y aranceles ");
                ?>
              </div>
            </div>  
         
            <!--Botones Superiores -->         
            <div class="row">
              <div class="col-1 d-flex align-items-center">
                        <a class="btn_mc_mini_agregar" id="idBtAgregar" href="<?=site_url().'OsAgregarItemOs/'.$arregloOs->id_os;?>" data-toggle="tooltip" data-placement="top" title="Agregar"><i class="bi bi-plus-circle-fill"></i></a>
                        <a class="btn_mc_mini_imprimir" href="<?=site_url();?>ReporteItemsOs\<?= $arregloOs->id_os; ?>" data-toggle="tooltip" data-placement="top" title="Imprimir"><i class="bi bi-printer-fill"></i></a>
              </div>
              <div class="col-9"></div>
              <div class="col-2 d-flex justify-content-end">
                        <a class="btn_mc_mini_volver" href="<?=site_url();?>AdminOS" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
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
                        <td>Acciones</td>
                        <td>Código</td>
                        <td>Item</td>
                        <td class="text-center">a cargo OS</td>
                        <td class="text-end">Coseguro</td>
                        <td>Fecha Actu</td>
                        <td>Interno</td>
                        
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb2" style="font-size:13px;">

                    <?php
                            $cant = 0;
                            foreach ($arregloItems as $valores){
                              $cant += 1;  
                              echo("<tr class='align-middle'>");
                                ?>
                                <td class='centrartexto'><a id='btnTblEditar' class ='btn_tbl_mini_editar'  data-toggle='tooltip' data-placement='top' title='Actualizar' onclick=actualizaItems2(<?=$valores['id_itemos'];?>)><i class="bi bi-clipboard-check-fill"></i></a><a id='idBtnBorrar'  class ='btn_tbl_mini_borrar '  data-toggle='tooltip' data-placement='top' title='Eliminar' onclick=borrarItemOs(<?=$valores['id_itemos'];?>)><i class='bi bi-trash-fill'></i></a></td>
                
                                <?php 
                                
                                echo("<td>". $valores['codigo']. "</td>");
                                echo("<td>". $valores['desc_item']. "</td>");
                                echo("<td style='font-size:15px;'><input type='number' min=0 id='". $valores['id_itemos']."' class='claseInputItem text-end' value=" . number_format($valores['precio'],2,".","") . "></td>");
                                echo("<td class='text-end' style='font-size:15px;'>". number_format($valores['coseguro'],2,".","") . "</td>");
                                echo("<td>". $valores['fecha_ult_actualizacion']. "</td>");
                                echo("<td>". $valores['id_itemos']. "</td>");
                                
                                echo("</tr>");
                                         
                            }

                            echo("<tr class='align-middle'><td></td><td></td><td><b>Cantidad de items: ". $cant. "</td><td></td><td></td>
                            <td></td><td></td></tr>");
                        
                            echo('<input id="idos" value="'. $arregloOs->os . '" hidden >'); 
                            
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
                  <button type="button" id="IdBtnActualizar" class="btn btn-sm btn-danger mt-3">Actualizar</button>
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
<script src="<?= base_url(); ?>js/os/itemos.js"></script>
  


  <?= $this->endSection(); ?> 
  
