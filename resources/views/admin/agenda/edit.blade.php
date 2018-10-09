@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')

<script>
function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#thumbnail-preview + img').remove();
            $('#thumbnail-preview').after('<img alt="Image" src="'+e.target.result+'" width="350" />');
            $('#modal_thumbnail + img').remove();
            $('#modal_thumbnail').after('<img alt="Image" src="'+e.target.result+'" width="350" />');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#file").change(function () {
    filePreview(this);
});


$('#submit').click( function() {
	var nama = $('#nama').val();
	var kontak = $('#kontak').val();
	var lokasi = $('#lokasi').val();
	var website = $('#website').val();
	var penyelenggara = $('#penyelenggara').val();
	var mulai = $('#date_start').val()+" "+$('#time_start').val();;
	var selesai = $('#date_end').val()+" "+$('#time_end').val();;
	var deskripsi = tinymce.get('deskripsi').getContent();
	var rilis = $('#date').val()+" "+$('#time').val();
	$('#modal_waktu').html( rilis );
	$('#modal_nama').html( nama );
	$('#modal_deskripsi').html( deskripsi );
	$('#modal_kontak').html( kontak );
	$('#modal_website').html( website );
	$('#modal_lokasi').html( lokasi );
	$('#modal_penyelenggara').html( penyelenggara );
	$('#modal_mulai').html( mulai );
	$('#modal_selesai').html( selesai );
	filePreview(this);
});

</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	$('#date_start').datepicker();
	$('#date_end').datepicker();
</script>

@endsection

