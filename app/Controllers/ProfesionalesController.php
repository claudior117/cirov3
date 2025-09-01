<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use UsuarioModel;

class ProfesionalesController extends Controller{
    public function getProfesionales()
    {
        if (session()->has("idUsuario")) {
            $Mprof = new UsuarioModel;
            $r = $Mprof->getProfesionales();
            if (count($r)>0){
                return $r;
            }
            

          }
          else{
              return redirect()->to(base_url('/'));  
          }
    }
}