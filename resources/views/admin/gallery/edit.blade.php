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
    	<h1>Edit Pengumuman</h1>
		<hr>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form action="{{route('admin.pengumuman.update', [$data[0]->slug])}}" method="POST" enctype="multipart/form-data">
					@csrf
				  	<div class="form-group">
					    <label for="Judul">Judul pengumuman</label>
					    <input type="text" class="form-control" name="nama_pengumuman" value="{{$data[0]->nama_pengumuman}}" required>
					</div>

					<div class="form-group">
					    <label for="Judul">Isi pengumuman</label>
					    <textarea class="form-control" name="konten_pengumuman" style="height: 300px">{!! $data[0]->konten !!}</textarea>
					</div>
			</div>

			<div class="col-md-4 col-md-offset-2">
				<span class="border-bottom">
					<div class="form-group">
					    <label for="Thumbnail pengumuman">Thumbnail Pengumuman</label>
					    <img src="{{URL::asset($data[0]->thumbnail_url)}}" width="350">
					</div>
					<br>
					<div class="form-group">
						<label for="Thumbnail pengumuman">Upload Thumbnail pengumuman Baru</label>
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