<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php $number = 0; ?>
<div class="row">
    <input type="hidden" id="base_url" value="<?= base_url() ?>" />
    <div class="col-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Individu Potensial Stunting</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Provinsi : </strong><?= $provinsi ?></br>
                    <strong>Kabupaten : </strong><?= $kabupaten ?></br>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-bordered" id="dataTable">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">NIK</th>
                                        <th class="text-center">Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($count as $key => $value) : ?>
                                        <?php
                                        $number++;
                                        $exp = explode("_", $key);
                                        $NIK = $exp[0];
                                        $nama = $exp[1];
                                        ?>
                                        <tr>
                                            <td class="text-center align-middle">
                                                <?= $number ?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <button class="btn btn-link nik" nik="<?= $NIK ?>" nama="<?= $nama ?>"><?= $NIK ?></button>
                                            </td>
                                            <td class="text-center align-middle">
                                                <button class="btn btn-link nik" nik="<?= $NIK ?>" nama="<?= $nama ?>"><?= $nama ?></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modalInfo">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title"></h5>
                        <button type="button " class="btn btn-danger close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="data_diri">
                            <p>NAMA: <span id="data_diri_nama"></span></p>
                            <p>NIK: <span id="data_diri_NIK"></span></p>
                            <p>UMUR: <span id="data_diri_umur"></span></p>
                            <p>JENIS KELAMIN: <span id="data_diri_jk"></span></p>
                            <p>ALAMAT: <span id="data_diri_alamat"></span></p>
                        </div>
                        <div>
                            <table class="table table-striped table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Variabel</th>
                                        <th class="text-center">Isi</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Konsumsi Makanan Bergizi</strong></td>
                                        <td class="text-center"><span id="data_konsumsi_makanan_bergizi"></span></td>
                                        <td class="text-center"><span class="badge bg-danger">! Perlu Perhatian</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sumber Utama Air Minum</strong></td>
                                        <td class="text-center"><span id="data_sumber_air_minum"></span></td>
                                        <td class="text-center">
                                            <span class="badge bg-danger" id="R220_alert">! Perlu Perhatian</span>
                                            <span class="badge bg-success" id="R220_success">Cukup Baik</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Fasilitas Buang Air Besar</strong></td>
                                        <td class="text-center"><span id="data_fasilitas_buang_air"></span></td>
                                        <td class="text-center">
                                            <span class="badge bg-danger" id="R226_alert">! Perlu Perhatian</span>
                                            <span class="badge bg-success" id="R226_success">Cukup Baik</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Konsumsi Daging/Ayam/Susu</strong></td>
                                        <td class="text-center"><span id="data_konsumsi_daging_susu"></span></td>
                                        <td class="text-center">
                                            <span class="badge bg-danger" id="R414_alert">! Perlu Perhatian</span>
                                            <span class="badge bg-success" id="R414_success">Cukup Baik</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Frekuensi Makan</strong></td>
                                        <td class="text-center"><span id="data_frekuensi_makan"></span></td>
                                        <td class="text-center">
                                            <span class="badge bg-danger" id="R416_alert">! Perlu Perhatian</span>
                                            <span class="badge bg-success" id="R416_success">Cukup Baik</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    let base_url = $('#base_url').val();
    $('#dataTable').DataTable({
        stateSave: true,
    });

    $('.close').on('click',  function(){
        $('#modalInfo').modal('hide');
    });

    $('#dataTable').on('click', '.nik', function() {
        const NIK = $(this).attr('NIK');
        const nama = $(this).attr("nama");
        $("#modal_title").html(NIK + " " + nama);
        $.ajax({
            url: base_url + "/individu/" + NIK,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(res) {
                const art = res.art;
                const rumah_tangga = res.rumah_tangga;

                console.log(res);

                let jenis_kelamin = "Laki-Laki";
                if (art.R725 == 2) {
                    jenis_kelamin = "Perempuan"
                }

                const jawab_bergizi = ['Makan teratur tetapi kurang gizi (Telur, daging, ayam, ikan, sayur).', 'Makan teratur, cukup gizi.', 'Makan tidak teratur, kurang gizi']
                let R760a = jawab_bergizi[art.R760a - 1];
                if (!R760a) {
                    R760a = 'Tidak Ada Data';
                }

                const sumber_air_minum = [
                    'Air kemasan bermerk',
                    'Air isi ulang',
                    'Leding',
                    'Sumur bor/pompa',
                    'Sumur terlindung',
                    'Sumur tak terlindung',
                    'Mata air terlindung',
                    'Mata air tak terlindung',
                    'Air permukaan (sungai/danau/waduk/kolam/irigas)',
                    'Air Hujan',
                    'Lainnya'
                ];

                let R220 = sumber_air_minum[rumah_tangga.R220 - 1];
                let R220_alert = false;
                if (rumah_tangga.R220 == 6 || rumah_tangga.R220 == 8 || rumah_tangga.R220 == 9 || rumah_tangga.R220 == 10 || rumah_tangga.R220 == 11) {
                    R220_alert = true;
                }

                const fasilitas_buang_air_besar = [
                    'Ada, digunakan hanya ART sendiri',
                    'Ada, digunakan bersama ART rumah tangga tertentu',
                    'Ada, di MCK komunal',
                    'Ada, di MCK umum/siapapun menggunakan',
                    'Ada, ART tidak menggunakan', 'Tidak ada',
                ];
                let R226_alert = false;
                if (rumah_tangga.R226 == 5 || rumah_tangga.R226 == 6) {
                    R226_alert = true;
                }

                let R226 = fasilitas_buang_air_besar[rumah_tangga.R226 - 1];

                const konsumsi_daging_susu = [
                    '1 kali seminggu',
                    '2-3 kali seminggu',
                    '> 3 kali seminggu',
                    'Tidak pernah',
                ];
                let R414_alert = false;
                if (rumah_tangga.R414 == 1 || rumah_tangga.R414 == 4) {
                    R414_alert = true;
                }

                let R414 = konsumsi_daging_susu[rumah_tangga.R414 - 1];

                const frekuensi_makan = [
                    '1 kali sehari',
                    '2 kali sehari',
                    '3 kali sehari',
                    '> 3 kali sehari',
                ];

                let R416 = frekuensi_makan[rumah_tangga.R416 - 1];
                let R416_alert = false;
                if (rumah_tangga.R416 == 1 || rumah_tangga.R416 == 2) {
                    R416_alert = true;
                }

                $('#data_diri_nama').html(nama);
                $('#data_diri_NIK').html(NIK);
                $('#data_diri_umur').html(art.R729);
                $('#data_diri_jk').html(jenis_kelamin);
                $('#data_diri_alamat').html(rumah_tangga.R033);
                $('#data_konsumsi_makanan_bergizi').html(R760a);
                $('#data_sumber_air_minum').html(R220);
                $('#data_fasilitas_buang_air').html(R226);
                $('#data_konsumsi_daging_susu').html(R414);
                $('#data_frekuensi_makan').html(R416);

                if (R416_alert == false) {
                    $('#R416_alert').hide();
                    $('#R416_success').show();
                } else {
                    $('#R416_alert').show();
                    $('#R416_success').hide();
                }

                if (R226_alert == false) {
                    $('#R226_alert').hide();
                    $('#R226_success').show();
                } else {
                    $('#R226_alert').show();
                    $('#R226_success').hide();
                }
                if (R414_alert == false) {
                    $('#R414_alert').hide();
                    $('#R414_success').show();
                } else {
                    $('#R414_alert').show();
                    $('#R414_success').hide();
                }

                if (R220_alert == false) {
                    $('#R220_alert').hide();
                    $('#R220_success').show();
                } else {
                    $('#R220_alert').show();
                    $('#R220_success').hide();
                }
            }
        });
        $('#modalInfo').modal('show');
    })
</script>
<?= $this->endSection() ?>