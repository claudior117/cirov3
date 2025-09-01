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
              <strong>OBRAS SOCIALES CON COBERTURA SOBRE: </strong>
               <?php 
              if(count($arregloItems)>0){
                    echo( " (" .  $arregloItems[0]['codigo'] . ") *" . $arregloItems[0]['desc_item'] . "*") ;  
               }
               else{
                   echo ("*** Sin Cobertura ***");    
               }  

               ?>
            </div>
            </div>  
         
            <!--Botones Superiores -->         
            <div class="row">
              <div class="col-1 d-flex align-items-center">
                        <a class="btn_mc_mini_imprimir" id="idBtImprimir" data-toggle="tooltip" data-placement="top" title="Imprimir"><i class="bi bi-printer-fill"></i></a>
              </div>
              
              <div class="col-9"></div>
              <div class="col- d-flex justify-content-end">
                        <a class="btn_mc_mini_volver" href="<?= site_url();?>MinimosP" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
              </div>
                       
            </div>
            <!--Fin botones superiores -->   
      </div>
      
   
   
      <!--Tabla de datos-->
    <div class="container"> 
        <div class="row">
            <div class="col-2"></div>
            <div class="col-7">
                <table class="table tablacss table-sm table-black-50 table-hover table-bordered m-2">
                    <thead class="cabtablacss">
                        <td>Acciones</td>
                        <td>Id</td>
                        <td>Obras Social</td>
                        <td>Cobertura</td>
                        <td>Ult.Actu</td>
                        
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb1" style="font-size:13px;">
                    <?php
                            $i = 0;
                            foreach ($arregloItems as $valores){
                                echo("<tr class='align-middle'>");
                                echo("<td> </td>");
                                echo("<td>". $valores['id_os']. "</td>");
                                echo("<td>". $valores['os']. "</td>");
                                echo("<td class='text-end' style='font-size:15px;'><b>". number_format($valores['precio'],2,".","") . "<b></td>");
                                echo("<td class='text-center'>". $valores['fecha_ult_actu_precios']. "</td>");
                                echo("</tr>");
                                         
                            }
                            
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

  </section><!-- End About Section -->
 <center> <div id="idEspere" style="margin:3px; visibility:hidden;background-color:#FF4A17;height:21px;width:90%; color:white;">| | | | | | | | | | | | | | | procesando . . .</div> </center>
 
</main><!-- End #main -->



<!-- JS -->

  





<?= $this->endSection(); ?>
