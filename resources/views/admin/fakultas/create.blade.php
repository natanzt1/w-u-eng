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
    	<h1>Buat Profil Fakultas Baru</h1>
		<hr>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form action="{{route('admin.fakultas.store')}}" method="POST" enctype="multipart/form-data">
					@csrf
				  	<div class="form-group">
					    <label for="Judul">Nama Fakultas</label>
					    <input type="text" class="form-control" name="nama_fakultas" required>
					    @if(count($errors)>0)
					    	@foreach($errors->all() as $error)
					    		<small class="alert-danger">*Nama sudah dipakai atau lebih dari 200 karakter*</small>
					    	@endforeach
					    @endif
					</div>

					<div class="form-group">
					    <label for="konten">Visi Fakultas</label>
					    <textarea class="form-control" name="visi" style="height: 50px;"></textarea>
					</div>

					<div class="form-group">
					    <label for="konten">Misi Fakultas</label>
					    <textarea class="form-control" name="misi" style="height: 50px;"></textarea>
					</div>

					<div class="form-group">
					    <label for="konten">Tujuan</label>
					    <textarea class="form-control" name="tujuan" style="height: 50px;"></textarea>
					</div>

					<div class="form-group">
					    <label for="konten">Sasaran</label>
					    <textarea class="form-control" name="sasaran" style="height: 50px;"></textarea>
					</div>

					<div class="form-group">
					    <label for="konten">Latar Belakang</label>
					    <textarea class="form-control" name="latar_belakang" style="height: 50px;"></textarea>
					</div>

					<div class="form-group">
					    <label for="konten">Akreditasi</label>
					    <input type="text" class="form-control" name="akreditasi">
					</div>

					<div class="form-group">
					    <label for="konten">Info Lain</label>
					    <textarea class="form-control" name="info_lain" style="height: 50px;"></textarea>
					</div>
			</div>

			<div class="col-md-4 col-md-offset-2">
				<span class="border-bottom">
					<div class="form-group">
					    <label for="Thumbnail fakultas">Logo Fakultas</label>
					    <input type="file" class="form-control-file" accept="Image/*" name="logo" id="file" />
					</div>

					<div id="thumbnail-preview" class="col-md-12">
						
					</div>

					<div class="form-group">
					    <label for="Thumbnail fakultas">Struktur</label>
					    <input type="file" class="form-control-file" name="struktur" id="file" />
					</div>

				</span>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection