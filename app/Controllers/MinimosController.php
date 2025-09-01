<?php 
namespace App\Controllers;



use CodeIgniter\Controller;
use CodeIgniter\Files\File;

use App\Models\MinimosModel;
use App\Models\MensajesModel;

//Libreria Ciro
use App\Libraries\CiroLibreria;


//PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//reportes
//require '/vendor/autoload.php'; si está todo con composer no hace falta

use Dompdf\Dompdf;



class MinimosController extends Controller{

    

    public function Index()
    {
        if (session()->has("idUsuario") && session('rol')=='A') {
            return view('admin/minimos/index');
          }
          else{
              return redirect()->to(site_url());  
          }
    }


    public function IndexP()
    {
        if (session()->has("idUsuario") && session('rol')=='P') {
            return view('prof/minimos/index');
          }
          else{
              return redirect()->to(site_url());  
          }
    }


//Modificar
public function modifMin($id)
{
    if (session()->has("idUsuario") && session('rol')=='A') {
        $MMin = new MinimosModel;
        $r = $MMin->find($id);
        $datos = ["arregloItems"=>$r]; 
       
        return view('admin/minimos/modificar', $datos);    
         
      }
      else{
        return redirect()->to(site_url());  
      }
}


 //borrar OS
 public function borrarMin($id)
 {
     if (session()->has("idUsuario")  && session('rol')=='A') {
        $MMin = new MinimosModel;
        $r = $MMin->find($id);
        $datos = ["arregloItems"=>$r]; 
        return view('admin/minimos/borrar', $datos);  
       }
       else{
         return redirect()->to(site_url());  
       }
 }



