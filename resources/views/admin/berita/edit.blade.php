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
	var konten = tinymce.get('konten').getContent() ;
	var mulai = $('#date').val()+" "+$('#time').val();
	$('#modal_nama').html( nama );
	$('#modal_waktu').html( mulai );
	$('#modal_konten').html( konten );
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
			<div class="col-md-8 col-md-offset-2">
				<form action="{{route('admin.berita.update', [$data->slug])}}" method="POST" enctype="multipart/form-data">
					@csrf
				  	<div class="form-group">
					    <label for="Judul">Judul Konten</label>
					    <input type="text" class="form-control" name="nama_berita" id="nama" value="{{$data->nama_berita}}" required>
					    @if(count($errors)>0)
					    	@foreach($errors->all() as $error)
					    		<small class="alert-danger">*Judul sudah dipakai atau lebih dari 200 karakter*</small>
					    	@endforeach
					    @endif
					</div>

					<div class="row">
	                    <div class="col-lg-12">
	                        <label for="event_starts">Tanggal Rilis</label>
	                        <div class="row">
	                            <div class="col-lg-7 ">
	                            	<input type="date" name="tanggal" id="date" class=" date-pick form-control"  value="{{date('Y-m-d', strtotime($data->tgl_rilis))}}" required>
	                            </div>
	                            <div class="col-lg-5 "><input type="time" name="waktu" id="time" value="{{date('H:i', strtotime($data->tgl_rilis))}}" class="form-control" required></div>
	                        </div>
	                    </div>
	                </div>

					<div class="form-group">
					    <label for="Judul">Isi Konten</label>
					    <textarea class="form-control" name="konten_berita" id="konten" style="height: 300px">{!! $data->konten !!}</textarea>
					</div>
			</div>

			<div class="col-md-4 col-md-offset-2">
				<span class="border-bottom">
					<div class="form-group">
					    <label for="Thumbnail berita">Thumbnail</label>
					    <img src="{{URL::asset($data->thumbnail_url)}}" width="350">
					</div>
					<br>
					<div class="form-group">
						<label for="Thumbnail berita">Upload Thumbnail Baru</label>
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
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
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

							<div class="form-group">
							    <h3>Tanggal Rilis</h3>
							    <p id="modal_waktu"></p> 
							</div>

							<div class="form-group">
							    <h3>Konten</h3>
							    <p id="modal_konten"></p> 
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