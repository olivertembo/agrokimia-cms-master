@extends('layouts._layout')
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tipe Promo</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                <a href="{{route('list-tipe-promo')}}"><li class="breadcrumb-item"><a href="{{ route('list-tipe-promo') }}">Promo</a></li></a>
                    <li class="breadcrumb-item active">Tipe Promo</li>
                </ol>
            <a href="{{route('add-tipe-promo')}}">
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Tambah Tipe Promo</button>
            </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-bordered table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tipe Promo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- model hapus --}}

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vcenter">Hapus Tipe Promo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-ok">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- This is data table -->
<script src="{{URL::asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

<script>
$('#confirm-delete').on('click', '.btn-ok', function(e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //$.ajax({url: '/deletekios/' + id, type: 'POST'})
            $.post('/promo/tipe-promo/delete/' + id).then()
            $modalDiv.addClass('loading');
            setTimeout(function() {
                $modalDiv.modal('hide').removeClass('loading');
                $('#config-table').DataTable().ajax.reload();
            })
        });
    $('#confirm-delete').on('show.bs.modal', function(e) {
        var data = $(e.relatedTarget).data();
        $('.title', this).text(data.recordTitle);
        $('.btn-ok', this).data('recordId', data.recordId);
    });

    $(document).ready(function() {
        var i=0;
        var table=$('#config-table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": "{{ route('getindexTipePromo') }}",
            columnDefs: [{
                targets: [0, 1],
                className: 'mdl-data-table__cell--non-numeric'
            }],
            columns: [   
            { 
            "data": null,"sortable": false,
            render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {data: 'nama_type', name: 'nama_type'},
            {data: 'action', name: 'action'}
            ],
        });
    });
</script>
@endsection
