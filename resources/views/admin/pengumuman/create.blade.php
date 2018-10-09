@extends('layouts.admin.app')

@section('title')
UNHI - Dashboard Administrator
@endsection

@section('js')

<script type="text/javascript">
function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#thumbnail-preview + img').remove();
            $('#thumbnail-preview').after('<img alt="Image" id="thumbnail" src="'+e.target.result+'" width="350" />');
            $('#modal_thumbnail').after('<img alt="Image" src="'+e.target.result+'" width="350" />');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#file").change(function () {
    filePreview(this);
});

$('#submit').click( function() {
	var nama = $('#nama').val();
	var kontak = $('#kontak').val();
	var website = $('#website').val();
	var konten = tinymce.get('konten').getContent() ;
	$('#modal_nama').html( nama );
	$('#modal_kontak').html( kontak );
	$('#modal_website').html( website );
	$('#modal_konten').html( konten );
	filePreview(this);
});

</script>
@endsection

@section('css')
@endsection

@section('content')
<div class="section-block center-holder">
    <div class="container">
    	<h1>Buat Pengumuman Baru</h1>
		<hr>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form action="{{route('admin.pengumuman.store')}}" method="POST" enctype="multipart/form-data">
					@csrf
				  	<div class="form-group">
					    <label for="Judul">Judul Pengumuman</label>
					    <input type="text" class="form-control" name="nama_pengumuman" id="nama" required>
					    @if(count($errors)>0)
					    	@foreach($errors->all() as $error)
					    		<small class="alert-danger">*Judul sudah dipakai atau lebih dari 200 karakter*</small>
					    	@endforeach
					    @endif
					</div>

					<div class="row">
	                    <div class="col-lg-12">
	                        <label for="event_starts">Tanggal Rilis</label>
	                        <div class="row">
	                            <div class="col-lg-7 ">
	                            	<input type="date" name="tanggal" id="date" class=" date-pick form-control" required>
	                            </div>
	                            <div class="col-lg-5 ">
	                            	<input type="time" name="waktu" id="time" value="01:59" class="form-control" required>
	                            </div>
	                        </div>
	                    </div>
	                </div>

	                <br>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
							    <label for="Judul">Kontak</label>
							    <input type="text" class="form-control" name="kontak" id="kontak" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							    <label for="Judul">Website</label>
							    <input type="text" class="form-control" name="website" id="website" required>
							</div>
						</div>
					</div>

					<div class="form-group">
					    <label for="konten">Isi Pengumuman</label>
					    <textarea class="form-control" name="konten_pengumuman" id="konten" style="height: 300px;"></textarea>
					</div>
			</div>

			<div class="col-md-4 col-md-offset-2">
				<span class="border-bottom">
					<div class="form-group">
					    <label for="Thumbnail Pengumuman">Thumbnail Pengumuman</label>
					    <input type="file" class="form-control-file" accept="Image/*" name="thumbnail" id="file" />
					</div>

					<div id="thumbnail-preview" class="col-md-12">
						
					</div>
				</span>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<button type="button" data-toggle="modal" id="submit" data-target="#create_modal" class="btn btn-primary">Submit</button>
				<!-- Modal -->
					<div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg" role="document">
					    <div class="modal-content">
						  <div class="modal-header modal-header-info">
					        <h5 class="modal-title" id="exampleModalLabel">Preview</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					      	<div class="form-group">
							    <label for="Thumbnail Pengumuman">Judul</label>
							    <h1 id="modal_nama"></h1>
							</div>

							<div class="row">
			                    <div class="col-lg-12">
			                        <label for="event_starts">Tanggal Rilis</label>
			                        <div class="row">
			                            <div class="col-lg-3 ">
			                            	<p id="modal_date"></p>
			                            </div>
			                            <div class="col-lg-5 ">
			                            	<p id="modal_time"></p>
			                            </div>
			                        </div>
			                    </div>
			                </div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
									    <label for="Judul">Kontak</label>
									    <h4 id="modal_kontak"></h4>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									    <label for="Judul">Website</label>
									    <h4 id="modal_website"></h4>
									</div>
								</div>
							</div>

							<div class="form-group">
							    <label for="konten">Isi Pengumuman</label>
							    <p id="modal_konten"></p> 
							</div>

					        <div class="form-group">
							    <label for="konten">Thumbnail</label>
							    <div id="modal_thumbnail">
							    	
							    </div>
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
				<!-- EndModal -->
				</form>
			</div>
		</div>
	</div>
</div>
@endsection