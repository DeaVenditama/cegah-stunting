<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentData extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'content_data';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'App\Entities\ContentData';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_master_data',
        'val',
        'kode_wilayah'
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

    public function getDataByMaster($id_master, $tingkat)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('content_data');
        $builder->select('master_data.nama, content_data.val, content_data.kode_wilayah');
        $builder->join('master_data', 'content_data.id_master_data=master_data.id', 'left');
        $builder->join('master_wilayah', 'master_wilayah.kode_wilayah=content_data.kode_wilayah', 'left');
        $builder->where('master_data.id', $id_master);
        $builder->where('master_wilayah.tingkat',$tingkat);
        $query = $builder->get();
        return $query->getResult();
    }

    public function findMaxByMaster($id_master, $tingkat)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('content_data');
        $builder->select('MAX(content_data.val) AS nilai_max');
        $builder->join('master_data', 'content_data.id_master_data=master_data.id', 'left');
        $builder->join('master_wilayah', 'master_wilayah.kode_wilayah=content_data.kode_wilayah', 'left');
        $builder->where('master_data.id', $id_master);
        $builder->where('master_wilayah.tingkat',$tingkat);
        $query = $builder->get();
        return $query->getResult()[0]->nilai_max;
    }

    public function getDataByMasterAndWilayah($id_master, $id_wilayah)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('content_data');
        $builder->select('master_data.nama, content_data.val, content_data.kode_wilayah');
        $builder->join('master_data', 'content_data.id_master_data=master_data.id', 'left');
        $builder->join('master_wilayah', 'master_wilayah.kode_wilayah=content_data.kode_wilayah', 'left');
        $builder->where('master_data.id', $id_master);
        $builder->where('master_wilayah.id_parent',$id_wilayah);
        $query = $builder->get();
        return $query->getResult();
    }

    public function findMaxByMasterAndWilayah($id_master, $id_wilayah)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('content_data');
        $builder->select('MAX(content_data.val) AS nilai_max');
        $builder->join('master_data', 'content_data.id_master_data=master_data.id', 'left');
        $builder->join('master_wilayah', 'master_wilayah.kode_wilayah=content_data.kode_wilayah', 'left');
        $builder->where('master_data.id', $id_master);
        $builder->where('master_wilayah.id_parent',$id_wilayah);
        $query = $builder->get();
        return $query->getResult()[0]->nilai_max;
    }
}
