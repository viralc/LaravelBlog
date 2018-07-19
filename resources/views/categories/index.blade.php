@extends('dashboard.layouts')

@section('title') Category - Index @stop

@section('total_Blogs'){{ $total_Blogs }}@stop 
@section('total_User'){{ $total_User }}@stop 
@section('total_Cat'){{ $total_Cat }}@stop 

@section('page_title') Category @stop
@section('page_subtitle') Index @stop
@section('page_icon') <i class="icon-folder"></i> @stop

@section('content')
    <div class="card">

        <div class="card-header">
            <a href="{{ route('category.new') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;New</a>
            <div class="btn-group float-right">
                @if(count(Request::input()))
                    <a class="btn btn-default" href="{{ route('category.index') }}">Clear</a>
                    <a class="btn btn-primary" id="searchButton" data-toggle="modal" data-target="#searchModal">Modify Search</a>
                @else
                    <a class="btn btn-default" id="searchButton" data-toggle="modal" data-target="#searchModal"><i class="icon-search"></i>&nbsp;&nbsp;Search</a>
                @endif
            </div>
        </div>


        <div class="card-body">
            <table class="table table-striped table-hover table-bordered">
                <tbody>
                    <thead>
                        <tr>
                            <td>Name</td>

                            <th>Actions</th>
                        </tr>
                    </thead>
                    @foreach($categoriesData as $categoryItem)
                    <tr>
                        <td> {{ $categoryItem->categories_name }}
                        <th>
                            @if(!$categoryItem->deleted_at)
                                <a href="{{ route('category.form', $categoryItem->id) }}" class="btn btn-primary btn-xs">Edit</a>
                                <a href="#" class="btn btn-xs btn-warning" data-target="#deleteModal{{ $categoryItem->id }}" data-toggle="modal" >Delete</a>


                                <!-- modal starts -->
                                <div class="modal fade" id="deleteModal{{ $categoryItem->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            {!! Form::open(['class' => 'form-horizontal', 'method' => 'post', 'route' => ['category.delete', $categoryItem->id]]) !!}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"> Delete: {{ $categoryItem->id }} </h4>
                                            </div>
                            
                                            <div class="modal-body">
                                                Are you sure you want to delete <code>{{ $categoryItem->id }} ?</code>
                                            </div>
                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'data-disable-with' => trans('Deleting...')]) !!}
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                                <!-- modal ends -->

                            @else

                                <a href="#" class="btn btn-xs btn-success" data-target="#restoreModal{{ $categoryItem->id }}" data-toggle="modal" >Restore</a>
                                <a href="#" class="btn btn-xs btn-danger" data-target="#forceDeleteModal{{ $categoryItem->id }}" data-toggle="modal" >Permanently Delete</a>


                                <!-- modal starts -->
                                <div class="modal fade" id="restoreModal{{ $categoryItem->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            {!! Form::open(['class' => 'form-horizontal', 'method' => 'post', 'route' => ['category.restore', $categoryItem->id]]) !!}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"> Restore: {{ $categoryItem->id }} </h4>
                                            </div>
                            
                                            <div class="modal-body">
                                                Are you sure you want to RESTORE <code>{{ $categoryItem->id }} ?</code>
                                            </div>
                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                {!! Form::submit('Restore', ['class' => 'btn btn-primary', 'data-disable-with' => trans('Restoring...')]) !!}
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                                <!-- modal ends -->



                                <!-- modal starts -->
                                <div class="modal fade" id="forceDeleteModal{{ $categoryItem->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            {!! Form::open(['class' => 'form-horizontal', 'method' => 'post', 'route' => ['category.force-delete', $categoryItem->id]]) !!}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"> Permanently: {{ $categoryItem->id }} </h4>
                                            </div>
                            
                                            <div class="modal-body">
                                                Are you sure you want to PERMANENTLY DELTE <code>{{ $categoryItem->id }} ? Please note that this action cannot be reversed!</code>
                                            </div>
                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                {!! Form::submit('PERMANENTLY DELETE', ['class' => 'btn btn-danger', 'data-disable-with' => trans('Permanently Deleting...')]) !!}
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                                <!-- modal ends -->

                            @endif
                        </th>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {!! $categoriesData->links() !!}
        </div>
    </div>

    @section('modals')
    @parent
    <!-- category search modal -->
    <div class="modal fade" id="searchModal">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['class' => 'form-horizontal', 'method' => 'get', 'route' => 'category.index']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Search categories</h4>
                </div>

                <div class="modal-body">                  
                    <div class="form-group">
					    {!! Form::label('Name', 'name', ['class' => 'col-sm-3']) !!}
					    <div class="col-sm-9">
					        {!! Form::text('name', Request::get('name'), ['class' => 'form-control']) !!}
					    </div>
					</div>                                        
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- search modal ends -->
    @stop

@stop