
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Círculo Odontológico de Rojas V3</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url(); ?>public/lib/templete/Dewi/assets/img/favicon.png" rel="icon">
  <link href="<?= base_url(); ?>public/lib/templete/Dewi/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Boostrap -->
  <link href="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
 
  <!-- Template Main CSS File -->
  <link href="<?= base_url(); ?>public/lib/templete/Dewi/assets/css/style.css" rel="stylesheet">

<!-- SweetAlert2 -->
<link href="<?= base_url(); ?>public/lib/sweetalert2/sweetalert2.min.css" rel="stylesheet">
<script src="<?= base_url(); ?>public/lib/sweetalert2/sweetalert2.min.js"></script>


<!-- ESTILOS PROPIOS -->
<link href="<?= base_url(); ?>public/css/stylemc.css" rel="stylesheet"> 
<link href="<?= base_url(); ?>public/css/stylev3.css" rel="stylesheet">

<!-- JqueryS -->
<script src="<?= base_url(); ?>public/lib/jquery/jquery-3.6.3.min.js"></script>



  <!-- =======================================================
  * Template Name: Dewi - v4.10.0
  * Template URL: https://bootstrapmade.com/dewi-free-multi-purpose-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

<style>
  
  /**Para poder imprimir cualquier pantalla con ctrl + p */
  /**Lo que no quiero que salga impreso le pongo la clase no-print  */
  /**Margenbes de la pagina */
  @page {
    /*margin:100px 25px;*/
    size: A4; 
    margin: 20mm 10mm 10mm 20mm;
  }

  @media print
{
.no-print, .no-print * {
display: none !important;
}}

  .botones-main{
  background-color: red;  
  text-align: center;
  box-shadow: 0 0 30px rgba(214, 215, 216, 0.6);
  padding: 11px 11px 11px 11px;
  border-radius:5px;
  color:white;
  font-size:11px;
  }


  .caja-soporte{
  position:absolute;
  bottom:61px;
  right: 91px;
  padding:11px;
  }
  

 
  </style>

</head>



<body>

<header id="header" class="HeaderFondo" >
 
 <div class="container d-flex align-items-center justify-content-between">

 
   <a href="#" class="logo"><img src="<?= base_url(); ?>public/img/circulo.png" alt="" class="img-fluid"></a> 
   <h1 class="logo"><a href="#">VERSIÓN 3 (TEST)  </a></h1><br> 
   
   
   <!-- Uncomment below if you prefer to use an image logo -->
   

   <!-- .navbar -->
   <nav id="navbar" class="navbar">
     <ul>
       <li><a class="nav-link scrollto active" href="<?= site_url();?>InicioIntra" ?>Inicio</a></li>
       <li class="dropdown"><a href="#"><span>Pacientes</span> <i class="bi bi-chevron-down"></i></a>
         <ul>
            <li><a href="<?=site_url();?>PacientesP">Padrón Pacientes</a></li>
            <li><a href="<?=site_url();?>PacientesP">Códigos Propios</a></li>
            <li><a href="<?=site_url();?>AtencionesP">Carga Atenciones</a></li>
            <li><a href="<?=site_url();?>OdontogramaP">Odontograma</a></li>
            <li><a href="<?=site_url();?>HistoriaP">Historia Clínica</a></li>
            
              
          </ul>
       </li>
       
       <li class="dropdown"><a href="#"><span>Aranceles</span> <i class="bi bi-chevron-down"></i></a>
         <ul>
            <li><a href="<?=site_url();?>MinimosP">Aranceles Mínimos</a></li>
            <li><a href="<?=site_url();?>AdminOSP">Aranceles OS</a></li>
            </ul>
       </li>
       
       <li class="dropdown"><a href="#"><span>Liquidaciones</span> <i class="bi bi-chevron-down"></i></a>
         <ul>
            <li><a href="<?= site_url();?>Liquidaciones">Liquidaciones</a></li>
            <li><a href="<?= site_url();?>EstadoCuentaP">Estado Cuenta por Prestador/OS</a></li>
            <li><a href="<?= site_url();?>LiquidacionMensualP">Resumen Mensual</a></li>
            </ul>
       </li>
       <li class="dropdown"><a href="#"><span>Soporte</span> <i class="bi bi-chevron-down"></i></a>
         <ul>
            <li><a id="BtnCambiarPass">Cambiar contraseña</a></li>
            <li><a href="<?=site_url();?>Tutoriales">Tutoriales</a></li>
            
            </ul>
       </li>
       <li><a href="<?= site_url(); ?>Login/CerrarSesion"><button type="button" class="btn getstarted scrollto">Cerrar Sesion</button> </a></li>
       <!-- Button trigger modal -->
  
     </ul>
     <i class="bi bi-list mobile-nav-toggle"></i>
   </nav>
   <!-- .navbar -->

   <!-- .navbar -->

 </div>
</header><!-- End Header -->


<!-- CONTENIDO -->


<!-- aqui se redibuja la seccion principal de cada pagina que herede de esta plantilla  -->
<?= $this->renderSection('Principal'); ?>


<!-- FIN CONTENIDO -->



<?php 
    require_once APPPATH."/Views/plantilla/globales.php";
    
 ?>

<footer class="fixed-bottom no-print" id="footer">
   
      <div class="container">
        <div class="row">
        <!-- 
        <div class="col-md-2  copyright">
            <i class="bi bi-person-fill"></i> <?php echo (" Rol: ")?> <input id="inTNumCliente" class="datosFooter" type=text  size="6" readonly value=<?=session('rol');?>>
        </div>
        -->  
        
        <div class="col-md-2  copyright">
            <i class="bi bi-person-fill"></i> <?php echo (" Usuario: ")?><input id="inTNomUsuario"class="datosFooter" type=text size="11" readonly  value=<?=session('usuario');?>> 
          </div>
          <div class="col-md-7 copyright">
              &copy; Copyright <strong><span>CirO Software</span></strong>. All Rights Reserved.  Realizado por <a href="#">Claudio Ravagnan</a>
          </div>
          <div class="col-md-3  copyright">
          &copy; Versión <span><?=" ". $Gversion . " (". $GfechaActu .") "; ?></span>  
        </div>
      </div>
    </div>

  </footer>





<!-- Vendor JS Files -->
<script src="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/aos/aos.js"></script>
  <script src="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?= base_url(); ?>public/lib/templete/Dewi/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= base_url(); ?>public/lib/templete/Dewi/assets/js/main.js"></script>
  <!--  JS Globales -->
  <script src="<?= base_url(); ?>public/js/ciro.js"></script>



</body>
</html>




