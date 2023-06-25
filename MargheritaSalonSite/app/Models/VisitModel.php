<?php namespace App\Models;

use CodeIgniter\Model;

class VisitModel extends Model{
    protected $table = 'VISIT';

    protected $primaryKey = 'id';

    protected $allowedFields = ["id","ip_address", "timestamp"];

    public function count_visitors() {
        return $this->countAll();
    }
}

?>