<?php

namespace App\Models;

use CodeIgniter\Model;

class RumahTangga extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'rumah_tangga';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = '\App\Entities\RumahTangga';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'R011', //ID Rumah Tangga
        'R700', //IDART
        'R021', //KODE PROVINSI
        'R022', //KODE KABUPATEN
        'R023', //KODE KECAMATAN
        'R024', //KODE DESA
        'R220', //sumber air minum
        'R226', //fasilitas buang air besar
        'R144', //konsumsi daging ayam susu
        'R415', //frekuensi makan
        'R729', //umur
        'R725', //jenis kelamin
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

    public function getAirMinumLayak($kode_kabupaten)
    {
        $kode_kabupaten = substr($kode_kabupaten, 0, -3);

        $db = \Config\Database::connect();
        $builder = $db->table('rumah_tangga');
        $builder->select('art.R712 as nama, art.R729 AS umur, art.R711 as NIK ,rumah_tangga.R011, rumah_tangga.R700, rumah_tangga.R021, rumah_tangga.R022, rumah_tangga.R023, rumah_tangga.R024, rumah_tangga.R220 AS air_minum_layak');
        $builder->join('art', 'art.R011=rumah_tangga.R011','right');
        $builder->where('rumah_tangga.R022',$kode_kabupaten);
        $kode = [6,7,9,10];
        $builder->whereIn('rumah_tangga.R220',$kode);
        $builder->where('((R729 < 5) OR (R729>15 AND R729<45 AND R725=2) )');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getKepemilikanFasilitasAirBesar($kode_kabupaten)
    {
        $kode_kabupaten = substr($kode_kabupaten, 0, -3);

        $db = \Config\Database::connect();
        $builder = $db->table('rumah_tangga');
        $builder->select('art.R712 as nama, art.R729 AS umur,art.R711 as NIK,rumah_tangga.R011, rumah_tangga.R700, rumah_tangga.R021, rumah_tangga.R022, rumah_tangga.R023, rumah_tangga.R024, rumah_tangga.R226 AS fasilitas_buang_air_besar');
        $builder->join('art', 'art.R011=rumah_tangga.R011','right');
        $builder->where('rumah_tangga.R022',$kode_kabupaten);
        $kode = [5,6];
        $builder->whereIn('rumah_tangga.R226',$kode);
        $builder->where('((R729 < 5) OR (R729>15 AND R729<45 AND R725=2) )');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getKonsumsiDagingSusu($kode_kabupaten)
    {
        $kode_kabupaten = substr($kode_kabupaten, 0, -3);

        $db = \Config\Database::connect();
        $builder = $db->table('rumah_tangga');
        $builder->select('art.R712 as nama, art.R729 AS umur,art.R711 as NIK, rumah_tangga.R011, rumah_tangga.R700, rumah_tangga.R021, rumah_tangga.R022, rumah_tangga.R023, rumah_tangga.R024, rumah_tangga.R414 AS konsumsi_daging_susu');
        $builder->join('art', 'art.R011=rumah_tangga.R011','right');
        $builder->where('rumah_tangga.R022',$kode_kabupaten);
        $kode = [1,4];
        $builder->whereIn('rumah_tangga.R414',$kode);
        $builder->where('((R729 < 5) OR (R729>15 AND R729<45 AND R725=2) )');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getFrekuensiMakan($kode_kabupaten)
    {
        $kode_kabupaten = substr($kode_kabupaten, 0, -3);

        $db = \Config\Database::connect();
        $builder = $db->table('rumah_tangga');
        $builder->select('art.R712 as nama, art.R729 AS umur,art.R711 as NIK, rumah_tangga.R011, rumah_tangga.R700, rumah_tangga.R021, rumah_tangga.R022, rumah_tangga.R023, rumah_tangga.R024, rumah_tangga.R415 AS frekuensi_makan');
        $builder->join('art', 'art.R011=rumah_tangga.R011','right');
        $builder->where('rumah_tangga.R022',$kode_kabupaten);
        $kode = [1,2];
        $builder->whereIn('rumah_tangga.R415',$kode);
        $builder->where('((R729 < 5) OR (R729>15 AND R729<45 AND R725=2) )');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getRumahTanggaByIndividu($NIK)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('rumah_tangga');
        $builder->select('rumah_tangga.*');
        $builder->join('art','art.R011=rumah_tangga.R011','left');
        $builder->where('art.R711', $NIK);
        $query = $builder->get();
        return $query->getResult();
    }
}
