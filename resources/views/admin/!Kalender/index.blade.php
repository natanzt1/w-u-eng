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
    $('#kalender').DataTable();
} );
</script>

<script>
    $(document).on("click", "#edit-url", function () {

	     var tahun = $(this).data('tahun')
	     var action = "/administrator/kalender/"+tahun+"/update"; 
	     alert(action);
	     $("#thn_old").val (tahun);
	     $("#old-url").val( link );
	     $("#form_tahun").html( tahun );
	     $('#form-modal-edit').attr('action', action);
	});
</script>

<script>
    $(document).on("click", "#new_kalender", function () {
	     var action = "/administrator/kalender/"; 
	     $('#form-modal').attr('action', action);
	});
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
	    			<h1>List Kalender Akademik</h1>
	    		</div>
	    		<div class="col-md-2 col-md-offset-2">
	    			<button 
	    				type="button" class="btn btn-primary" id="new_kalender" data-toggle="modal" data-target="#exampleModal">
						Tambah
					</button>
	    		</div>
	    	</div>
	    	<hr>
			<div class="row">
				<div class="col-md-12 col-md-offset-2">
					<table id="kalender" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
				                <th>Tahun Ajaran</th>
				                <th>Status</th>
				                <th>Views</th>
				                <th>Aksi</th>
				            </tr>
				        </thead>
				        <tbody>
				        	@foreach($datas as $data)
				            <tr>

				                <td>{{$data->tahun_ajaran}}</td>

				                @if($data->status == 0)
				                <td>Nonaktif</td>
				                @else
				                <td>Aktif</td>
				                @endif

				                <td>61</td>
				                <td>
				                	<button type="button" class="btn btn-primary" id="edit-url" data-tahun="{{$data->tahun_ajaran}}" data-toggle="modal" data-target="#edit_modal">
									  Edit
									</button>
				                	@if($data->status == 0)
				                	<a href="{{route('admin.kalender.active', [$data->slug])}}"><button id="aktif" class="btn btn-danger">Aktif-kan</button></a>
				                	@else
				                	<a href="{{route('admin.kalender.nonactive', [$data->slug])}}"><button id="nonaktif" class="btn btn-danger">Nonaktif-kan</button></a>
				                	@endif
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
        <h5 class="modal-title" id="exampleModalLabel">Kalender</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form id="form-modal" action="#" width="200px" method="post" enctype="multipart/form-data">
      		@csrf
			<div class="form-group">
			    <label for="konten">Tahun Ajaran</label>
			    <select name="tahun_ajaran" class="form-control" required="">
			    	@for ($i = 2000; $i < 2050; $i++)
    				<option value="{{$i}}">{{$i}}</option>
					@endfor
			    	
			    </select>
			</div>
			<div class="form-group">
			    <label for="old-url">Tambah Kalender</label>
			    <input type="file" class="form-control-file" name="kalender" id="file" required />
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

<!-- Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Kalender</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      	<form id="form-modal-edit" action="#" width="200px" method="post" enctype="multipart/form-data">
      		@csrf
			<div class="form-group">
			    <label for="old-url">Tahun Ajaran</label>
			    <input type="text" class="form-control" name="tahun_old" id="thn_old" disabled />
			</div>
			<div class="form-group">
			    <label for="konten">Tahun Ajaran Pengganti</label>
			    <select name="tahun_ajaran" class="form-control">
			    	
			    	@for ($i = 2000; $i < 2050; $i++)
    				<option id="form_tahun" value="{{$i}}">{{$i}}</option>
					@endfor
			    	
			    </select>
			</div>
			<div class="form-group">
			    <label for="old-url">Dokumen Kalender</label>
			    <input type="file" class="form-control-file" name="kalender" id="file" required />
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