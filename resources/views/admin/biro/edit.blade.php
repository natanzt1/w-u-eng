@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')
<script type="text/javascript">
{{-- function filePreview(input) {
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
}); --}}

$('#submit').click( function() {
	var nama = $('#nama').val();
	var konten = tinymce.get('konten').getContent() ;
	$('#modal_nama').html( nama );
	$('#modal_konten').html( konten );
});

</script>

@endsection

@section('css')
@endsection

@section('content')
<div class="section-block center-holder">
    <div class="container">
    	<h1>Edit Biro</h1>
		<hr>
		<div class="row">
			<div class="col-md-12 col-md-offset-2">
				<form action="{{route('admin.biro.update', [$data->slug])}}" method="POST" enctype="multipart/form-data">
					@csrf
				  	<div class="form-group">
					    <label for="Judul">Nama Biro</label>
					    <input type="text" class="form-control" name="nama_biro" id="nama" value="{{$data->nama_biro}}" required>
					    @if(count($errors)>0)
					    	@foreach($errors->all() as $error)
					    		<small class="alert-danger">*Nama sudah dipakai atau lebih dari 200 karakter*</small>
					    	@endforeach
					    @endif
					</div>

					<div class="form-group">
					    <label for="Judul">Deskripsi Biro</label>
					    <textarea class="form-control" name="konten_biro" id="konten" style="height: 300px">{!! $data->deskripsi !!}</textarea>
					</div>
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
							    <h3>Nama Biro</h3>
							    <h1 id="modal_nama"></h1>
							</div>

							<div class="form-group">
							    <h3>Deskripsi Biro</h3>
							    <p id="modal_konten"></p> 
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