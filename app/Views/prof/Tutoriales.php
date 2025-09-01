



<?= $this->extend('Views/plantilla/plantilla');?>

<!--declaracion de la seccion a incrustar en la plantilla -->
<?= $this->section('Principal'); ?>
<div class="container">
   <div class="row">   
     <div class="col">
       <div class="copyright d-flex justify-content-end m-2 align-middle">
         <strong><span>Hola <?= " " . session('usuario') . ", recuerda ver los "; ?></span></strong>
         
      </div>    
      </div>
      
</div>   
</div> 

<div class="container">
   <div class="row justify-content-around">   
     <div class="col-3">
     <iframe width="400" height="275" src="https://www.youtube.com/embed/g-CsBoXCzbI?si=FpaTiYCN-YZlmu-V" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>    
    </div>
      
     <div class="col-3">
     <iframe width="400" height="275" src="https://www.youtube.com/embed/41X8l2iccYE?si=v3PInMeGiv4W5MOw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> 
    </div>
      
     <div class="col-3">
     <iframe width="400" height="275" src="https://www.youtube.com/embed/_QwdkgqnNrI?si=fIke71RqAbHFnmrn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>
      
</div>   

</div> 








                  
            
<section id="contact" class="contact caja-soporte">
            <div class="botones-main">
                <i class="bi bi-whatsapp"></i>
                <h5>Soporte Whatsapp</h5>
                <h6>+54 9 2475413195 (Valentín)</h6>
    </div>
<section>          





<div class="container  fixed-bottom ">
      <div class="row">
            <div class="col-1"></div>
            
            <div class="col-9 collapse" id="collapseExample">  
  <div class="card">
  <div class="card-body">
            
            <div style="height: 250px; background-color: rgba(161, 161, 161, 0.1); border-radius: 5px;">
            <div class="float-end">
            
            
            <svg class = "mt-2" onclick="idMarcoMsj.start()" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill=rgba(255,71,23) class="bi bi-caret-up-square-fill" viewBox="0 0 16 16">
            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4 9h8a.5.5 0 0 0 .374-.832l-4-4.5a.5.5 0 0 0-.748 0l-4 4.5A.5.5 0 0 0 4 11z"/>
            </svg>
            
            <!--detener-->
            <svg class = "mt-2 me-2" onclick="idMarcoMsj.stop()" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill=rgba(255,71,23) class="bi bi-sign-stop-fill" viewBox="0 0 16 16">
            <path d="M10.371 8.277v-.553c0-.827-.422-1.234-.987-1.234-.572 0-.99.407-.99 1.234v.553c0 .83.418 1.237.99 1.237.565 0 .987-.408.987-1.237Zm2.586-.24c.463 0 .735-.272.735-.744s-.272-.741-.735-.741h-.774v1.485h.774Z"/>
            <path d="M4.893 0a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146A.5.5 0 0 0 11.107 0H4.893ZM3.16 10.08c-.931 0-1.447-.493-1.494-1.132h.653c.065.346.396.583.891.583.524 0 .83-.246.83-.62 0-.303-.203-.467-.637-.572l-.656-.164c-.61-.147-.978-.51-.978-1.078 0-.706.597-1.184 1.444-1.184.853 0 1.386.475 1.436 1.087h-.645c-.064-.32-.352-.542-.797-.542-.472 0-.77.246-.77.6 0 .261.196.437.553.522l.654.161c.673.164 1.06.487 1.06 1.11 0 .736-.574 1.228-1.544 1.228Zm3.427-3.51V10h-.665V6.57H4.753V6h3.006v.568H6.587Zm4.458 1.16v.544c0 1.131-.636 1.805-1.661 1.805-1.026 0-1.664-.674-1.664-1.805V7.73c0-1.136.638-1.807 1.664-1.807 1.025 0 1.66.674 1.66 1.807ZM11.52 6h1.535c.82 0 1.316.55 1.316 1.292 0 .747-.501 1.289-1.321 1.289h-.865V10h-.665V6.001Z"/>
            </svg>      
      
            
            </div> 
            <marquee id="idMarcoMsj"style="font-family:Courier;font-size:13pt;color:#FF8C48;height:201px;"scrollamount="3" direction="up">
            
            </marquee> 
            </div>      
</div>
</div>
   
      </div>
      </div>

</div>


<!-- JS -->
<script src="<?= base_url(); ?>public/js/ciro.js"></script>
<script src="<?= base_url(); ?>public/js/inicio/inicio.js"></script>





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



