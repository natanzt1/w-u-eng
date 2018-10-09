@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')
<script>
$(document).ready(function() {
	$('#berita').DataTable({
		"aaSorting": []
	});
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
					<h1 class="card-title">List Berita</h1>
				</div>
				<div class="col-md-2 col-md-offset-2">
					<a href="{{route('admin.berita.create')}}"><button id="create" class="btn btn-info"><i class="mdi mdi-plus-box-outline"> Tambah</i></button></a> 
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12 col-md-offset-2">
					<table id="berita" class="table full-color-table full-inverse-table hover-table" style="width:100%">
				        <thead>
				            <tr class="bg-info">
								<th width="250">Judul</th>
								<th>Penulis</th>
								<th>Tanggal Rilis</th>
								<th>Views</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($datas as $i=>$data)
							<tr>
								<td>{{$data->nama_berita}}</td>
								<td>{{$data->user_nama}}</td>
								<td>{{date('Y-m-d (h:i)', strtotime($data->tgl_rilis)) }}</td>
								<td>{{$data->views}}</td>
								@if($data->status == 0)
								<td><a href="{{route('admin.berita.active', [$data->slug])}}"><button id="aktif" class="btn btn-danger">Nonaktif</button></a></td>

								@elseif($data->status == 1)
								<td>
									<a href="{{route('admin.berita.nonactive', [$data->slug])}}"><button id="nonaktif" class="btn btn-primary">Aktif</button></a>
									<a href="{{route('admin.berita.thumbnail', [$data->slug])}}"><button id="thumbnail" class="btn btn-info">Jadikan Headline</button></a>
								</td>

								@else
								<td><a href="{{route('admin.berita.nonthumbnail', [$data->slug])}}"><button id="nonaktif" class="btn btn-info">Berita Headline</button></a></td>
								@endif
	
								<td>
									<a href="{{route('admin.berita.edit', [$data->slug])}}"><button id="edit" class=" d-inline btn btn-info"><i class="mdi mdi-pencil"></i></button></a>
									<form method="post" action="{{route('admin.berita.delete', [$data->slug])}}" class="d-inline">
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
										        <p class="text-secondary">Apakah Anda yakin ingin menghapus data ini?</p>
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