 public function guardarMin($f)
 {
    if (session()->has("idUsuario")  && session('rol')=='A') {
      
    //recibo los valores
         $item = $_POST['nameItem'];
         $id = $_POST['nameIdItem'];
         $arancel = $_POST['nameArancel'];
         
         $MMin = new MinimosModel;
         $data=['item'=>$item, 'arancel'=>$arancel, 'fecha_actu'=>date('Y-m_d')];
         
         $v = ["nameItem" => "required|min_length[2]|max_length[100]",
                "nameArancel" =>"required|greater_than[0]"] ;

         if ($this->validate($v)){
             if ($f == 'U'){
                 $MMin->update($id, $data);
             }else{
                 if ($f=='D'){
                     $MMin->delete($id);
                 }else
                 {
                 $MMin->insert($data);
                 }
             }
             return redirect()->to(site_url('/Minimos'))->with('message','Operación Correcta');
         }
         else{
             //Vuelve atras mandando los errores de validacion
             return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()) ;
         }
        }
        else{
            return redirect()->to(site_url());  
          }       
 }




    //Consultas los minimos
    public function getMin()
    {
        if (session()->has("idUsuario")) {
            //recibo los valores
            $q = "select * from items " . $_POST['q'] ;
           
            $MMin = new MinimosModel;
            $r = $MMin->getMin($q);
            if (count($r)>0){
                echo json_encode($r);
            }
          }
          else{
              return redirect()->to(site_url());  
          }
    }

         //Consultas todas las items
     Public function getMinPorCod($c)
        {
     
         if (session()->has("idUsuario")) {
            $MMin = new MinimosModel;
            
            $r = $MMin->getMinPorCod($c);
            
            return $r;
        }
        else{
               return redirect()->to(site_url());  
        }
 }

    //llama a la vista de actualizar precios
    public function ActuXls()
    {
        if (session()->has("idUsuario") && session('rol')=='A') {
            return view('admin/minimos/actuxls');
          }
          else{
              return redirect()->to(site_url());  
          }
    }

    public function ProcesaXls()
    {
        $resultado= ['Modificados' => 0, 'Errores' => 0, 'Nuevos'=>0, 'Procesados'=>0];
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
            'nameIdOs' =>'required|is_natural',
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
                $idOs =  $this->request->getPostGet('nameIdOs');
                $forcod =  $this->request->getPostGet('nameFormatoCodigo');
                $fechaactu =  $this->request->getPostGet('nameFecha');
                $enviaMsj = $this->request->getPostGet('nameChEnviaMsj');
                

                //leo el xls con phpspreed 
                /**  Identify the type of file (xls/xlsx/etc)  **/
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                /**  Create a new Reader of the type that has been identified  **/
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                /**  Load $inputFileName to a Spreadsheet Object  **/
                $spreadsheet = $reader->load($inputFileName);
           
                $hoja = $spreadsheet->getSheet($sheet);
                
                $MMin = new MinimosModel;
                $CiroLib = new CiroLibreria;
                for ($i=1; $i<= $filaFinal; $i++){
                    $codigo = $hoja->getCell($colCodigo . $i)->getFormattedValue();
                    $codCiro = $CiroLib->convierteACiroFormat($codigo);
                    
                    if ($codCiro != "00.00"){
                        //tengo el codigo, lo busco y si existe lo actualizo. Si no lo agrego
                        $resultado['Procesados'] = $resultado['Procesados'] +  1 ;
                        $d = $this->getMinPorCod($codCiro);
                        $arancel = $hoja->getCell($colPrecio . $i)->getValue(); 
                        $descitem = $hoja->getCell($colDesc . $i)->getValue(); 
                      
                        if (isset($d)){
                            //existe y actualizo
                            $ci = $d->id_item; 
                            $dp = ['arancel'=>$arancel, 'fecha_actu'=>$fechaactu];
                            
                            if($MMin -> update($ci, $dp)) {
                                $resultado['Modificados'] = $resultado['Modificados'] +  1 ;
                            }
                            else
                            {
                                $resultado['Errores'] = $resultado['Errores'] +  1 ;
                            }    
                        }
                        else{
                            //no existe agrego
                            $dp=["codigo"=>$codCiro, "item" => $descitem, "id_tipo_item"=>intval(substr($codCiro,0,2)), "c1"=>0, "c2"=> 0, "c3"=>0];
                            if($MMin -> insert($dp)) {
                                $resultado['Nuevos'] = $resultado['Nuevos'] +  1 ;
                            }
                            else
                            {
                                $resultado['Errores'] = $resultado['Errores'] +  1 ;
                            }    
                            
                            
                            
                            
                        }

                    }
            
                } 
            }
            
           
            if ($enviaMsj){
               $datos = ["mensaje"=>"Actualización de Aranceles Mínimos ", "tipo"=>"IMPORTANTE", "fecha"=>Date("Y-m-d h:i:s"), "id_usuario"=>1, "duracion"=>7] ; 
               $Mmsj = new MensajesModel;
               $Mmsj ->insertarMensaje($datos);

            }
            
            return view('admin/minimos/resultadoactuxls', $resultado);
        }

     else{
         //Vuelve atras mandando los errores de validacion
         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()) ;
     }     
     
    }



    public function reporteMin(){
        $html = ob_get_clean();
        $dompdf = new Dompdf();
        $dompdf->set_option("isPhpEnabled", true); //para habilitar el script de nro de pagina
    
        $MMin = new MinimosModel;
        $r2 = $MMin->findAll();
        if (isset($r2)){ 
            if(session()->has("idUsuario")){ 
                $data = ["arregloItems" => $r2];  
    
                $html = view('prof/minimos/reportemin', $data);
    
                $dompdf->loadHtml($html);
                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper('A4', 'portrait');
                
                // Render the HTML as PDF
                $dompdf->render();
                
                // Output the generated PDF to Browser
                $dompdf -> stream("vista.pdf", array("Attachment" => 0)); //0por pantalla 1 descarga
                //$dompdf->stream("vista.pdf");
            }    
        }
    
    }
    

    public function reporteMin2(){
       
        $MMin = new MinimosModel;
        $r2 = $MMin->findAll();
        if (isset($r2)){ 
            if(session()->has("idUsuario")){ 
                $data = ["arregloItems" => $r2];  
                return view('prof/minimos/reportemin', $data);
    
          }    
        }
        
    }
    

    
}//fin clase MinimosController