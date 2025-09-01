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
              <div class="col mb-1 mx-3 LineaTituloP2 d-flex justify-content-end">
                <strong>
                <?php 
                  echo (strtoupper($arregloOs->os) . " </strong>  COBERTURA y ARANCELES");
                ?>
              </div>
            </div>  
         
            <!--Botones Superiores -->         
            <div class="row">
              <div class="col-2 d-flex align-items-center">
                        <a class="btn_mc_mini_imprimir" href="<?=site_url();?>ReporteItemsOs\<?= $arregloOs->id_os; ?>" data-toggle="tooltip" data-placement="top" title="Imprimir"><i class="bi bi-printer-fill"></i></a>
              </div>
              
              <div class="col-2"><input type="text" class="form-control mt-1" id="idSerchCod" placeholder="Buscar aqui por código..."></div>
              <div class="col-5">
                <input type="text" class="form-control mt-1" id="idSerchDesc" placeholder="Buscar aqui por nombre...">
              </div>
              <!--input--> 
              <div class="col-1">
                        <input type="text" hidden readonly id="idIdOs" value= <?=$arregloOs->id_os;?>>
              </div>
              
              <div class="col-2 d-flex justify-content-end">
                        <a class="btn_mc_mini_volver" href="<?=site_url();?>AdminOSP" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
              </div>
                       
            </div>
            <!--Fin botones superiores -->   
      </div>
      
      
           <!--Tabla de datos-->
    <div class="container">
        <div class="row">
          <div class="col-1"></div>  
          <div class="col-10">
                <table class="table tablacss table-sm table-black-50 table-hover table-bordered m-2">
                    <thead class="cabtablacss">
                        <td>Acciones</td>
                        <td>Código</td>
                        <td>Item</td>
                        <td>Cobertura</td>
                        <td>Coseguro</td>
                        <td>Fecha Actu</td>
                        
                        
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb2" style="font-size:13px;">

                    <?php
                            $cant = 0;
                            foreach ($arregloItems as $valores){
                                $cant +=1;
                                echo("<tr class='align-middle'>");
                                
                                echo("<td> </td>");
                                echo("<td>". $valores['codigo']. "</td>");
                                echo("<td>". $valores['desc_item']. "</td>");
                                echo("<td class='text-end' style='font-size:15px;'><b>". number_format($valores['precio'],2,".","") . "<b></td>");
                                echo("<td class='text-end' style='font-size:15px;'><b>". number_format($valores['coseguro'],2,".","") . "<b></td>");
                                echo("<td class='text-center'>". $valores['fecha_ult_actualizacion']. "</td>");
                                echo("</tr>");
                                         
                            }
                            echo("<tr class='align-middle'><td></td><td></td><td><b>Cantidad de items: ". $cant. "</td><td></td><td></td>
                            <td></td><td></td></tr>");
                            
                    ?>

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
    
</div>

        </div> 

  </section><!-- End About Section -->
 <center> <div id="idEspere" style="margin:3px; visibility:hidden;background-color:#FF4A17;height:21px;width:90%; color:white;">| | | | | | | | | | | | | | | procesando . . .</div> </center>
 
</main><!-- End #main -->

<!-- JS -->
<script src="<?= base_url(); ?>public/js/ciro.js"></script> 
<script src="<?= base_url(); ?>public/js/os/itemosP.js"></script> 

  <?= $this->endSection(); ?> 
  
