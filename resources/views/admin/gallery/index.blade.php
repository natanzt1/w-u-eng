@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')

<script>
$(document).ready(function() {
	$('#gallery').DataTable({
		"aaSorting": []
	});
});
</script>

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

<script>
    $(document).on("click", "#edit-url", function () {
	     var action = $(this).data('action');
	     var name = $(this).data('nama');
	     $("#nama_gallery").val( name );
	     $('#form-modal').attr('action', action);
	});
</script>


@endsection

@section('css')

@endsection

@section('content')
<div class="section-block center-holder">
    <div class="container card">
    	<div class="card-body">
	    	<div class="row">
	    		<div class="col-md-10 col-md-offset-2">
	    			<h1>List Gallery</h1>
	    		</div>
	    		<div class="col-md-2 col-md-offset-2">
	    			<button 
	    				type="button" class="btn btn-primary" id="new_gallery" data-toggle="modal" data-target="#exampleModal">
						<i class="mdi mdi-plus-box-outline"> Tambah</i>
					</button>
	    		</div>
	    	</div>
	    	<hr>
	    	<small>*Gallery Hanya dapat Diaktifkan Bila sudah terdapat minimal 1 Foto di dalamnya.</small>
			<div class="row">
				<div class="col-md-12 col-md-offset-2">
					<table id="gallery" class="table table-striped table-bordered" style="width:100%">
						<thead>
				            <tr>
				                <th>Nama gallery</th>
				                <th>Status</th>
				                <th>Views</th>
				                <th>Aksi</th>
				            </tr>
				        </thead>
				        <tbody>
				        	@foreach($datas as $data)
				            <tr>
				                <td><a href="{{route('admin.gallery.detail',[$data->slug])}}" class="btn btn-info">{{$data->nama_gallery}}</a></td>

				                <td>
				                @if($data->status == 0)
			                	<a href="{{route('admin.gallery.active', [$data->slug])}}"><button id="aktif" class="btn btn-danger">Nonaktif</button></a>
			                	@else
			                	<a href="{{route('admin.gallery.nonactive', [$data->slug])}}"><button id="aktif" class="btn btn-info">Aktif</button></a>
			                	@endif
			                	</td>

				                <td>{{$data->views}}</td>
				                <td>
				                	<button type="button" class="btn btn-primary" id="edit-url" data-url="{{$data->icon_url}}" data-slug="{{$data->slug}}" data-toggle="modal" data-nama="{{$data->nama_gallery}}" data-target="#exampleModal" data-action="{{route('admin.gallery.update',[$data->slug])}}">
									  <i class="mdi mdi-pencil"></i>
									</button>
				                </td>
				            </tr>
				            @endforeach
				        </tbody>
				    </table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Gallery</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form id="form-modal" action="{{route('admin.gallery.store')}}" width="200px" method="post">
      		@csrf
      		<div class="form-group">
			    <label for="nama">Nama gallery</label>
			    <input type="text" class="form-control" id="nama_gallery" name="nama_gallery" value="">
			    @if(count($errors)>0)
			    	@foreach($errors->all() as $error)
			    		<small class="alert-danger">*Judul sudah dipakai atau lebih dari 200 karakter*</small>
			    	@endforeach
			    @endif
			</div>
      </div>
      <div class="modal-footer">
      	<button type="submit" class="btn btn-primary">Simpan</button>
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection