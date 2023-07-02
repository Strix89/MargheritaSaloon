<?php namespace App\Models;

use CodeIgniter\Model;
    
class ReviewsModel extends Model{
    public function getReviews() {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT
                                r."Telefono", r."Data_P", r."Ora_P", r."Data", r."Ora", r."Testo", r."Rating",
                                p."Telefono_C", p."Data_P", p."Ora_P", p."Telefono_P",
                                uc."Username" AS "C_Username", up."Username" AS "P_Username", 
                                array_agg(t."Titolo") AS "Titoli_Trattamenti"
                                FROM public."RECENSIONE" r
                                LEFT JOIN public."PRENOTAZIONE" p ON r."Telefono" = p."Telefono_C" AND r."Data_P" = p."Data_P" AND r."Ora_P" = p."Ora_P"
                                LEFT JOIN public."UTENTE" uc ON p."Telefono_C" = uc."Telefono"
                                LEFT JOIN public."UTENTE" up ON p."Telefono_P" = up."Telefono"
                                LEFT JOIN public."PRENOTAZIONE_TRATTAMENTO" pt ON p."Telefono_C" = pt."Telefono_C" AND p."Data_P" = pt."Data_P" AND p."Ora_P" = pt."Ora_P"
                                LEFT JOIN public."TRATTAMENTO" t ON pt."ID_T" = t."ID"
                                GROUP BY r."Telefono", r."Data_P", r."Ora_P", r."Data", r."Ora", r."Testo", r."Rating",
                                p."Telefono_C", p."Data_P", p."Ora_P", p."Telefono_P",
                                uc."Username", up."Username"
                            ');
        $result = $query->getResultArray();
        return $result;
    }

    public function insertReview($telefono, $data_p, $ora_p, $data, $ora, $rating, $testo) {
        $data = [
            'Telefono' => $telefono,
            'Data_P' => $data_p,
            'Ora_P' => $ora_p,
            'Data' => $data,
            'Ora' => $ora,
            'Rating' => $rating,
            'Testo' => $testo
        ];
        $builder = $this->db->table('RECENSIONE');
        $success = $builder->insert($data);
        return $success;
    }
}

?>