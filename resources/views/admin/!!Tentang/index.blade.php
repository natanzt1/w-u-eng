@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=63b8cfqj2mfzb9duba83x4l6jtvn7uvcbctiwhfaa5a6krhy"></script>
<script>
$(document).ready(function() {
	$('#tentang').DataTable();
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
	     $("#nama_tentang").val( name );
	     $('#form-modal').attr('action', action);
	});
</script>

<script>
    $(document).on("click", "#new_tentang", function () {
	     var action = "/administrator/tentang/"; 
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
	    			<h1>List Profil</h1>
	    		</div>
	    	</div>
	    	<hr>
			<div class="row">
				<div class="col-md-12 col-md-offset-2">
					<table id="tentang" class="table table-striped table-bordered" style="width:100%">
						<thead>
				            <tr>
				                <th>Nama Profil</th>
				                <th>Status</th>
				                <th>Views</th>
				                <th>Aksi</th>
				            </tr>
				        </thead>
				        <tbody>
				        	@foreach($datas as $data)
				            <tr>
				                <td><a href="{{route('admin.tentang.detail',[$data->slug])}}">{{$data->nama_tentang}}</a></td>

				                @if($data->status == 0)
				                <td>Nonaktif</td>
				                @else
				                <td>Aktif</td>
				                @endif

				                <td>{{$data->views}}</td>
				                <td>
				                	<button type="button" class="btn btn-primary" id="edit-url" data-url="{{$data->icon_url}}" data-slug="{{$data->slug}}" data-toggle="modal" data-nama="{{$data->nama_tentang}}" data-target="#exampleModal" data-action="{{route('admin.tentang.update',[$data->slug,$data->id])}}">
									  Edit
									</button>
				                	@if($data->status == 0)
				                	<a href="{{route('admin.tentang.active', [$data->slug])}}"><button id="aktif" class="btn btn-info">Tampilkan di Beranda</button></a>
				                	@else
				                	<a href="{{route('admin.tentang.nonactive', [$data->slug])}}"><button id="aktif" class="btn btn-danger">Sembunyikan dari Beranda</button></a>
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
        <h5 class="modal-title" id="exampleModalLabel">Tentang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form id="form-modal" action="#" width="200px" method="post">
      		@csrf
      		<div class="form-group">
			    <label for="nama">Nama tentang</label>
			    <input type="text" class="form-control" id="nama_tentang" name="nama_tentang" value="">
			</div>
			<button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection