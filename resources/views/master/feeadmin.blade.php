@extends('layouts._layout')

@section('content')
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">List Fee Admin</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Fee Admin</a></li>
                    <li class="breadcrumb-item active">List Fee Admin</li>
                </ol>
            <a href="{{route('addfee_admin')}}">
                <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i
                        class="fa fa-plus-circle"></i> Tambah Fee Admin</button>
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
                                    <th>Tipe</th>
                                    <th>Prosentase (%)</th>
                                    <th>Jumlah (Rp)</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               <!--  @foreach ($fee_admin as $fa)
                                    <tr>
                                        <td>{{$loop->iteration }}</td>
                                        <td>@php
                                                if($fa->tipe==1){
                                                echo "Prosentase";
                                            } else {
                                                echo "Nominal";
                                            }
                                            @endphp</td>
                                        <td>{{$fa->is_precentage}}</td>
                                        <td>{{$fa->jumlah}}</td>
                                        <td>
                                            @php
                                                if($fa->status==1){
                                                echo "Aktif";
                                            } else {
                                                echo "Tidak Aktif";
                                            }
                                            @endphp
                                        </td>
                                        <td>
                                            <a href="{{ url('/master/editfee-admin/') }}/{{$fa->id}}"><button  class="btn btn-xs btn-primary "><span class="btn-label"><i class="fa fa-file"></i></span></button></a>
                                            <button class="btn btn-xs btn-danger delete-button" deletevalue="{{$fa->id}}" type="button"><span class="btn-label"><i class="fa fa-trash"></i></span></button>
                                        </td>
                                    </tr>
                                @endforeach -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="delete-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="delete-form" action="" method="post">@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vcenter">Hapus Fee Admin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info btn-danger waves-effect">Delete</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{-- modal delete monggo disesuaikan --}}
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vcenter">Hapus Fee Admin</h4>
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
{{-- akhir modal delete --}}
@endsection

@section('script')
<!-- This is data table -->
<script src="{{URL::asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{URL::asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

<script>
    $(function () {
        $('#confirm-delete').on('click', '.btn-ok', function(e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //$.ajax({url: '/deletekios/' + id, type: 'POST'})
            $.post('deletefee-admin/' + id).then()
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

        $(".delete-button").click(function(){
            var id = $(this).attr('deletevalue');
            $("#delete-form").attr('action', '../deletefee_admin/'+id);
            $('#delete-modal').modal();
        });

        $('#myTable').DataTable();
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function (settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function (group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
        // Order by the grouping
         $(document).ready(function() {
            var i=0;
            var table=$('#config-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": "{{ route('indexlist-fadmin') }}",
                columnDefs: [{
                    targets: [0, 1, 2],
                    className: 'mdl-data-table__cell--non-numeric'
                }],
                columns: [
                { 
                    "data": null,"sortable": false,
                    render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                        }
                },

                {data: 'tipe', name: 'tipe'},
                {data: 'is_precentage', name: 'is_precentage'},
                {data: 'jumlah', name: 'jumlah', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'},
                ],
            });
        });
    });
</script>
@endsection
