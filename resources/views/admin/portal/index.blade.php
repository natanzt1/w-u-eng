@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')

<script>
$(document).ready(function() {
	$('#portal').DataTable();
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
	     var name = $(this).data('nama');
	     var link = "/"+$(this).data('url');
	     var slug = $(this).data('slug');
	     var action = "/public/administrator/portal/"+slug+"/update"; 
		 $('#thumbnail-preview + img').remove();
         $('#thumbnail-preview').after('<img alt="Image" src="'+link+'" width="350" />');
	     $("#nama_portal").val( name );
	     $('#form-modal').attr('action', action);
	});
</script>

<script>
    $(document).on("click", "#new_portal", function () {
	     var action = "/administrator/portal/"; 
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
	    			<h1>List Portal</h1>
	    		</div>
	    		<div class="col-md-2 col-md-offset-2">
	    			<button 
	    				type="button" class="btn btn-primary" id="new_portal" data-toggle="modal" data-target="#exampleModal">
						<i class="mdi mdi-plus-box-outline"> Tambah</i>
					</button>
	    		</div>
	    	</div>
	    	<hr>
			<div class="row">
				<div class="col-md-12 col-md-offset-2">
					<table id="portal" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
				                <th>Nama portal</th>
				                <th>Icon</th>
				                <th>Penulis</th>
				                <th>Status</th>
				                <th>Views</th>
				                <th>Aksi</th>
				            </tr>
				        </thead>
				        <tbody>
				        	@foreach($datas as $i=>$data)
				            <tr>
				                <td>{{$data->nama_portal}}</td>
				                <td>
				                	<a href="{{$data->url}}">
				                		<img src="{{URL::asset($data->icon_url)}}" width="48">
				                	</a>
				                </td>
				                <td>{{$data->user_nama}}</td>

				                <td>{{$data->views}}</td>
				                @if($data->status == 0)
				                <td><a href="{{route('admin.portal.active', [$data->slug])}}"><button id="edit" class="btn btn-danger">Nonaktif</button></a> </td>
				                @else
				                <td><a href="{{route('admin.portal.nonactive', [$data->slug])}}"><button id="edit" class="btn btn-info">Aktif</button></a></td>
				                @endif

				                <td>
				                	<a href="{{route('admin.portal.edit', [$data->slug])}}"><button id="edit" class="d-inline btn btn-info"><i class="mdi mdi-pencil"></i></button></a> 
				                	<form method="post" action="{{route('admin.portal.delete', [$data->slug])}}" class="d-inline">
				                		@csrf
				                		<button type="button" data-toggle="modal" data-target="#exampleModal{{$i}}" class="btn btn-danger">Hapus</button>
				                	<!-- Modal -->
										<div class="modal fade" id="exampleModal{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										  <div class="modal-dialog" role="document">
										    <div class="modal-content">
										      <div class="modal-header">
										        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										          <span aria-hidden="true">&times;</span>
										        </button>
										      </div>
										      <div class="modal-body">
										        Apakah Anda yakin ingin menghapus data ini?
										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										        <button type="submit" class="btn btn-danger">Hapus</button>
												</form>
										      </div>
										    </div>
										  </div>
										</div>
									<!-- EndModal -->
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
        <h5 class="modal-title" id="exampleModalLabel">Edit URL</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form id="form-modal" action="#" width="200px" method="post" enctype="multipart/form-data">
      		@csrf
      		<div class="form-group">
			    <label for="nama">Nama portal</label>
			    <input type="text" class="form-control" id="nama_portal" name="nama_portal" value="">
			    @if(count($errors)>0)
			    	@foreach($errors->all() as $error)
			    		<small class="alert-danger">*Nama sudah dipakai atau lebih dari 200 karakter*</small>
			    	@endforeach
			    @endif
			</div>
      		<div class="form-group">
			    <label for="old-url">URL:</label>
			    <input type="text" class="form-control" id="old-url" name="url_portal">
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection