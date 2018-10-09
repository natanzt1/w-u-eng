@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')

<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var x = JSON.parse("{{ json_encode($i) }}");
	for (i = 0; i <= x+1; i++) { 
		var id = "#tentang"+i;
	 	$(id).DataTable();
	}
} );
</script>
@endsection

@section('css')

@endsection

@section('content')
<div class="section-block center-holder">
	@foreach($contents as $i => $content)
    <div class="container card">
    	<div class="card-body">
	    	<div class="row">
	    		<div class="col-md-10 col-md-offset-2">
	    			<h1>{{$content->nama}}</h1>
	    		</div>
	    		<div class="col-md-2 col-md-offset-2">
	    			<a href="{{route('admin.tentang.create')}}"><button id="create" class="btn btn-primary">Tambah Data</button></a> 
	    		</div>
	    	</div>
	    	<hr>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<table id="tentang{{$i}}" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
						        <thead>
						            <tr>
						                <th>Bagian</th>
						                <th>Penulis</th>
						                <th>Status</th>
						                <th>Aksi</th>
						            </tr>
						        </thead>
						        <tbody>
						        	@foreach($datas[$i] as $data)
						            <tr>
						                <td><a href="{{$data->slug.'/show'}}">{{$data->nama}}</a></td>
						                <td>{{$data->user->name}}</td>

						                @if($data->status == 0)
						                <td>Nonaktif</td>
						                @else
						                <td>Aktif</td>
						                @endif

						                <td>
						                	<a href="{{route('admin.tentang.edit', [$data->slug])}}"><button id="edit" class="btn btn-info">Edit</button></a> 
						                	@if($data->status == 0)
						                	<a href="{{route('admin.tentang.active', [$data->slug])}}"><button id="aktif" class="btn btn-danger">Aktif-kan</button></a>
						                	@else
						                	<a href="{{route('admin.tentang.nonactive', [$data->slug])}}"><button id="nonaktif" class="btn btn-danger">Nonaktif-kan</button></a>
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
	</div>
	@endforeach
</div>
@endsection