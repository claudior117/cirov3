
<?= $this->extend('Views/plantilla/plantillaAdmin');?>

<!--declaracion de la seccion a incrustar en la plantilla -->
<?= $this->section('Principal'); ?>
<div class="container">
      <div class="copyright d-flex justify-content-end">
       <strong><span>Bienvenido <?= " " . session('usuario'); ?></span></strong> 
      </div>   
    
</div>  

<div class="row">   
     <div class="col">
       <div class="copyright d-flex justify-content-end m-2 align-middle">
       <a id="idBtnDsb" class="btn btn-sm btn-outline-warning ms-3" data-bs-toggle="collapse"  href="#dashBoard" role="button" aria-expanded="false" aria-controls="dashBoard">
                  DashBoard
         </a>   
      </div>    
      </div>
      

</div>  


<!--gráficos -->
<div class="container position-absolute top-10">
  <div class="row  d-flex justify-content-around align-self-center" id="">   
  <div class="col collapse" id="dashBoard">
  <div class="card">
  <div class="card-body">
    <div class="row">  
        <div class="col-8">
            <div class = "text-center">
                <p>Evolución de los últimos 7 meses </p> 
            </div>       
        </div>    
    </div>
    
    <div class="row">  
        <div class="col-7">
            <div>
              <canvas id="idChartLiq"></canvas>
            </div>       
        </div>    
    </div>
    
    
</div>  
</div>  
</div>  
</div>  

</div>




<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url(); ?>public/js/ciro.js"></script>
<script src="<?= base_url(); ?>public/js/inicio/inicioA.js"></script>


<!-- Modal Alta y Actualizacion Cambiar Contraseña-->
    <!-- data-bs-target  apunta al id -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div id="modal-header" class="modal-header fondo">
                    <!--titulo modal-->
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar Contraseña</h5>
                    <!--X de cierre (se puede sacar) usa la propiedad: data-bs-dismiss -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body ">
                    <!--cuerpo del modal-->
                    <form action="<?=site_url();?>CambiaContraseña" method="POST"  class="form-control form-control-sm fondo">
                    
                        <div class="mb-2">
                            <label for="idPass1" class="form-label">Nueva Contraseña</label>
                            <input type="text"  id="idPass1" name="namePass1"class="form-control form-control-sm">
                            <div><p class="text-danger"><small><?=session('errors.namePass1');?></small></p> </div>
         
                        </div>

                        <div class="mb-2">
                            <label for="idPass2" class="form-label">Repetir contraseña</label>
                            <input type="text"  id="idPass2" name="namePass2" class="form-control form-control-sm">
                            <div><p class="text-danger"><small><?=session('errors.namePass2');?></small></p> </div>
         
                        </div>


                        <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="idBtAct" type="submit" class="btn btn-sm  btn-danger ">Cambiar Contraseña</button>
                </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!--FIN Modal -->

<?= $this->endSection(); ?>



