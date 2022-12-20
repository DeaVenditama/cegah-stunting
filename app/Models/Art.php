<?php

namespace App\Models;

use CodeIgniter\Model;

class Art extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'art';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'App\Entities\Art';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'R011',
        'R700',
        'R701',
        'R711',
        'R712',
        'R760a'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getMakananBergizi($kode_kabupaten)
    {
        $kode_kabupaten = substr($kode_kabupaten, 0, -3);

        $db = \Config\Database::connect();
        $builder = $db->table('art');
        $builder->select('art.R712 as nama, art.R729 AS umur, art.R711 as NIK, art.R011, art.R700, art.R701, art.R711, art.R712, art.R760a AS makanan_bergizi');
        $builder->join('rumah_tangga','art.R011=rumah_tangga.R011','left');
        $builder->where('rumah_tangga.R022',$kode_kabupaten);
        $builder->where('R760a!=',2);
        $builder->where('((R729 < 5) OR (R729>15 AND R729<45 AND R725=2) )');
        $query = $builder->get();
        return $query->getResult();
    }
}
