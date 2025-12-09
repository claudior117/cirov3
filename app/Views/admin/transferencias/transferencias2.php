<?php
    //clases propias globales
    $s = new App\Controllers\clases();
    $MSis = new App\Models\SistemaModel;
    $MTMov = new App\Models\VtaTipoMovModel;
    $MRet = new App\Models\VtaMovModel;

    $r = $MSis -> getSistema();
    if (isset($r)) {
      $puntoVenta = $r->sucursal_inicio;
    }else{
      $puntoVenta = 1;
    }    


    $r = $MTMov -> getTipoMov($puntoVenta,201);
    if (isset($r)) {
      $numComp =  $r->ult_num_c + 1;
    }
    else{
      $numComp = 0;
    }  

     
     

?>

 

<?= $this->extend('Views/plantilla/plantillaAdmin');?>


   

<!--declaracion de la seccion a incrustar en la plantilla -->
<?= $this->section('Principal'); ?>

 

  <main id="main" class ="container">
   
    <section id="about" class="about">
      <div class="container">
          <div class="row">
              <div class="col-5" style="font-size:31px;"><b>Orden Pago Profesionales</b></div>
              <div class="col-1 text-center" style="width:51px; height:51px; border:2px solid black; font-size:31px;">C</div>  
              
              <div class="col-6 text-end">Número comprobante: <input id='idPuntoVta' value="<?=str_pad($puntoVenta, 4, "0", STR_PAD_LEFT);?>" type="number" min="1" max="9999">- <input class="w-25" id="idNumComp" type="number" min="<?=str_pad($numComp, 10, "0", STR_PAD_LEFT);?>"  value="<?=str_pad($numComp, 10, "0", STR_PAD_LEFT);?>"> </div>
          </div>    
          <div class="row text-end">
              <div class="col-6"></div>  
              <div class="col-3 "><p>Fecha: <input class="w-50 me-3"  type="date" id="idFecha" value="<?=date("Y-m-d");?>"></p></div>
              <div class="col-3 no-print">Período: <input class="w-50 me-3" id='idPeriodo' value="<?=$periodo?>" type="number" readonly></div> 
          </div>
              
          </div>  
      </div>
      

        <!--cliente-->
        <div class="" style="background-color: #7FB3D5 ;color:white; margin:0px 2px 0px 2px;border-radius:5px;">  
          <div class="row">
            <div class="row d-flex justify-content-evenly " style="margin:10px 2px;">
              <div class="col-9" style="border:1px solid #EAF2F8; margin:5px; border-radius:3px;"><b>Cliente:</b><p style="display:inline;" id="idCliente"><?=" ". $arrayCli->denominacion;?></p> </div>
              <div class="col-2" style="border:1px solid #EAF2F8; margin:5px; border-radius:3px; ">Id:<p style="display:inline;" id="idIdCliente"><?=" ". $arrayCli->id_cliente;?></p></b>  </div>
            </div>   
          
            
          </div>  
        </div>  
      <!--fin cliente-->
   
      <!--Tabla de datos-->
    <div class="container"> 
      
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <table class="table table-sm  table-bordered m-2">
                    <thead>
                        <td></td>
                        <td>Id</td>
                        <td>Liq</td>
                        <td>Detalle</td>
                        <td>Liquidado</td>
                        <td>Desc.</td>
                        <td>Incr.</td>
                        <td>Ant.</td>
                        <td>Ret.</td>
                        <td>Neto a Prof</td>
                        <!--<td>$.Deuda</td>-->
                       
                    </thead>
                    <tbody id="tb1" style="font-size:13px;">
                    <?php 
                    $MCompDet = new App\Models\VtaMovDetalleModel;
                    //para cada profesional busco y sumo lo facturado
                    $total = 0;
                    $subtotal = 0;
                    $retenciones = 0;
                    $debitos = 0;
                    $incrementos = 0;
                    $anticipos=0;
                    $imp = 0;
                    foreach($arrayProf as $valorP) {
                      $totalprof = 0;
                      $subtotalprof = 0;
                      $retprof = 0;
                      $debprof = 0;
                      $incprof = 0;
                      $antprof = 0;
                      foreach($arrayComp as $clave => $valor) {
                            //busco en el detalle del comprobante lo facturado al prof
                            $r = $MCompDet->buscarProfenComp($valorP['id_usuario'], $valor);
                            foreach($r as $valores) {  
                              //solo facturas 
                               $comprobante = "Liq " . $valores['id_liquidacion'];
                               $factura = "Fc. " . $valores['letra'] . str_pad($valores['sucursal'], 4, "0", STR_PAD_LEFT) . "-". str_pad($valores['num_comprobante'], 10, "0", STR_PAD_LEFT);
                               $imp = $valores['importeliq'] -  $valores['descuento'] +  $valores['incremento'] -  $valores['bonos_anticipos'] ;
                               echo "<tr class='no-print'><td></td><td class=''>" .$valor ."</td><td class=''>" .$valores['id_liquidacion'] ."</td><td class=''>" .$comprobante . " " . $valores['detalle']. " " . $factura ."</td><td class='text-end'>". number_format($valores['importeliq'],2,".","") . "</td><td class='text-end'>". number_format(-$valores['descuento'],2,".","") ."</td><td class='text-end'>". number_format($valores['incremento'],2,".","") . "</td><td class='text-end'>". number_format(-$valores['bonos_anticipos'],2,".","") . "</td><td class='text-end'>0.00</td><td class='text-end'>". number_format($imp,2,".","") ."</td></tr>";
                               $subtotalprof += $valores['importeliq'];
                               $debprof +=  $valores['descuento'];
                               $incprof += $valores['incremento'];
                               $antprof +=$valores['bonos_anticipos'];
                               $totalprof += $imp;
                              }    
                            }
                          

                          if($haceret == 1) {
                            //busco retenciones
                            $q = "select * from vta_movimientos where id_cliente = " . $valorP['id_cliente'] . " and estado_pago='N' and tipo_movvta = 500"; 
                            $r2 = $MRet->getMovimientos($q); 
                            foreach($r2 as $ret) {
                              $comprobante = "Ret " . $ret['letra'] . str_pad($ret['sucursal'], 4, "0", STR_PAD_LEFT) . " " . str_pad($ret['num_comprobante'], 8, "0", STR_PAD_LEFT)   ;
                              $imp = $ret['saldo_impago'];
                              echo "<tr class='no-print'><td></td><td class='classItemRet'>" .$ret['id_vta'] ."</td><td class=''></td><td class=''>" .$comprobante . "</td><td></td><td></td><td></td><td></td><td class='text-end'>". number_format(-$imp,2,".","") . "</td><td class='text-end'></td></tr>";
                              $retprof += $imp;
                           
                            }
                           
                          }

                          if($retprof > $totalprof){
                             //si el total de retener es mayor que el total a trasnferir
                             //solo cancelo las retenciones por el dinero a trasferir
                             // y no trasnfiero nada
                            $retprof = $totalprof;
                             $totalprof = 0;  
                          }
                          else{
                            $totalprof = $totalprof - $retprof;
                          }  
                           
                          

                          if ($totalprof != 0 || $subtotalprof !=0 || $retprof != 0){
                           
                            echo "<tr style='background-color:#e4fbfb'><td></td><td></td><td></td><td><b>".$valorP['nombre'] . " " . $valorP['matricula'] ."</b></td><td class='text-end'><b>". number_format($subtotalprof,2,".","") ."</b></td><td class='text-end'><b>". number_format(-$debprof,2,".","") ."</b></td><td class='text-end'><b>". number_format($incprof,2,".","") ."</b></td><td class='text-end'><b>". number_format(-$antprof,2,".","") ."</b></td><td class='text-end'><b>". number_format(-$retprof,2,".","") ."</b></td><td class='text-end'><b>". number_format($totalprof,2,".","") ."</b></td></tr>";
                          }
                          $subtotal += $subtotalprof;
                          $retenciones += $retprof;
                          $total += $totalprof;
                          $debitos += $debprof;
                          $incrementos += $incprof;
                          $anticipos += $antprof;
                          //$totalprof =0;          
                          
                    }    
                    ?>
                    </tbody>
                </table>
                
                <div class="row">
                  <div class="col-5">
                   <?php 
                   if($haceret == 0){ 
                        echo('<input type= "checkbox" id="idchret" disabled>Esta transferecina no descuenta retenciones');
                   }
                   else
                   {
                    echo('<input type= "checkbox" id="idchret" disabled checked>Esta transferecina descuenta retenciones');
                   }
                   ?>
                  </div>
                    <div class="col-7">
                    <table class="table table-sm  table-black-50 table-striped table-hover table-bordered m-2">
                        <thead class="text-end">
                            <td>Total Liq.</td>
                            <td>Debitos</td>
                            <td>Incrementos</td>
                            <td>Bonos/Ant</td>
                            <td>Retenciones</td>
                            <td>Neto a Profesionales</td>
                        </thead>
                        <tbody class ="text-end" style="font-size:13px;">
                        <?php 
                          echo("<tr><td id='idSubtotal'>".number_format($subtotal,2,".","") ."</td>");
                          echo("<td id='idSubtotal'>".number_format(-$debitos,2,".","") ."</td>");
                          echo("<td id='idSubtotal'>".number_format($incrementos,2,".","") ."</td>");
                          echo("<td id='idSubtotal'>".number_format(-$anticipos,2,".","") ."</td>");
                          echo("<td id='idOtros'>".number_format(-$retenciones,2,".","") ."</td>");
                          echo("<td id='idTotal'>".number_format($total,2,".","") ."</td></tr>");

                        
                             ?>  
                        </tbody>
                    </table>
                    <div id="idBotonesFactura" class="modal-footer no-print" >
                        <a href="<?= site_url();?>Transferencias"> <button type="button" id="idBtCerrar" class="btn btn-sm btn-secondary me-3">Cerrar</button></a>
                        <?php
                          echo('<button id="idBtTransferir" type="button" class="btn btn-sm btn-danger">Transferir</button>');
                        ?>
                   </div>

                  </div>
                </div>       



                <br>
                <br>
               
            </div>
           
        </div>
    </div>
    
    </div>    

  </div>

</div> 


<!--armo esta tabla oculta para mandar los comrpobantes seleccionados-->
<table hidden>
  <?php  
    foreach($arrayComp as $clave => $valor) {
      echo("<tr><td class='classItemFactura'>".$valor."</td></tr>");
    }  
  ?>
</table>    


  </section><!-- End About Section -->
 <center> <div id="idEspere" style="margin:3px; visibility:hidden;background-color:#FF4A17;height:21px;width:90%; color:white;">| | | | | | | | | | | | | | | procesando . . .</div> </center>
 
</main><!-- End #main -->



<!-- JS -->
<script src="<?= base_url(); ?>js/ciro.js"></script>
<script src="<?= base_url(); ?>js/pagos/transf2.js"></script>




<?= $this->endSection(); ?>
