<?php 
namespace App\Controllers;






use CodeIgniter\Controller;
use App\Models\OsModel;
use App\Models\MinimosModel;
use App\Models\OsItemsModel;
use App\Models\MensajesModel;

//Libreria Ciro
use App\Libraries\CiroLibreria;


//phpspreadsheet para trabajar con excel 
//require_once APPPATH . "ThirdParty\phpxls\PhpOffice\autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;





class OsController extends Controller{
//Os Admin
    public function Index()
    {
        if (session()->has("idUsuario") && session('rol')=='A') {
            return view('admin/os/index');
          }
          else{
              return redirect()->to(site_url());  
          }
    }

//OS prof
    public function IndexP()
    {
        if (session()->has("idUsuario") && session('rol')=='P')  {
            return view('prof/os/index');
          }
          else{
              return redirect()->to(site_url());  
          }
    }


    //Consultas todas las OS
    public function getOs()
    {
        
        if (session()->has("idUsuario")) {
            $MOs = new OsModel;
            $r = $MOs->getOs("select os.*, denominacion from os, clientes where os.id_cliente = clientes.id_cliente order by os");
            if (count($r)>0){
                echo json_encode($r);
            }
          }
          else{
              return redirect()->to(site_url());  
          }
    }


    //Muestra Pdf de Normas de Trabajo
    public function MostrarPdf($id)
    {
        
        if (session()->has("idUsuario")) {
            //buscar archivo y mandar a vista
            $MOs = new OsModel;
            $r = $MOs->buscarPorId($id);
           $datos = ["arregloItems"=>$r]; 
           
           $archivo = base_url() . 'normas/' . $r->pdf_normas;
           return redirect()->to($archivo);
              
           // return redirect()->to(base_url().'normas/amsterdam.pdf');
            
        }
          else{
              return redirect()->to(site_url());  
          }
    }

    //Agregar
    public function agregarOs()
    {
        if (session()->has("idUsuario") && session('rol')=='A' ) {
           
            return view('admin/os/Agregar'); 
          }
          else{
            return redirect()->to(site_url());  
          }
    }

    //Modificar
    public function modifOs($id)
    {
        if (session()->has("idUsuario") && session('rol')=='A') {
            $MOs = new OsModel;
            $r = $MOs->buscarPorId($id);
            $datos = ["arregloItems"=>$r]; 
            return view('admin/os/modificar', $datos);    
             
          }
          else{
            return redirect()->to(site_url());  
          }
    }


     //borrar OS
     public function borrarOs($id)
     {
         if (session()->has("idUsuario") && session('rol')=='A') {
            $MOs = new OsModel;
            $r = $MOs->buscarPorId($id);
            $datos = ["arregloItems"=>$r]; 
            return view('admin/os/borrar', $datos);  
           }
           else{
             return redirect()->to(site_url());  
           }
     }

