<?php 
namespace App\Models;

use CodeIgniter\Model;

class LogsModel extends Model{
    protected $table      = 'logs';
    protected $primaryKey = 'id_log';
    protected $allowedFields = ['fecha', 'id_tipolog', 'id_usuario', 'tabla', 'id_registro'];








}
