<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
    protected $table = 'UTENTE';
    protected $primaryKey = 'Telefono';

    protected $useAutoIncrement = false;

    protected $returnType = 'array';

    protected $allowedFields = ['Telefono', 'Nome', 'Cognome', 'PSW', 'Email', 'Username', 'Tipologia', 'Logged', 'Token'];

    public function getAllLogged(){
        return $this->where("Logged", true)->countAllResults();
    }

    public function setLogged($phone){
        $this->where("Telefono", $phone)->set(["Logged" => true])->update();
    }

    public function setLogout($phone){
        $this->where("Telefono", $phone)->set(["Logged" => false])->update();
    }
}

?>