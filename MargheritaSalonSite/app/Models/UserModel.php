<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
    protected $table = 'UTENTE';
    protected $primaryKey = 'Telefono';

    protected $allowedFields = ['Telefono', 'Nome', 'Cognome', 'PSW', 'Email', 'Username', 'Tipo'];
}

?>