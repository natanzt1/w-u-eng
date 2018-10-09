@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
$(document).ready(function() {
	$('#gallery').DataTable();
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
    $(document).on("click", "#show", function () {
	     var link = "/"+$(this).data('url');
	     $("#image_selected").attr("src", link );
	});
</script>

<script>
    $(document).on("click", "#delete", function () {
         var id = "/"+$(this).data('id');
         var slug = $(this).data('slug');
         var action = "/administrator/gallery/"+slug+"/delete"+id; 
         $('#form-delete').attr('action', action);
    });
</script>

<script>
    $(document).on("click", "#new_gallery", function () {
         var slug = $(this).data('slug');
	     var action = "/administrator/gallery/"+slug; 
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
	    			<h1>Gallery {{$gallery->nama_gallery}}</h1>
	    		</div>
	    		<div class="col-md-2 col-md-offset-2">
	    			<button 
	    				type="button" class="btn btn-primary" id="new_gallery" data-toggle="modal" data-target="#tambah_foto" data-slug="{{$gallery->slug}}">
						Tambah Foto
					</button>
	    		</div>
	    	</div>
	    	<hr>
			<div class="row">
				<div class="col-md-12 col-md-offset-2">
					<table id="gallery" class="table table-striped table-bordered" style="width:100%">
                        @if($parameter == "null")
                        Data masih Kosong
                        @else
				        <thead>
				            <tr>
				                <th>Foto</th>
                                <th>Status</th>
				                <th>Aksi</th>
				            </tr>
				        </thead>
				        <tbody>
				        	@foreach($datas as $data)
				            <tr>
				                <td>
				                	<a href="{{URL::asset($data->thumbnail_url)}}" id="show" data-url="{{$data->thumbnail_url}}" data-toggle="modal" data-target="#exampleModal">
				                		<img src="{{URL::asset($data->thumbnail_url)}}" width="128">
				                	</a>
				                </td>
                                <td>
                                    @if($data->status == 1)
                                    Thumbnail
                                    @else
                                    <a href="{{route('admin.gallery.thumbnail', [$data->gallery->slug, $data->id])}}"><button id="aktif" class="btn btn-primary">Jadikan Thumbnail</button></a>
                                    @endif
                                </td>
				                <td>
				                	<button type="button" class="btn btn-danger" id="delete" data-id="{{$data->id}}" data-slug="{{$gallery->slug}}" data-toggle="modal" data-target="#deleteModal">
									  Hapus
									</button>
				                </td>
				            </tr>
				            @endforeach
				        </tbody>
                        @endif
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
      <div class="modal-body">
  		<img src="#" id="image_selected" width="100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        Anda yakin ingin menghapus foto ini?
      </div>
      <div class="modal-footer">
        <form action="#" method="post" id="form-delete">
            @csrf
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>    
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tambah_foto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Foto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-modal" action="#" width="200px" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="Thumbnail Pengumuman">Pilih Foto</label>
                <input type="file" class="form-control-file" accept="Image/*" name="thumbnail" id="file" />
            </div>
            <div id="thumbnail-preview" class="col-md-12">
                
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection