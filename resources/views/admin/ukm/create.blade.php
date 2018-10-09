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
    	<h1>Buat Artikel Ukm Baru</h1>
		<hr>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form action="{{route('admin.ukm.store')}}" method="POST" enctype="multipart/form-data">
					@csrf
				  	<div class="form-group">
					    <label for="Judul">Judul Konten</label>
					    <input type="text" class="form-control" name="nama_ukm" required>
					    @if(count($errors)>0)
					    	@foreach($errors->all() as $error)
					    		<small class="alert-danger">*Judul sudah dipakai atau lebih dari 200 karakter*</small>
					    	@endforeach
					    @endif
					</div>

					<div class="form-group">
					    <label for="konten">Isi Konten</label>
					    <textarea class="form-control" name="konten_ukm" style="height: 300px;"></textarea>
					</div>
			</div>

			<div class="col-md-4 col-md-offset-2">
				<span class="border-bottom">
					<div class="form-group">
					    <label for="Thumbnail ukm">Thumbnail</label>
					    <input type="file" class="form-control-file" accept="Image/*" name="thumbnail" id="file" />
					</div>

					<div id="thumbnail-preview" class="col-md-12">
						
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