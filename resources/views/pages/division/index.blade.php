@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-small mb-1">
                <div class="card-header border-bottom pb-1 pt-2">
                    @include('components.tools-filter', ['table_id' => '#main-table'])
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            {{ Form::open(['id' => 'form-filter', 'autocomplete' => 'off']) }}
                            <div class="form-row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">{{ __('Nama') }}</label>
                                        <input type="text" class="form-control form-control-sm filter-select"
                                            name="name" id="name" placeholder="Nama">
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-body">
                    @include('components.datatables', [
                        'id' => 'main-table',
                        'form_filter' => '#form-filter',
                        'header' => ['No', 'Nama'],
                        'data_source' => route($module . '.data'),
                        'delete_action' => route($module . '.destroys'),
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script type="text/javascript">
        var oTable = $('#main-table').myDataTable({
            buttons: [{
                id: 'add',
                className: 'btn btn-primary btn-sm',
                url: '{{ route($module . '.create') }}'
            }],
            actions: [{
                    id: 'edit',
                    className: 'btn btn-light btn-sm',
                    url: '{{ route($module . '.edit', ['__grid_doc__']) }}'
                },
                {
                    id: 'delete',
                    className: 'btn btn-danger btn-sm btn-delete',
                    url: '{{ route($module . '.destroy', ['id' => '__grid_doc__']) }}'
                }
            ],
            columns: [{
                    data: 'checkbox',
                    width: '30px',
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    width: '50px',
                    className: 'text-center'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'action',
                    className: 'text-center',
                    width: '150px',
                }
            ],
            onDraw: function() {
                initModalAjax('[data-toggle="modal-edit"]');
                initDatatableAction($(this), function() {
                    oTable.reload();
                });
            },
            onComplete: function() {
                initModalAjax();
            },
        });
    </script>
    <script type="text/javascript">
        $(function() {
            initPage();
            initDatatableTools($('#main-table'), oTable);
        })
    </script>
@endpush
