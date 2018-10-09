@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')

<script>
    tinymce.init({ selector:'textarea' });
</script>
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
    $(document).on("click", "#show", function () {
	     var link = "/"+$(this).data('url');
	     $("#image_selected").attr("src", link );
	});
</script>

<script>
    $(document).on("click", "#delete", function () {
         var id = "/"+$(this).data('id');
         var slug = $(this).data('slug');
         var action = "/administrator/tentang/"+slug+"/delete"+id; 
         $('#form-delete').attr('action', action);
    });
</script>

<script>
    $(document).on("click", "#new_tentang", function () {
         var slug = $(this).data('slug');
	       var action = "/administrator/tentang/"+slug; 
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
	    			<h1>Profil {{$tentang[0]->nama_tentang}}</h1>
	    		</div>
	    		<div class="col-md-2 col-md-offset-2">
	    			<button 
	    				type="button" class="btn btn-primary" id="new_tentang" data-toggle="modal" data-target="#createModal" data-slug="{{$tentang[0]->slug}}">
						Tambah Profil
					</button>
	    		</div>
	    	</div>
	    	<hr>
			<div class="row">
				<div class="col-md-12 col-md-offset-2">
					<table id="tentang" class="table table-striped table-bordered" style="width:100%">
                        @if($parameter == "null")
                        Data masih Kosong
                        @else
				        <thead>
				            <tr>
				                <th>Jenis Profil</th>
				                <th>Aksi</th>
				            </tr>
				        </thead>
				        <tbody>
				        	@foreach($datas as $data)
				            <tr>
				                <td>
				                		{{$data->nama}}
				                </td>
				                <td>
                          <a href="{{route('admin.tentang.edit',[$data->tentang->slug,$data->id])}}"><button type="button" class="btn btn-primary">
                            Edit
                          </button></a>
				                	<button type="button" class="btn btn-danger" id="delete" data-id="{{$data->id}}" data-slug="{{$tentang[0]->slug}}" data-toggle="modal" data-target="#deleteModal">
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
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tentang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-create" action="#" width="200px" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="nama">Jenis Profil</label>
            <input type="text" class="form-control" id="nama_tentang" name="nama_tentang">
          </div>
          <div class="form-group">
            <label for="nama">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" style="height: 300px;"></textarea>
          </div>
          <div class="form-group">
              <label for="Thumbnail">Thumbnail Profil</label>
              <input type="file" class="form-control-file" accept="Image/*" name="thumbnail" id="file" />
          </div>

          <div id="thumbnail-preview" class="col-md-12">
            
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

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">tentang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-edit" action="#" width="200px" method="post">
          @csrf
          <div class="form-group">
            <label for="nama">Jenis Profil</label>
            <input type="text" class="form-control" id="form_nama" name="nama_tentang" value="">
          </div>
          <div class="form-group">
            <label for="nama">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" id="form_deskripsi" style="height: 300px;"></textarea>
          </div>
          <img src="#" id="form_thumbnail">

          <div class="form-group">
              <label for="Thumbnail">Ganti Thumbnail Profil</label>
              <input type="file" class="form-control-file" accept="Image/*" name="thumbnail" id="file" />
          </div>

          <div id="thumbnail-preview" class="col-md-12">
            
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

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        Anda yakin ingin menghapus profil ini?
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

@endsection