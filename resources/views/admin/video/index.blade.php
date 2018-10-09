@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')


<script type="text/javascript">
$(document).ready(function() {
    $('#video').DataTable({
			"aaSorting": []
		});
} );
</script>

<script>
    $(document).on("click", "#edit-url", function () {
	     var name = $(this).data('nama');
	     var link = $(this).data('url');
	     var slug = $(this).data('slug');
	     var action = "/administrator/video/"+slug+"/update"; 
	     $("#old-url").val( link );
	     $("#nama_video").val( name );
	     $('#form-modal').attr('action', action);
	});
</script>

<script>
    $(document).on("click", "#new_video", function () {
	     var action = "/administrator/video/"; 
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
	    			<h1>List video</h1>
	    		</div>
	    		<div class="col-md-2 col-md-offset-2">
	    			<button 
	    				type="button" class="btn btn-primary" id="new_video" data-toggle="modal" data-target="#exampleModal">
						<i class="mdi mdi-plus-box-outline"> Tambah</i>
					</button>
	    		</div>
	    	</div>
	    	<hr>
			<div class="row">
				<div class="col-md-12 col-md-offset-2">
					<table id="video" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
				                <th>Nama Video</th>
				                <th>Pengunggah</th>
				                <th>Status</th>
				                <th>Aksi</th>
				            </tr>
				        </thead>
				        <tbody>
				        	@foreach($datas as $i=>$data)
				            <tr>
				                <td><a href="{{$data->url}}">{{$data->nama_video}}</a></td>
				                <td>{{$data->user_nama}}</td>

				                @if($data->status == 0)
				                <td><a href="{{route('admin.video.active', [$data->slug])}}"><button id="edit" class="btn btn-danger">Nonaktif</button></a> </td>
				                @else
				                <td><a href="{{route('admin.video.nonactive', [$data->slug])}}"><button id="edit" class="btn btn-info">Aktif</button></a></td>
				                @endif

				                <td>
				                	<a href="{{route('admin.video.edit', [$data->slug])}}"><button id="edit" class="btn btn-info d-inline"><i class="mdi mdi-pencil"></i></button></a> 
				                	<form method="post" action="{{route('admin.video.delete', [$data->slug])}}" class="d-inline">
				                		@csrf
				                		<button type="button" data-toggle="modal" data-target="#exampleModal{{$i}}" class="btn btn-danger"><i class="ti-trash"> </i></button>
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
      	<form id="form-modal" action="#" width="200px" method="post">
      		@csrf
      		<div class="form-group">
			    <label for="nama">Nama Video</label>
			    <input type="text" class="form-control" id="nama_video" name="nama_video" value="">
			    @if(count($errors)>0)
			    	@foreach($errors->all() as $error)
			    		<small class="alert-danger">*Nama sudah dipakai atau lebih dari 200 karakter*</small>
			    	@endforeach
			    @endif
			</div>
      		<div class="form-group">
			    <label for="old-url">URL:</label>
			    <input type="text" class="form-control" id="old-url" name="url_video">
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
@endsection