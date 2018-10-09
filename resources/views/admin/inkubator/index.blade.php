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
    $('#inkubator').DataTable();
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
	    			<h1>List Konten Inkubator Bisnis</h1>
	    		</div>
	    		{{-- <div class="col-md-2 col-md-offset-2">
	    			<a href="{{route('admin.inkubator.create')}}"><button id="create" class="btn btn-primary"><i class="mdi mdi-plus-box-outline"> Tambah</i>
	    			</button></a> --}}
	    		</div>
	    	</div>
	    	<hr>
			<div class="row">
				<div class="col-md-12 col-md-offset-2">
					<table id="inkubator" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
				                <th>Judul</th>
				                <th>Aksi</th>
				            </tr>
				        </thead>
				        <tbody>
				        	@foreach($datas as $i=>$data)
				            <tr>
				                <td>{{$data->nama_inkubator}}</td>

				                <td>
				                	<a href="{{route('admin.inkubator.edit', [$data->slug])}}"><button id="edit" class="btn btn-info"><i class="mdi mdi-pencil"></i></button></a> 
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