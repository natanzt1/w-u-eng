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
            $('#logo-preview + img').remove();
            $('#logo-preview').after('<img alt="Image" src="'+e.target.result+'" width="350" />');
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
    	<h1>Buat Profil Bem Baru</h1>
		<hr>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form action="{{route('admin.bem.store')}}" method="POST" enctype="multipart/form-data">
					@csrf
				  	<div class="form-group">
					    <label for="Judul">Nama bem</label>
					    <input type="text" class="form-control" name="nama_bem" required>
					    @if(count($errors)>0)
					    	@foreach($errors->all() as $error)
					    		<small class="alert-danger">*Nama sudah dipakai atau lebih dari 200 karakter*</small>
					    	@endforeach
					    @endif
					</div>

					<div class="form-group">
					    <label for="konten">Profil bem</label>
					    <textarea class="form-control" name="konten_bem" style="height: 300px;"></textarea>
					</div>
			</div>

			<div class="col-md-4 col-md-offset-2">
				<span class="border-bottom">
					<div class="form-group">
					    <label for="logo bem">Logo</label>
					    <input type="file" class="form-control-file" accept="Image/*" name="logo" id="file" />
					</div>

					<div id="logo-preview" class="col-md-12">
						
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