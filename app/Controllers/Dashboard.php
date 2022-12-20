<?php namespace App\Controllers;

class Dashboard extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->validation = \Config\Services::validation();
    }

	public function index()
	{
		$param = [
            'title_meta' => view('partials/title-meta', ['title' => 'Dashboard']),
            'page_title' => view('partials/page-title', ['title' => '', 'li_1' => 'Dashboard'])
        ];

        $fileName = base_url("maps/prov.geojson");
        $file = file_get_contents($fileName);
        $file = json_decode($file);

        $modelContentData = new \App\Models\ContentData();  
        $modelMasterWilayah = new \App\Models\MasterWilayah();

        $allProvinsi = $modelMasterWilayah->where('tingkat',1)->findAll();

        $dataStunting = $modelContentData->getDataByMaster(1,1);

        $features = $file->features;
        
        foreach($features as $index=>$feature)
        {
            $kode_wilayah = $feature->properties->kode;
            foreach($dataStunting as $index_s=>$stunting)
            {
                if($stunting->kode_wilayah==$kode_wilayah.'00')
                {
                    $features[$index]->properties->nilai = $stunting->val;
                }
            }
        }

        $nilaiMax = $modelContentData->findMaxByMaster(1,1);
        
        $param['nilaiMax'] = $nilaiMax;
        $param['features'] = $features;
        $param['allProvinsi'] = $allProvinsi;

        return view('dashboard/index', $param);
	}

    public function kabupaten()
    {
        $kode_wilayah = $this->request->uri->getSegment(2);

        $modelMaster = new \App\Models\MasterWilayah();
        $allKabupaten = $modelMaster->where('id_parent', $kode_wilayah)->findAll();
        return $this->response->setJSON($allKabupaten);
    }

    public function getmap()
    {
        $kode_wilayah = $this->request->uri->getSegment(2);

        $fileName = base_url("maps/".$kode_wilayah.".geojson");
        $file = file_get_contents($fileName);
        $file = json_decode($file);

        return $this->response->setJSON($file);
    }

    public function getdata()
    {
        $kode_data = $this->request->uri->getSegment(2);
        $kode_wilayah = $this->request->uri->getSegment(3);

        $modelContent = new \App\Models\ContentData();
        $dataContent = $modelContent->getDataByMasterAndWilayah($kode_data, $kode_wilayah);
        $nilaiMax = $modelContent->findMaxByMasterAndWilayah(1, $kode_wilayah);

        $return_data = [
            'dataContent'=>$dataContent,
            'nilaiMax' => $nilaiMax,
        ];

        return $this->response->setJSON($return_data);
    }

	//--------------------------------------------------------------------

}