@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
<div class="section-block center-holder">
    <div class="container">
    	<h1>Buat Agenda Baru</h1>
		<hr>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form action="{{route('admin.agenda.update',[$data->slug])}}" method="POST" enctype="multipart/form-data">
					@csrf
				  	<div class="form-group">
					    <label for="Judul">Nama Agenda</label>
					    <input type="text" class="form-control" id="nama" value="{{$data->nama_agenda}}" name="nama_agenda" required>
					    @if(count($errors)>0)
					    	@foreach($errors->all() as $error)
					    		<small class="alert-danger">*Nama sudah dipakai atau lebih dari 200 karakter*</small>
					    	@endforeach
					    @endif
					</div>

					<div class="row">
	                    <div class="col-lg-12">
	                        <label for="event_starts">Tanggal Rilis</label>
	                        <div class="row">
	                            <div class="col-lg-6 ">
	                            	<input type="date" name="tanggal" id="date" class=" date-pick form-control"  value="{{date('Y-m-d', strtotime($data->tgl_rilis))}}" required>
	                            </div>
	                            <div class="col-lg-6 "><input type="time" name="waktu" id="time" value="{{date('H:i', strtotime($data->tgl_rilis))}}" class="form-control" required></div>
	                        </div>
	                    </div>
	                </div>

	                <br>

					<div class="row">
	                    <div class="col-lg-6">
	                        <label for="Judul">Lokasi</label>
					    	<input type="text" class="form-control" id="lokasi" value="{{$data->lokasi}}" name="lokasi" required>
	                    </div>

	                    <div class="col-lg-6">
	                        <label for="Judul">Penyelenggara</label>
					    	<input type="text" class="form-control" id="penyelenggara" value="{{$data->penyelenggara}}" name="penyelenggara" required>
	                    </div>
	                </div>
	                <br>

	                <div class="row">
	                    <div class="col-lg-6">
	                        <label for="Judul">Kontak</label>
					    <input type="text" class="form-control" id="kontak" name="kontak" value="{{$data->kontak}}" required>
	                    </div>

	                    <div class="col-lg-6">
	                        <label for="Judul">Website</label>
					    <input type="text" class="form-control" id="website" name="website" value="{{$data->website}}" required>
	                    </div>
	                </div>
	                <br>

					<div class="row">
	                    <div class="col-lg-6">
	                        <label for="event_starts">Mulai</label>
	                        <div class="row">
	                            <div class="col-lg-7 ">
	                            	<input type="text" name="tgl_mulai" id="date_start" value="{{date('m/d/Y', strtotime($data->waktu_mulai))}}" class=" date-pick form-control" required>
	                            </div>
	                            <div class="col-lg-5 "><input type="time" name="waktu_mulai" value="{{date('H:i', strtotime($data->waktu_mulai))}}" id="time_start" value="01:59" class="form-control" required></div>
	                        </div>
	                    </div>
	                    <div class="col-lg-6">
	                        <label for="event_ends">Berakhir</label>
	                        <div class="row">
	                            <div class="col-lg-7 "><input type="text" name="tgl_selesai" id="date_end" value="{{date('m/d/Y', strtotime($data->waktu_selesai))}}" class=" date-pick form-control" required></div>
	                            <div class="col-lg-5 "><input type="time" name="waktu_selesai" value="{{date('H:i', strtotime($data->waktu_selesai))}}" id="time_end" value="23:59"class="form-control" required></div>
	                        </div>
	                    </div>
	                </div>
	                <br>
					<div class="form-group">
					    <label for="konten">Deskripsi Agenda</label>
					    <textarea class="form-control" name="konten_agenda" id="deskripsi" style="height: 300px;">{!! $data->konten !!}</textarea>
					</div>
			</div>

			<div class="col-md-4 col-md-offset-2">
				<span class="border-bottom">
					<div class="form-group">
					    <label for="Thumbnail agenda">Thumbnail</label>
					    <img src="{{URL::asset($data->thumbnail_url)}}" width="350">
					</div>
					<br>
					<div class="form-group">
					    <label for="Thumbnail agenda">Thumbnail Pengganti</label>
					    <input type="file" class="form-control-file" accept="Image/*" name="thumbnail" id="file" />
					</div>

					<div id="thumbnail-preview" class="col-md-12">
						
					</div>
				</span>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<button type="button" data-toggle="modal" id="submit" data-target="#create_modal" class="btn btn-primary">Submit</button>
				<!-- Modal -->
					<div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg" role="document">
					    <div class="modal-content">
						  <div class="modal-header modal-header-info">
					        <h5 class="modal-title" id="exampleModalLabel">Preview</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					      	<div class="form-group">
							    <h3>Nama Agenda</h3>
							    <h1 id="modal_nama"></h1>
							</div>

							<div class="form-group">
							    <h3>Tanggal Rilis</h3>
							    <p id="modal_waktu"></p> 
							</div>

							<div class="row">
			                    <div class="col-lg-6">
			                        <h3>lokasi</h3>
							   		<p id="modal_lokasi"></p> 
			                    </div>

			                    <div class="col-lg-6">
			                        <h3>Penyelenggara</h3>
							    	<p id="modal_penyelenggara"></p> 
			                    </div>
			                </div>
			                <br>

			                <div class="row">
			                    <div class="col-lg-6">
			                        <h3>Kontak</h3>
							    	<p id="modal_kontak"></p> 
			                    </div>

			                    <div class="col-lg-6">
			                        <h3>Website</h3>
							    	<p id="modal_website"></p> 
			                    </div>
			                </div>
			                <br>

							<div class="row">
			                    <div class="col-lg-6">
			                        <h3>Mulai</h3>
			                        <p id="modal_mulai"></p> 
			                    </div>
			                    <div class="col-lg-6">
			                        <h3>Selesai</h3>
			                        <p id="modal_selesai"></p> 
			                    </div>
			                </div>
			                <br>
							<div class="form-group">
							    <h3>Deskripsi</h3>
			                    <p id="modal_deskripsi"></p> 
							</div>

							<div class="form-group">
							    <h3>Thumbnail Pengganti</h3>
							    <div id="modal_thumbnail">
							    	
							    </div>
							</div>
					        
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					        <button type="submit" class="btn btn-primary">Simpan</button>
							</form>
					      </div>
					    </div>
					  </div>
					</div>
				<!-- EndModal -->
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