    public function guardarOs($f)
    {
            //recibo los valores
            $nos = $_POST['nameOs'];
            $MOs = new OsModel;
            $data=['os'=>$nos];
            
            $v = ["nameOs" => "required|min_length[2]|max_length[100]"] ;

            if ($this->validate($v)){
                if ($f == 'U'){
                    $idos = $_POST['nameIdOs'];
                    $MOs->update($idos, $data);
                }else{
                    if ($f=='D'){
                        $idos = $_POST['nameIdOs'];
                        $MOs->delete($idos);
                    }else
                    {
                    $MOs->insert($data);
                    }
                }
                return redirect()->to(site_url('AdminOS'))->with('message','Operación Correcta');
            }
            else{
                //Vuelve atras mandando los errores de validacion
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()) ;
            }    
    }
    



    //items - Os
    public function BuscarItemsOs($L)
    {
        if (session()->has("idUsuario") ) {
            $MOIs = new OsItemsModel;
            $r = $MOIs->buscarItemsOs($L);
            
            $MOs = new OsModel;
            $r2 = $MOs->buscarPorId($L);
            
            $datos = ["arregloItems"=>$r, "arregloOs" =>$r2]; 

            if (session('rol')=='A'){
                return view('admin/os/itemsos', $datos);
            }
            elseif (session('rol')=='P'){
                return view('prof/os/itemsos', $datos);
            }

          }
          else{
              return redirect()->to(site_url());  
          }
    }
    

 //Consultas Item OS por ajax
 public function getItemOsAjax()
 {
     if (session()->has("idUsuario")) {
        $q = "select * from items_os " . $_POST['q'];
        
       
        $MIOs = new OsItemsModel;
         $r = $MIOs->getItemOs($q);
         if (count($r)>0){
             echo json_encode($r);
         }
       }
       else{
           return redirect()->to(site_url());  
       }
 }





    public function actualizaPrecios(){
        //recibo los valores
      if (session()->has("idUsuario") && session('rol')=='A' ) {  
        $MOsI = new OsItemsModel;
        $p = $_POST['precio'];
        $iditemos = $_POST['iditemos'];
        $data = ["precio"=>$p, "fecha_ult_actualizacion"=>date("Y-m-d")];
        $MOsI->update($iditemos, $data);
        
    }
    else{
        return redirect()->to(site_url());  
    }  
    }
    
    //borrar Item Os
    public function borrarItemOs()
    {
        if (session()->has("idUsuario") && session('rol')=='A' ) {
           $MIOs = new OsItemsModel;
           $id = $_POST['iditemos'];
           $MIOs->delete($id);  
           /*
           if ($r){
               //correcto
               echo("1");
           } 
           else{
               echo("0");
           }
           */
          }
          else{
            return redirect()->to(site_url());  
          }
    }

    
    //datos para la vista agregar items a oS
    public function OsAgregarItemOs($idos)
    {
        if (session()->has("idUsuario") && session('rol')=='A') {
            $MOIs = new OsItemsModel;
            $r = $MOIs->buscarNoItemsOs($idos);
            
            $MOs = new OsModel;
            $r2 = $MOs->buscarPorId($idos);
            
            $datos = ["arregloItems"=>$r, "arregloOs" =>$r2]; 

            return view('admin/os/agregaritemos', $datos);
            
          }
          else{
              return redirect()->to(site_url());  
          }


    }
    
    //actualiza datos de items en os
    public function AgregaItemOs()
    {
        if (session()->has("idUsuario")&& session('rol')=='A') {
            $idi = $_POST['iditem'];
            $idos = $_POST['idos'];
            $MOIs = new OsItemsModel;
            
            //recupero los valores del item
            $r = $MOIs->buscaItemporId($idi);
             
            $data=['id_item'=>$idi, 'id_os'=>$idos, 'fecha_ult_actualizacion'=>date('Y-m-d'), 'precio'=>0, 'tasa_iva'=>21, 'codigo'=>$r->codigo, 'desc_item' => $r->item];

            $MOIs->insert($data);
            
          }
          else{
              return redirect()->to(site_url());  
          }


    }



    //actualizar precios desde excel

    //llama a la vista de actualizar precios
    public function ActuXls()
    {
        if (session()->has("idUsuario")&& session('rol')=='A') {
            return view('admin/os/actuxls');
          }
          else{
              return redirect()->to(site_url());  
          }
    }


    public function ProcesaXls()
    {
        $resultado= ['Modificados' => 0, 'Errores' => 0, 'Nuevos'=>0, 'Procesados'=>0, "NuevosOs"=>0];
        $v = ['archivo' => [
                'label' => 'File',
                'rules' => [
                    'uploaded[archivo]',
                    'max_size[archivo,1000]',
                ],
            ],
            'nameHoja' => 'required|is_natural_no_zero|greater_than[0]|less_than[20]',
            'nameFecha' => 'required|valid_date[Y-m-d]',
            'nameFilaFinal' => 'required|is_natural_no_zero|greater_than[10]|less_than[65535]',
            'nameFormatoCodigo' =>'required|is_natural'
        ];
       
        if ($this->validate($v)){
          
            $a = $this->request->getFile('archivo');
            if (!$a->hasMoved()) {
                //Cargo el  archivo al disco
                $inputFileName = WRITEPATH . 'uploads/' . $a->store();
                $sheet = ($this->request->getPostGet('nameHoja')) - 1 ;
                $filaFinal = $this->request->getPostGet('nameFilaFinal');
                $colPrecio =  $this->request->getPostGet('nameColArancel');
                $colDesc =  $this->request->getPostGet('nameColDesc');
                $colCodigo =  $this->request->getPostGet('nameColCodigo');
                $colCoseguro =  $this->request->getPostGet('nameColCoseguro');
                $idOs =  $this->request->getPostGet('nameIdSelOs');
                $forcod =  $this->request->getPostGet('nameFormatoCodigo');
                $fechaactu =  $this->request->getPostGet('nameFecha');
                $enviaMsj = $this->request->getPostGet('nameChEnviaMsj');
                $agregaNuevos = $this->request->getPostGet('nameChAgregaNuevos');
                

                //leo el xls con phpspreed 
                /**  Identify the type of file (xls/xlsx/etc)  **/
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                /**  Create a new Reader of the type that has been identified  **/
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                /**  Load $inputFileName to a Spreadsheet Object  **/
                
                $spreadsheet = $reader->load($inputFileName);
           
                $hoja = $spreadsheet->getSheet($sheet);
                
                $CiroLib = new CiroLibreria;
                $MIOs = new OsItemsModel;
                $MMin = new MinimosModel; //items
                
                for ($i=1; $i<= $filaFinal; $i++){
                    $codigo = $hoja->getCell($colCodigo . $i)->getFormattedValue();
                    $codCiro = $CiroLib->convierteACiroFormat($codigo);
                    
                    if ($codCiro != "00.00"){
                        //tengo el codigo, lo busco y si existe lo actualizo. Si no lo agrego
                        
                        $resultado['Procesados'] = $resultado['Procesados'] +  1 ;
                        $d = $MIOs->getItemOsporCod($codCiro, $idOs);
                        //$arancel = $hoja->getCell($colPrecio . $i)->getValue();
                        $arancel = $hoja->getCell($colPrecio . $i)->getValue();
                        $descItem = $hoja->getCell($colDesc . $i)->getValue();
                        $coseguro = $hoja->getCell($colCoseguro . $i)->getValue();
                        if(is_null($arancel)){
                            $arancel = 0;
                        }

                        if(is_null($descItem)){
                            $descItem = "#####Sin descripción####";
                        }

                        if(is_null($coseguro)){
                            $coseguro = 0;
                        }
                        
                        if (isset($d)){
                            //codigo existe para la obra social
                                $ci = $d->id_itemos; 
                                $dp = ['precio'=>$arancel, 'coseguro' => $coseguro, 'fecha_ult_actualizacion'=>$fechaactu];
                                if($MIOs -> update($ci, $dp)) {
                                    $resultado['Modificados'] = $resultado['Modificados'] +  1 ;
                                }
                                else
                                {
                                $resultado['Errores'] = $resultado['Errores'] +  1 ;
                                }
                        }
                        else
                        {
                           //no existe el item en la OS - veo si lo agrego
                            
                           
                            if ($agregaNuevos){
                                //primero busco si el item existe en minimos sino le pongo id_item = 0
                                $m = $MMin->getMinporCod($codCiro);
                                if (isset($m)){
                                    $cimin = $m->id_item;
                                }
                                else
                                {
                                    $cimin = 0;
                                }
                                
                                $datos = ["id_item"=>$cimin, "id_os"=>$idOs, "precio"=>$arancel, "coseguro" => $coseguro, "fecha_ult_actualizacion"=>Date("Y-m-d"), "tasa_iva"=>21, "cant_max_liq"=>3, "desc_item" => $descItem, "codigo"=>$codCiro]; 
                                $MIOs ->insert($datos);
                            }    
                            
                            $resultado['NuevosOs'] = $resultado['NuevosOs'] +  1 ;
                        }        
                        
                    }
                } 
            }
            
            if ($enviaMsj){
                $MOs = new OsModel;
                $r = $MOs->find($idOs);
               $datos = ["mensaje"=>"Actualización de Aranceles " . $r['os'] , "tipo"=>"IMPORTANTE", "fecha"=>Date("Y-m-d h:i:s"), "id_usuario"=>1, "duracion"=>7] ; 
               $Mmsj = new MensajesModel;
               $Mmsj ->insertarMensaje($datos);

            }

            //actualizo OS
            $MOs = new OsModel;
            $dos = ['fecha_ult_actu_precios'=>$fechaactu];
            $MOs -> update($idOs, $dos); 
            
            if (session('rol')=='A'){
              return view('admin/os/resultadoactuxls', $resultado);
            }
        }

     else{
         //Vuelve atras mandando los errores de validacion
         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()) ;
     }     
     
    }

    
    
    public function buscarOsItems($idi){

        if (session()->has("idUsuario")) {
            $MOIs = new OsItemsModel;
            $r = $MOIs->buscarOsenItems($idi); //busca todas la Os que tienen un item
            $datos = ["arregloItems"=>$r]; 

            if (session('rol')== 'P') {
                return view('prof/minimos/ostienemin', $datos);
            }
            else
            {
                return view('admin/minimos/ostienemin', $datos);
            }

          }
          else{
              return redirect()->to(site_url('/'));  
          }
    }


    public function reporteItemsOs($idos){
        
        $MOI = new OsItemsModel;
        $r2 = $MOI->buscarItemsOs($idos);

        $MLiq = new OsModel;
        $r = $MLiq->buscarPorId($idos);


        if (isset($r2)){ 
            if(session()->has("idUsuario")){ 
                $data2 = ["arregloItems" => $r2, "idos" => $r->id_os, "os"=>$r->os];  
    
                return view('prof/os/reporteitemsos', $data2);
    
            }    
        }
    
    }


}