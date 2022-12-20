<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <input type="hidden" id="base_url" value="<?= base_url() ?>" />
    <div class="col-12">
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-h-50">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Kemiskinan</span>
                                <h4 class="mb-3">
                                    $<span class="counter-value" data-target="865.2">865.2</span>k
                                </h4>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="badge bg-soft-success text-success">+$20.9k</span>
                            <span class="ms-1 text-muted font-size-13">Since last week</span>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Number of Trades</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="6258">6258</span>
                                </h4>
                            </div>
                            <div class="col-6">

                                <div class="resize-triggers">
                                    <div class="expand-trigger">
                                        <div style="width: 136px; height: 59px;"></div>
                                    </div>
                                    <div class="contract-trigger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="badge bg-soft-danger text-danger">-29 Trades</span>
                            <span class="ms-1 text-muted font-size-13">Since last week</span>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col-->

            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Invested Amount</span>
                                <h4 class="mb-3">
                                    $<span class="counter-value" data-target="4.32">4.32</span>M
                                </h4>
                            </div>
                            <div class="col-6">

                                <div class="resize-triggers">
                                    <div class="expand-trigger">
                                        <div style="width: 136px; height: 59px;"></div>
                                    </div>
                                    <div class="contract-trigger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="badge bg-soft-success text-success">+ $2.8k</span>
                            <span class="ms-1 text-muted font-size-13">Since last week</span>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Profit Ration</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="12.57">12.57</span>%
                                </h4>
                            </div>
                            <div class="col-6">

                                <div class="resize-triggers">
                                    <div class="expand-trigger">
                                        <div style="width: 136px; height: 59px;"></div>
                                    </div>
                                    <div class="contract-trigger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="badge bg-soft-success text-success">+2.95%</span>
                            <span class="ms-1 text-muted font-size-13">Since last week</span>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <center>
                            <h4 class="mb-3">Peta Prevelensi Stunting</h4>
                        </center>
                        <div class="row mb-3">
                            <div class="col-4">
                                <select id="provinsi" class="form-select" aria-label="Default select example">
                                    <option selected>Indonesia</option>
                                    <?php foreach ($allProvinsi as $key => $provinsi) : ?>
                                        <option value="<?= $provinsi->kode_wilayah ?>"><?= $provinsi->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-4">
                                <select id="kabupaten" disabled class="form-select" aria-label="Default select example">
                                    <option selected>Pilih Kabupaten/Kota</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <select disabled class="form-select" aria-label="Default select example">
                                    <option selected>Pilih Desa</option>
                                    <?php foreach ($allProvinsi as $key => $provinsi) : ?>
                                        <option value="<?= $provinsi->kode_wilayah ?>"><?= $provinsi->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-4">

                            </div>
                        </div>
                        <div id="maps"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        const data = <?= json_encode($features) ?>;

        const nilaiMax = <?= $nilaiMax ?>

        function getColor(d) {
            return d > parseFloat((nilaiMax / 4) * 3).toFixed(2) ? '#800026' :
                d > parseFloat((nilaiMax / 4) * 2).toFixed(2) ? '#e67e22' :
                d > parseFloat((nilaiMax / 4) * 1).toFixed(2) ? '#f1c40f' :
                '#2ecc71';
        }

        var map = L.map('maps').setView({
            lat: 0.7893,
            lon: 113.9213
        }, 5);

        function style(feature) {
            return {
                weight: 1,
                opacity: 1,
                color: 'black',
                dashArray: '3',
                fillOpacity: 0.7,
                fillColor: getColor(parseInt(feature.properties.nilai))
            };
        }

        function onEachFeature(feature, layer) {
            layer.bindPopup(
                "<strong>" + feature.properties.Propinsi + "</strong><br>" +
                "Prevelensi Stunting : " + feature.properties.nilai
            );
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
            });
        }

        function onEachFeatureKabupaten(feature, layer) {
            layer.bindPopup(
                "<strong>" + feature.properties.kab_kota + "</strong><br>" +
                "Prevelensi Stunting : " + feature.properties.nilai+"<br>"+
                "<a href='"+base_url + "/detail/" + feature.properties.kode_wilayah+"' >Detail</a>"
            );
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
            });
        }

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
        }).addTo(map);

        var geojson = L.geoJson(data, {
            style: style,
            onEachFeature: onEachFeature
        }).addTo(map);

        function highlightFeature(e) {
            var layer = e.target;

            layer.setStyle({
                weight: 1,
                color: '#ff0000',
                dashArray: '',
                fillOpacity: 0.7
            });

            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                layer.bringToFront();
            }

            info.update(layer.feature.properties);
        }

        function resetHighlight(e) {
            geojson.resetStyle(e.target);
            info.update();
        }

        var info = L.control();

        info.onAdd = function(map) {
            this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
            this.update();
            return this._div;
        };

        // method that we will use to update the control based on feature properties passed
        info.update = function(props) {
            this._div.innerHTML = (props ?
                '<b>' + props.Propinsi + '</b><br />Prevelensi Stunting : ' + props.nilai + '' :
                'Hover di atas wilayah');
        };

        info.addTo(map);

        var legend = L.control({
            position: 'bottomright'
        });

        legend.onAdd = function(map) {

            var div = L.DomUtil.create('div', 'info legend'),
                grades = [0, parseFloat((nilaiMax / 4) * 1), parseFloat((nilaiMax / 4) * 2), parseFloat((nilaiMax / 4) * 3).toFixed(2)],
                labels = [];

            // loop through our density intervals and generate a label with a colored square for each interval
            for (var i = 0; i < grades.length; i++) {
                div.innerHTML +=
                    '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
                    grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
            }

            return div;
        };

        legend.addTo(map);

        let base_url = $('#base_url').val();
        $('#provinsi').on('change', function() {
            if (geojson) {
                geojson.remove();
            }
            $('#kabupaten').removeAttr('disabled');
            const kode_prov = this.value;

            $.ajax({
                url: base_url + "/getdata/1/" + kode_prov,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {                    
                    let dataContent = res.dataContent;
                    const nilaiMax = res.nilaiMax;
                    $.ajax({
                        url: base_url + "/getmap/" + kode_prov,
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(res) {
                            for(let i=0;i<res.features.length;i++)
                            {
                                for(let j=0;j<dataContent.length;j++)
                                {
                                    if(res.features[i].properties.kode_wilayah==dataContent[j].kode_wilayah)
                                    {
                                        res.features[i].properties.nilai = dataContent[j].val;
                                        res.features[i].properties.Propinsi = res.features[i].properties.kab_kota;
                                    }                                
                                }                                
                            }
                            
                            geojson = L.geoJson(res, {
                                style: style,
                                onEachFeature: onEachFeatureKabupaten
                            }).addTo(map);

                            map.fitBounds(geojson.getBounds());
                        }
                    })
                }
            })


            $.ajax({
                url: base_url + "/kabupaten/" + kode_prov,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    $('#kabupaten').empty();
                    $('#kabupaten').append(`<option selected>Pilih Kabupaten/Kota</option>`);
                    for (let i = 0; i < res.length; i++) {
                        $('#kabupaten').append(`<option value="${res[i].kode_wilayah}">${res[i].nama}</option>`);
                    }
                }
            })
        });
    });
</script>
<?= $this->endSection() ?>
<?= $this->section('css') ?>
<style>
    #maps {
        height: 500px;
    }

    .info {
        padding: 6px 8px;
        font: 14px/16px Arial, Helvetica, sans-serif;
        background: white;
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
    }

    .info h4 {
        margin: 0 0 5px;
        color: #777;
    }

    .legend {
        line-height: 18px;
        color: #555;
    }

    .legend i {
        width: 18px;
        height: 18px;
        float: left;
        margin-right: 8px;
        opacity: 0.7;
    }
</style>
<?= $this->endSection() ?>