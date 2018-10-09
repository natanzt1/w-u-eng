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
    	<h1>Edit Fakultas</h1>
		<hr>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form action="{{route('admin.fakultas.update',[$data->slug])}}" method="POST" enctype="multipart/form-data">
					@csrf
				  	<div class="form-group">
					    <label for="Judul">Nama Fakultas</label>
					    <input type="text" class="form-control" name="nama_fakultas" value="{{ $data->nama_fakultas }}" required>
					    @if(count($errors)>0)
					    	@foreach($errors->all() as $error)
					    		<small class="alert-danger">*Nama sudah dipakai atau lebih dari 200 karakter*</small>
					    	@endforeach
					    @endif
					</div>

					<div class="form-group">
					    <label for="konten">Visi Fakultas</label>
					    <textarea class="form-control" name="visi" style="height: 300px;">{!! $data->visi !!}</textarea>
					</div>

					<div class="form-group">
					    <label for="konten">Misi Fakultas</label>
					    <textarea class="form-control" name="misi" style="height: 300px;">{!! $data->misi !!}</textarea>
					</div>

					<div class="form-group">
					    <label for="konten">Tujuan</label>
					    <textarea class="form-control" name="tujuan" style="height: 300px;">{!! $data->tujuan !!}</textarea>
					</div>

					<div class="form-group">
					    <label for="konten">Sasaran</label>
					    <textarea class="form-control" name="sasaran" style="height: 300px;">{!! $data->sasaran !!}</textarea>
					</div>

					<div class="form-group">
					    <label for="konten">Latar Belakang</label>
					    <textarea class="form-control" name="latar_belakang" style="height: 300px;">{!! $data->latar_belakang !!}</textarea>
					</div>

					<div class="form-group">
					    <label for="konten">Akreditasi</label>
					    <input type="text" class="form-control" name="akreditasi" value="{{$data->akreditasi}}">
					</div>

					<div class="form-group">
					    <label for="konten">Info Lain</label>
					    <textarea class="form-control" name="info_lain" style="height: 300px;">{!! $data->info_lain !!}</textarea>
					</div>
			</div>

			<div class="col-md-4 col-md-offset-2">
				<span class="border-bottom">
					<div class="form-group">
					    <label for="Struktur Fakultas">Logo</label>
					    <img src="{{URL::asset($data->logo_url)}}" width="350">
					</div>
					<br>
					<div class="form-group">
						<label for="Thumbnail ukm">Upload Logo Baru</label>
					    <input type="file" class="form-control-file" accept="Image/*" name="logo" id="file" />
					</div>
				<hr>
					<div id="thumbnail-preview" class="col-md-12">
						
					</div>
				<hr>
					<div class="form-group">
					    <label for="Struktur Fakultas">Struktur</label>
					    <img src="{{URL::asset($data->struktur)}}" width="350">
					</div>
					<br>
					<div class="form-group">
						<label for="Thumbnail ukm">Upload Struktur Baru</label>
					    <input type="file" class="form-control-file" name="struktur" id="file" />
					</div>
				</span>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<button type="button" data-toggle="modal" data-target="#edit_modal" class="btn btn-primary">Submit</button>
				<!-- Modal -->
					<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        Apakah Anda yakin ingin memperbarui data ini?
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					        <button type="submit" class="btn btn-danger">Simpan</button>
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