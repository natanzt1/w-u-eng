@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')

<script type="text/javascript">
$(document).ready(function() {
    $('#repository').DataTable();
} );
</script>

<script>
    $(document).on("click", "#edit-url", function () {
	     var name = $(this).data('nama');
	     var link = $(this).data('url');
	     var slug = $(this).data('slug');
	     var deskripsi = $(this).data('deskripsi');
	     var action = "/administrator/repository/"+slug+"/update"; 
	     $("#old-url").val( link );
	     $("#nama_repository").val( name );
	     $("#deskripsi_repository").val( deskripsi );
	     $('#form-modal').attr('action', action);
	});
</script>

<script>
    $(document).on("click", "#new_repository", function () {
	     var action = "/administrator/repository/"; 
	     $('#form-modal').attr('action', action);
	});
</script>

@endsection

@section('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css"></script>
<script src="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"></script>
@endsection

@section('content')
<div class="section-block center-holder">
    <div class="container card">
    	<div class="card-body">
	    	<div class="row">
	    		<div class="col-md-10 col-md-offset-2">
	    			<h1>List repository</h1>
	    		</div>
	    		<div class="col-md-2 col-md-offset-2">
	    			<button 
	    				type="button" class="btn btn-primary" id="new_repository" data-toggle="modal" data-target="#exampleModal">
						<i class="mdi mdi-plus-box-outline"> Tambah</i>
					</button>
	    		</div>
	    	</div>
	    	<hr>
			<div class="row">
				<div class="col-md-12 col-md-offset-2">
					<table id="repository" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
				                <th>Judul</th>
				                <th>Penulis</th>
				                <th>Status</th>
				                <th>Views</th>
				                <th>Aksi</th>
				            </tr>
				        </thead>
				        <tbody>
				        	@foreach($datas as $i=>$data)
				            <tr>
				                <td><a href="{{$data->url}}">{{$data->nama_repository}}</a></td>
				                <td>{{$data->user_nama}}</td>

				                @if($data->status == 0)
				                <td><a href="{{route('admin.repository.active', [$data->slug])}}"><button id="edit" class="btn btn-danger">Nonaktif</button></a> </td>
				                @else
				                <td><a href="{{route('admin.repository.nonactive', [$data->slug])}}"><button id="edit" class="btn btn-info">Aktif</button></a></td>
				                @endif
				                <td>{{$data->views}}</td>

				                <td>
				                	<a href="{{route('admin.repository.edit', [$data->slug])}}"><button id="edit" class="btn btn-info d-inline"><i class="mdi mdi-pencil"></i></button></a> 
				                	<form method="post" action="{{route('admin.repository.delete', [$data->slug])}}" class="d-inline">
				                		@csrf
				                		<button type="button" data-toggle="modal" data-target="#exampleModal{{$i}}" class="btn btn-danger d-inline"><i class="ti-trash"> </i></button>
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
			    <label for="nama">Nama repository</label>
			    <input type="text" class="form-control" id="nama_repository" name="nama_repository" value="">
			    @if(count($errors)>0)
			    	@foreach($errors->all() as $error)
			    		<small class="alert-danger">*Nama sudah dipakai atau lebih dari 200 karakter*</small>
			    	@endforeach
			    @endif
			</div>
      		<div class="form-group">
			    <label for="old-url">Link:</label>
			    <input type="text" class="form-control" id="old-url" name="url_repository">
			</div>
			<div class="form-group">
			    <label for="konten">Deskripsi</label>
			    <textarea class="form-control" name="deskripsi_repository" style="height: 150px;" id="deskripsi_repository"></textarea>
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