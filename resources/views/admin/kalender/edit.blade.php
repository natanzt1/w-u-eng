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
            $('#thumbnail-preview').after('<img alt="Image" src="'+e.target.result+'" width="350" />');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#file").change(function () {
    filePreview(this);
});

</script>
@endsection

@section('css')
@endsection

@section('content')
<div class="section-block center-holder">
    <div class="container">
    	<h1>Edit kalender</h1>
		<hr>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form action="{{route('admin.kalender.update',[$data->tahun_ajaran])}}" method="POST" enctype="multipart/form-data">
					@csrf
				  	<div class="form-group">
					    <label for="Judul">Tahun Ajaran</label>
					    <select name="tahun_ajaran" class="form-control">
					    	<option value="{{$data->tahun_ajaran}}">{{$data->tahun_ajaran}}</option>
					    	@for($i=2000;$i<=2050;$i++)
					    	<option value="{{$i}}">{{$i}}</option>
					    	@endfor
					    </select>
					    @if(count($errors)>0)
					    	@foreach($errors->all() as $error)
					    		<small class="alert-danger">*Tahun Ajaran sudah dipakai atau lebih dari 200 karakter*</small>
					    	@endforeach
					    @endif
					</div>
			</div>

			<div class="col-md-4 col-md-offset-2">
				<a href="/{{$data->url}}" target="_blank"><button class="btn btn-primary">Kalender Akademik</button></a>
				<br><br>
				<span class="border-bottom">
					<div class="form-group">
					    <label for="Thumbnail kalender">Upload Dokumen Kalender Baru</label>
					    <input type="file" class="form-control-file" name="kalender" id="file" />
					</div>
				</span>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<button type="button" data-toggle="modal" data-target="#create_modal" class="btn btn-primary">Submit</button>
				<!-- Modal -->
					<div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        Apakah Anda yakin ingin menyimpan data ini?
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
			</div>
		</div>
	</div>
</div>
@endsection