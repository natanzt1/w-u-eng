@extends('layouts.app_admin2')
@section('title')
SIMAK - Master Fakultas
@endsection
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Master Fakultas</li>
@endsection

@section('css')
<link href="{{asset('/assets/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Tabel Fakultas</h4>
    <div class="table-responsive m-t-40">
      <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" data-toggle="modal" data-target="#insert-modal"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah Data</button>
      
        <table id="table" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th width="30px">#</th>
              <th width="30px">ID</th>
              <th>Nama Fakultas</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($fakultases as $key => $fak)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$fak->fakultas_id}}</td>
                <td>{{$fak->nama_fakultas}}</td>
                <td>
                  <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="edit_fak({{$key+1}})"><span class="btn-label"><i class="fa fa-pencil"></i></span>Sunting</button>
                  <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="delete_fak({{$key+1}})"><span class="btn-label"><i class="fa fa-trash"></i></span>Hapus</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
    </div>
  </div>
</div>

{{-- modal insert --}}
<div id="insert-modal" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="" id="form-add-fakultas" action="{{route('fakultas.store')}}" method="post">
            @csrf
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group m-t-20 ">
                  <label for="fakultas" class="control-label">Fakultas Baru:</label>
                  
                  <input type="text" class="form-control" id="fakultas" name="nama_fakultas" required="" placeholder="-- Masukkan Nama Fakultas --" >
                  <span class="bar"></span>
              </div>
                  
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-danger waves-effect waves-light">Simpan</button>
            </div>
          </form>
        </div>
    </div>
</div>
{{-- modal insert --}}

{{-- modal edit --}}
<div id="modal-edit" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="" id="form-edit-fakultas" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-header">
              <h4 class="modal-title">Sunting Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              <div class="form-group m-t-20 ">
                  <label for="fak_id" class="control-label">ID:</label>
                  
                  <input type="text" class="form-control" id="fakultas_id_edit" name="fakultas_id" required="" readonly="">
                  <span class="bar"></span>
                  
              </div>

              <div class="form-group m-t-20 ">
                  <label for="fakultas_edit" class="control-label">Fakultas:</label>
                  
                  <input type="text" class="form-control" id="fakultas_edit" name="nama_fakultas" required="" >
                  <span class="bar"></span>
                  
              </div>
                  
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-danger waves-effect waves-light">Simpan</button>
            </div>
          </form>
        </div>
    </div>
</div>
{{-- modal edit --}}

@endsection

@section('js')
<script src="{{asset('/assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/toast-master/js/jquery.toast.js')}}"></script>
<script src="{{asset('js/toastr.js')}}"></script>
<script>
$('#table').DataTable();

function edit_fak(id){
  var id_fak = $('#table tr').eq(id).find('td').eq(1).html();
  var nama_fakultas = $('#table tr').eq(id).find('td').eq(2).html();


  $('#form-edit-fakultas').attr('action', '{{route('fakultas.index')}}' + '/' + id_fak);
  $('#fakultas_id_edit').val(id_fak);
  $('#fakultas_edit').val(nama_fakultas);
  $('#modal-edit').modal('show');

}

function delete_fak(id){
  var id_fak = $('#table tr').eq(id).find('td').eq(1).html();
  var nama_fakultas = $('#table tr').eq(id).find('td').eq(2).html();

  swal({   
      title: "Hapus "+ nama_fakultas +"?",   
      text: "Data yang sudah dihapus tidak dapat dikembalikan lagi!",   
      type: "warning",   
      showCancelButton: true, 
      cancelButtonText: 'Batal',
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, Hapus!",   
      closeOnConfirm: true 
  },function(){
      var url = '/master/fakultas/' + id_fak;
      var token = $('input[name=_token]').val();

      $.post({
          url: url,
          data: {
            _token: token,
            _method: 'DELETE'
          },
          success: function(data){
              if(data == 'sukses'){
                  swal("Sukses!", 
                      "Sukses menghapus "+ nama_fakultas, 
                      "success")
                   location.reload();
              }
          },
          error: function(){
              swal("Error", "Terjadi kesalahan sistem. Silakan hubungi pihak terkait", "error"); 
          }
      })
      }
  );
}

@if ($errors->has('fakultas'))
  insert_error();
@endif


@if ($errors->has('fakultas_edit'))
  edit_error();
  var id_fak = $('#fakultas_id_edit').val();
  $('#form-edit-fakultas').attr('action', '{{route('fakultas.index')}}' + '/' + id_fak);
@endif

@if (Session::has('insert'))
  success('Berhasil menyimpan data baru');
@endif

@if (Session::has('edit'))
  success('Berhasil menyunting data');
@endif

@if (Session::has('delete'))
  success('Berhasil menghapus data');
@endif

</script>
@endsection