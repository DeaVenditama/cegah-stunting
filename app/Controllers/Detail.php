<?php namespace App\Controllers;

class Detail extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $param = [
            'title_meta' => view('partials/title-meta', ['title' => 'Detail']),
            'page_title' => view('partials/page-title', ['title' => '', 'li_1' => 'Detail'])
        ];

        $kode_wilayah = $this->request->uri->getSegment(2);

        $modelArt = new \App\Models\Art();
        $modelRumahTangga = new \App\Models\RumahTangga();
        $modelMasterWilayah = new \App\Models\MasterWilayah();

        $makananBergizi = $modelArt->getMakananBergizi($kode_wilayah);
        $airMinumLayak = $modelRumahTangga->getAirMinumLayak($kode_wilayah);
        $fasilitasBuangAirBesar = $modelRumahTangga->getKepemilikanFasilitasAirBesar($kode_wilayah);
        $konsumsiDagingSusu = $modelRumahTangga->getKonsumsiDagingSusu($kode_wilayah);
        $frekuensiMakan = $modelRumahTangga->getFrekuensiMakan($kode_wilayah);

        $count = [];

        $kabupaten = $modelMasterWilayah->where('kode_wilayah', $kode_wilayah)->findAll()[0];
        $provinsi = $modelMasterWilayah->where('kode_wilayah', $kabupaten->id_parent)->findAll()[0];
        $param['kabupaten'] = $kabupaten->nama.'['.$kabupaten->kode_wilayah.']';
        $param['provinsi'] = $provinsi->nama.'['.$provinsi->kode_wilayah.']';

        foreach($makananBergizi as $key=>$value)
        {
            if(array_key_exists($value->NIK."_".$value->nama, $count))
            {
                $count[$value->NIK."_".$value->nama] = $count[$value->NIK."_".$value->nama]+1;
            }else{
                $count[$value->NIK."_".$value->nama] = 1;
            }            
        }

        foreach($airMinumLayak as $key=>$value)
        {
            if(array_key_exists($value->NIK."_".$value->nama, $count))
            {
                $count[$value->NIK."_".$value->nama] = $count[$value->NIK."_".$value->nama]+1;
            }else{
                $count[$value->NIK."_".$value->nama] = 1;
            }            
        }

        foreach($fasilitasBuangAirBesar as $key=>$value)
        {
            if(array_key_exists($value->NIK."_".$value->nama, $count))
            {
                $count[$value->NIK."_".$value->nama] = $count[$value->NIK."_".$value->nama]+1;
            }else{
                $count[$value->NIK."_".$value->nama] = 1;
            }
        }

        foreach($konsumsiDagingSusu as $key=>$value)
        {
            if(array_key_exists($value->NIK."_".$value->nama, $count))
            {
                $count[$value->NIK."_".$value->nama] = $count[$value->NIK."_".$value->nama]+1;
            }else{
                $count[$value->NIK."_".$value->nama] = 1;
            }
        }

        foreach($frekuensiMakan as $key=>$value)
        {
            if(array_key_exists($value->NIK."_".$value->nama, $count))
            {
                $count[$value->NIK."_".$value->nama] = $count[$value->NIK."_".$value->nama]+1;
            }else{
                $count[$value->NIK."_".$value->nama] = 1;
            }
        }
        arsort($count);

        $param['count'] = $count;

        return view('detail/index', $param);
    }

    public function individu()
    {
        $NIK = $this->request->uri->getSegment(2);

        $modelArt = new \App\Models\Art();
        $modelRt = new \App\Models\RumahTangga();

        $art = $modelArt->where('R711',$NIK)->findAll()[0];
        $rt = $modelRt->getRumahTanggaByIndividu($NIK)[0];

        $return_data = [
            'rumah_tangga'=>$rt,
            'art'=>$art,
        ];

        return $this->response->setJSON($return_data);
    }
}