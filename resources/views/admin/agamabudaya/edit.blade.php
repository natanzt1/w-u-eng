@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')
<script type="text/javascript">
function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#thumbnail-preview + img').remove();
            $('#thumbnail-preview').after('<img alt="Image" id="thumbnail" src="'+e.target.result+'" width="350" />');
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
	var nama_en = $('#nama)en').val();
	var konten = tinymce.get('konten').getContent() ;
	var konten_en = tinymce.get('konten_en').getContent() ;
	var tanggal = $('#date').val();
	var waktu = $('#time').val();
	$('#modal_date').html( tanggal );
	$('#modal_time').html( waktu );
	$('#modal_nama').html( nama );
	$('#modal_konten').html( konten );
	$('#modal_nama_en').html( nama_en );
	$('#modal_konten_en').html( konten_en );
});

</script>

@endsection

@section('css')
@endsection

@section('content')
<div class="section-block center-holder">
    <div class="container">
    	<h1>Edit Artikel</h1>
		<hr>
		<div class="row">
			<div class="col-md-6 col-md-offset-2">
				<form action="{{route('admin.agamabudaya.store')}}" method="POST" enctype="multipart/form-data">
					@csrf
				  	<div class="form-group">
					    <label for="Judul">Judul Konten</label>
					    <input type="text" class="form-control" name="nama_agamabudaya" id="nama" value="{{$data->nama_agamabudaya}}" required>
					    @if(count($errors)>0)
					    	@foreach($errors->all() as $error)
					    		<small class="alert-danger">*Judul sudah dipakai atau lebih dari 200 karakter*</small>
					    	@endforeach
					    @endif
					</div>

					<div class="form-group">
					    <label for="event_starts">Tanggal Rilis</label>
					    <input type="date" name="tanggal" id="date" class=" date-pick form-control" value="{{date('Y-m-d', strtotime($data->tgl_rilis))}}" required>
					</div>

					<div class="form-group">
					    <label for="konten">Isi Konten</label>
					    <textarea class="form-control" name="konten_agamabudaya" id="konten" style="height: 300px;">{!! $data->konten !!}</textarea>
					</div>

					<hr>
					<div class="form-group">
					    <label for="Thumbnail agamabudaya">Thumbnail</label>
					    <input type="file" class="form-control-file" accept="Image/*" name="thumbnail" id="file" required />
					</div>

			</div>

			<div class="col-md-6 col-md-offset-2">
				<span class="border-bottom">
					<div class="form-group">
					    <label for="Judul">Judul English</label>
					    <input type="text" class="form-control" name="nama_agamabudaya_en" id="nama_en" value="{{$data->en_nama_agamabudaya}}" required>
					</div>

					<div class="form-group">
					    <label for="event_starts">Waktu</label>
					    <input type="time" name="waktu" id="time" value="{{date('H:i', strtotime($data->tgl_rilis))}}" class="form-control" required>
					</div>

					<div class="form-group">
					    <label for="konten">Konten English</label>
					    <textarea class="form-control" name="konten_agamabudaya_en" id="konten_en" style="height: 300px;">{!! $data->en_konten !!}</textarea>
					</div>

					<hr>
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
							    <h3>Judul</h3>
							    <h1 id="modal_nama"></h1>
							</div>

							<div class="row">
			                    <div class="col-lg-12">
			                        <label for="event_starts">Tanggal Rilis</label>
			                        <div class="row">
			                            <div class="col-lg-3 ">
			                            	<p id="modal_date"></p>
			                            </div>
			                            <div class="col-lg-5 ">
			                            	<p id="modal_time"></p>
			                            </div>
			                        </div>
			                    </div>
			                </div>

							<div class="form-group">
							    <h3>Konten</h3>
							    <p id="modal_konten"></p> 
							</div>

							<div class="form-group">
							    <h3>Judul English</h3>
							    <p id="modal_nama_en"></p> 
							</div>

							<div class="form-group">
							    <h3>Konten English</h3>
							    <p id="modal_konten_en"></p> 
							</div>

					        <div class="form-group">
							    <h3>Thumbnail</h3>
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