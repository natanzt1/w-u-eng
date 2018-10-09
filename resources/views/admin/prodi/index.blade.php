@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')

{{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
$(document).ready(function() {
    $('#prodi').DataTable();
} );
</script>
@endsection

{{-- @section('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css"></script>
<script src="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"></script>
@endsection --}}

@section('content')
<div class="section-block center-holder">
    <div class="container card">
    	<div class="card-body">
	    	<div class="row">
	    		<div class="col-md-10 col-md-offset-2">
	    			<h1>List prodi</h1>
	    		</div>
	    		<div class="col-md-2 col-md-offset-2">
	    			<a href="{{route('admin.prodi.create')}}"><button id="create" class="btn btn-primary"><i class="mdi mdi-plus-box-outline"> Tambah</i>
	    			</button></a> 
	    		</div>
	    	</div>
	    	<hr>
			<div class="row">
				<div class="col-md-12 col-md-offset-2">
					<table id="prodi" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
				                <th>Nama prodi</th>
				                <th>Gallery Prodi</th>
				                <th>Status</th>
				                <th>Aksi</th>
				            </tr>
				        </thead>
				        <tbody>
				        	@foreach($datas as $data)
				            <tr>
				                <td>{{$data->nama_prodi}}</td>
				                <td>
				                	<a href="{{route('admin.prodi.detail', [$data->slug])}}" target="_blank"><button id="gallery" class="btn btn-info">Lihat Gallery</button></a>
				            	</td>

				                @if($data->status == 0)
				                <td><a href="{{route('admin.prodi.active', [$data->slug])}}"><button id="active" class="btn btn-info">Nonaktif</button></a></td>
				                @else
				                <td><a href="{{route('admin.prodi.nonactive', [$data->slug])}}"><button id="nonactive" class="btn btn-info">Aktif</button></a></td>
				                @endif

				                <td>
				                	<a href="{{route('admin.prodi.edit', [$data->slug])}}"><button id="edit" class="d-inline btn btn-info"><i class="mdi mdi-pencil"></i></button></a> 
				                	<form method="post" action="{{route('admin.prodi.delete', [$data->id])}}" class="d-inline">
				                		@csrf
				                		<button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-danger"><i class="ti-trash"> </i></button>
				                	<!-- Modal -->
										<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
@endsection