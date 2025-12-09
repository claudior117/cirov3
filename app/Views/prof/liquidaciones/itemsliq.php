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
                <strong>Liquidación: </Strong> Detalle
              </div>
          </div>  
         
           <div class="row justify-content-around align-items-center no-print" >
             
            <div class="col-1 d-flex align-items-center">
                      <a class="btn_mc_mini_imprimir" href="<?=site_url();?>ReporteLiq/<?=$arregloLiq->id_liq;?>" id="idBtImprimir" data-toggle="tooltip" data-placement="top" title="Imprimir Listado de Liquidaciones"><i class="bi bi-printer-fill"></i></a>
            </div>
             
           
            <div class="col-4" >       
              <div class="input-group input-group-sm w-75 ">
                <label for="idTeIdLiq" class="input-group-text labelcss">Liquidacion:</label>  
                  <input type="text" id="idTeIdLiq" readonly class="form-control form-control-sm w-10" value="<?=$arregloLiq->id_liq;?>">
                  <input type="text" id="idTeOS" readonly class="form-control form-control-sm w-50" value='<?=$arregloLiq->os;?>'>
           
                </div>
            </div>

            
           <div class="col-3" >       
              <div class="input-group input-group-sm w-75 ">
                <label for="idTeMes" class="input-group-text labelcss">Periodo</label>  
                <input type="text" id="idTeMes" readonly class="form-control " value="<?=$arregloLiq->mes;?>">
                <input type="text" id="idTeAño" readonly  class="form-control w-25" value='<?=$arregloLiq->año;?>'>
             
              </div>
            </div>

            <div class="col-1">       
              <input type="text" size= "3" id="idTeIdOS"  hidden class="" value='<?=$arregloLiq->id_os;?>'>
            </div>

            <div class="col-3 d-flex justify-content-end ">
              <?php
                        echo('<button id="idBtGuardar2" type="button" class="btn btn-sm btn-danger">Guardar</button>');
              ?>
              <a class="btn_mc_mini_volver align-middle" href="<?= site_url();?>Liquidaciones" id="idBtvolver" data-toggle="tooltip" data-placement="top" title="Volver"><i class="bi bi-box-arrow-in-left"></i></a>
            </div>


            </div>
        </div>   

           <!--Tabla de datos-->
    <div class="container">
        <div class="row">
          <div class="col-1"></div>
          <div class="col-10">
                <table class="table tablacss table-sm table-black-50 table-hover table-bordered  m-2" >
                    <thead class="cabtablacss">
                         <td></td>
                        <td>Id</td>
                        <td>Código</td>
                        <td class="col-sm-8">Item</td>
                        <td >Cant.</td>
                        <td class="col-sm-1">Arancel</td>
                        <td class="col-sm-1">Importe</td>
                        
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb2" style="font-size:11px;">

                    <?php
                            $total = 0;
                            $i = 0;
                           
                            foreach ($arregloItems as $valores){
                             
                                echo("<tr>");

                                if ($valores['cantidad'] > 0){
                                  $lineainicial = "<td id='idCIL". $valores['id_itemos']. "' class='centrartexto botonesItems'><i class='bi bi-circle-fill'></i></td>";
                                }
                                else{
                                  $lineainicial = "<td id='idCIL". $valores['id_itemos']. "' class='centrartexto botonesItems'></td>";
                                }
                                
                               
                                if($arregloLiq->estado != 'B'){
                                  $sololec = " readonly ";
                                  
                                }else
                                {
                                  $sololec = "";
                                }
                                echo($lineainicial);
                                echo("<td>". $valores['id_itemos']. "</td>");
                                echo("<td>". $valores['codigo']. "</td>");
                                echo("<td>". $valores['desc_item']. "</td>");
                                echo("<td><input type='number' style='width: 90%;'  min=0 id='". $valores['id_liqitem']."' " . $sololec . " class='claseInputItem  text-center inputcss m-0' value=" . $valores['cantidad']. "></td>");
                                echo("<td class='text-end' id='CC". $valores['id_itemos']. "' >". number_format($valores['pu'],2,".",""). "</td>");
                                echo("<td class='text-end fs-6 CelImporte' id='CI". $valores['id_itemos']. "'>". number_format($valores['importe'],2,".",""). "</td>");
                                
                                echo("</tr>");
                                $total = $total + $valores['importe'];         
                            }
                            echo("<tr>");
                            echo("<td></td>");
                            echo("<td></td>");
                            echo("<td></td>");
                            echo("<td ></td>");
                            echo("<td></td>");
                            echo("<td class='fs-6'><b> TOTAL</b> </td>");
                            echo("<td id='resultado_total' class='fs-6 text-end'><b>". number_format($total,2,".","") . "</b></td>");
                            
                            echo("</tr>");
                        

                    ?>
                    </tbody>

                </table>
                
                  <div class="d-flex justify-content-end">
                    <a href="<?= site_url();?>Liquidaciones"> <button type="button" id="idBtCerrar" class="btn btn-sm btn-secondary me-3">Cerrar</button></a>
                    
                    <?php
                      echo('<button id="idBtGuardar" type="button" class="btn btn-sm btn-danger">Guardar</button>');
                    ?>
                    
                </div>
                <br>
                    <br>
                    <br>
                
                <center> <div id="idEspere" style="margin:3px; visibility:hidden;  background-color:#FF4A17;height:21px;width:90%; color:white;">| | | | | | | | | | | | | | | procesando . . .</div> </center>
     
                </div>
     </div>
        
        <div class="row">
          <br>
          <br>
          
        </div>  
    </div>
      
</div>
    
</div>

        </div> 









  </section><!-- End About Section -->
 
</main><!-- End #main -->

 <!-- JS -->
 <script src="<?= base_url(); ?>js/ciro.js"></script>
 <script src="<?= base_url(); ?>js/liq/itemsliq.js"></script>
  


  <?= $this->endSection(); ?> 
  
