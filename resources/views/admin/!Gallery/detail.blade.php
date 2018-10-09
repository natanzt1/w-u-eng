@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')
<script>
$(document).ready(function() {
	$('#berita').DataTable();
});
</script>

<script>
$(document).ready(function() {
    $('#gallery').DataTable();
} );
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
	     var action = "/public/administrator/gallery/"+slug+"/update"; 
         $("#image_selected").attr("src", link );
	     $("#nama_gallery").val( name );
	     $('#form-modal').attr('action', action);
	});
</script>

<script>
    $(document).on("click", "#new_gallery", function () {
	     var action = "/administrator/gallery/"; 
	     $('#form-modal').attr('action', action);
	});
</script>
@endsection

{{-- @section('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css"></script>
<script src="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"></script>
@endsection --}}

@section('content')
<div class="row m-t-40">
    <div class="col-md-12">
        <h1 class="card-title">{{$datas[0]->gallery->nama}} </h1>
        <br>
</div>
<div class="card-columns el-element-overlay">
    @foreach($datas as $data)
    <div class="card" style="padding: 5px">
        <div class="el-card-item" style="padding-bottom: 0">
            <div class="el-card-avatar el-overlay-1">
                <a class="image-popup-vertical-fit" id="edit-url" href="#" data-url="{{$data->thumbnail_url}}" data-toggle="modal" data-nama="{{$data->nama_video}}" data-target="#exampleModal"> 
                    <img src="{{URL::asset($data->thumbnail_url)}}" alt="user" /> 
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form id="form-modal" action="#" method="post" enctype="multipart/form-data">
      		@csrf
            <img src="#" id="image_selected" width="100%">
      		<div class="form-group">
			    <label for="nama">Nama Konten</label>
			    <input type="text" class="form-control" id="nama_gallery" name="nama_gallery" value="">
			</div>
			<div class="form-group">
			    <label for="Thumbnail Pengumuman">Gambar Pop Up</label>
			    <input type="file" class="form-control-file" name="thumbnail[]" accept="Image/*"  multiple="multiple" id="file"/>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection