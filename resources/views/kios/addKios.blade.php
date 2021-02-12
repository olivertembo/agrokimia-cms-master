@extends('layouts._layout')

@section('content')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvTkPKa1jErT_Kh9ZPTIP2az48f8y0WGo&libraries=places"></script>
<script>
    function initialize() {
      var input = document.getElementById('searchTextField');
      var autocomplete = new google.maps.places.Autocomplete(input);
      google.maps.event.addListener(autocomplete, 'place_changed',
        function() {
            var place = autocomplete.getPlace();
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            document.getElementById('latitude').value=lat;
            document.getElementById('longitude').value=lng;

        }
    );
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tambah Kios</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('list-kios') }}">Kios</a></li>
                    <li class="breadcrumb-item active">Tambah Kios</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{route('insertKios')}}" method="post" enctype="multipart/form-data">@csrf
                        <div class="form-body">
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="cabangkios">
                                        <label class="form-check-label" for="exampleCheck1">Cabang Kios</label>
                                      </div>
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label">Nama Kios</label>
                                        <input type="text" name="nama_kios" id="nama_kios" class="form-control" value="{{ old('nama_kios') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Alamat Kios</label>
                                        <input type="text" name="alamat_kios" id="alamat_kios" class="form-control" value="{{ old('alamat_kios') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Pilih Kota</label><br>
                                        <select name="id_kota" id="id_kota" class="form-control select2 col-md-11" required>
                                            <option value="">Pilih Kota</option>
                                            @foreach ($cities as $item)
                                                <option value="{{$item->city_code}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Pilih Area</label><br>
                                        <select class="form-control select2 col-md-11" name="area_code" id="area" required>
                                            <option value=''>Pilih Area</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Category Kios</label>
                                        <select name="category_kios" id="category_kios" class="form-control" required>
                                            <option value="">Pilih Category Kios</option>
                                            @foreach ($category_kios as $item)
                                                <option value="{{$item->id}}">{{$item->nama_tipe}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" id="labelkiosutama" >Kios Utama</label>
                                        <select name="kios_utama" id="kios_utama" class="form-control">
                                            <option value="">Pilih Kios Utama</option>
                                            @foreach ($kios_utama as $item)
                                                <option value="{{$item->id}}">{{$item->nama_Kios}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Tipe Kios</label>
                                        <select name="tipe_kios" id="tipe_kios" class="form-control">
                                            <option value="">Pilih Tipe Kios</option>
                                            @foreach ($tipe_kios as $item)
                                                <option value="{{$item->id}}">{{$item->nama_tipe_kios}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                   <div class="form-group">
                                        <label class="control-label">MAPS</label>
                                        <input id="searchTextField" type="text" class="form-control" placeholder="Masukkan Lokasi" autocomplete="on" runat="server" name="alamat"/>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label">Latitude</label>
                                        <input type="text" readonly name="latitude" id="latitude" class="form-control" value="{{ old('latitude') }}" placeholder="" required>
                                    </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Longitude</label>
                                        <input type="text" readonly name="longitude" id="longitude" class="form-control" value="{{ old('longitude') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="" required>
                                    </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nama PIC</label>
                                        <input type="text" name="nama_pic" id="nama_pic" class="form-control" value="{{ old('nama_pic') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label">Nomor HP PIC</label>
                                        <input type="text" name="nomor_hp_pic" id="nomor_hp_pic" class="form-control" value="{{ old('nomor_hp_pic') }}" placeholder="" required>
                                    </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nomor KTP PIC</label>
                                        <input type="text" name="nomor_ktp_pic" id="nomor_ktp_pic" class="form-control" value="{{ old('nomor_ktp_pic') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label">Nomor NPWP PIC</label>
                                        <input type="text" name="nomor_npwp_pic" id="nomor_npwp_pic" class="form-control" value="{{ old('nomor_npwp_pic') }}" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" value="" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Retype Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="" placeholder="" required>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label">Image NPWP</label>
                                        <input type="file" name="image_npwp" id="image_npwp" class="form-control" value="" placeholder="" >
                                        <p style="color:red; float:right; font-size:10px;">Max Upload 2Mb</p>
                                    </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Image KTP</label>
                                        <input type="file" name="image_ktp" id="image_ktp" class="form-control" value="" placeholder="" >
                                        <p style="color:red; float:right; font-size:10px;">Max Upload 2Mb</p>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label">Image Kios Depan</label>
                                        <input type="file" name="image_kios_depan" id="image_kios_depan" class="form-control" value="" placeholder="" >
                                        <p style="color:red; float:right; font-size:10px;">Max Upload 2Mb</p>
                                    </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Image Kios Dalam</label>
                                        <input type="file" name="image_kios_dalam" id="image_kios_dalam" class="form-control" value="" placeholder="" >
                                        <p style="color:red; float:right; font-size:10px;">Max Upload 2Mb</p>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label">Image Selfie KTP</label>
                                        <input type="file" name="image_selfi_ktp" id="image_kios_depan" class="form-control" value="" placeholder="" >
                                        <p style="color:red; float:right; font-size:10px;">Max Upload 2Mb</p>
                                    </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                            <option value="2">Expired</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{ route('list-kios')}}"><button type="button" class="btn btn-inverse">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{URL::asset('assets')}}/node_modules/select2/dist/js/select2.js"></script>

    <script>
        $(document).ready(function() {
            $("#labelkiosutama").hide();
            $("#kios_utama").hide();
        $("#cabangkios").change(function(){
            if($(this).is(':checked')){
                $("#labelkiosutama").show(); // checked
                $("#kios_utama").show(); // checked
            }
            else{
                $("#labelkiosutama").hide();
                $("#kios_utama").hide();
            }
         });
        });

        function myMap() {
        var mapProp= {
        center:new google.maps.LatLng(51.508742,-0.120850),
        zoom:5,
        };
        var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
        }

        $(document).ready(function() {
            $("#id_kota").change(function() {
                console.log("jaya tampan");
                var provid = $("#id_kota").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if(provid){

                $.ajax({
                    type: 'GET',
                    url: '/area/' + provid,
                    dataType: 'json',
                    success: function(data) {
                        $("#area").empty();
                        $("#area").append("<option value=''>Pilih Area</option>");
                        for (let i = 0; i < data.length; i++) {

                            $("#area").append("<option value=" + data[i].area_code + ">" + data[i].name + "</option>");
                        }
                        console.log(data);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $('.select2').select2();
        })
    </script>
@endsection
