@extends('dashboard.layouts')

@section('title') Blog - Index @stop

@section('total_Blogs'){{ $total_Blogs }}@stop 
@section('total_User'){{ $total_User }}@stop 
@section('total_Cat'){{ $total_Cat }}@stop 

@section('page_title') Blog @stop
@section('page_subtitle') Index @stop
@section('page_icon') <i class="icon-folder"></i> @stop

@section('summernote')
    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <div class="card">

        <div class="card-header">
            <a href="{{ route('blog.new') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;New</a>
            <div class="btn-group float-right">
                @if(count(Request::input()))
                    <a class="btn btn-default" href="{{ route('blog.index') }}">Clear</a>
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
                            <td>Title</td>
<td>Body</td>

                            <th>Actions</th>
                        </tr>
                    </thead>
                    @foreach($blogsData as $blogItem)
                    <tr>
                        <td> {{ $blogItem->blogs_title }}<td> {!! $blogItem->blogs_body !!}
                        <th>
                            @if(!$blogItem->deleted_at)
                                <a href="{{ route('blog.form', $blogItem->id) }}" class="btn btn-primary btn-xs">Edit</a>
                                <a href="#" class="btn btn-xs btn-warning" data-target="#deleteModal{{ $blogItem->id }}" data-toggle="modal" >Delete</a>


                                <!-- modal starts -->
                                <div class="modal fade" id="deleteModal{{ $blogItem->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            {!! Form::open(['class' => 'form-horizontal', 'method' => 'post', 'route' => ['blog.delete', $blogItem->id]]) !!}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"> Delete: {{ $blogItem->id }} </h4>
                                            </div>
                            
                                            <div class="modal-body">
                                                Are you sure you want to delete <code>{{ $blogItem->id }} ?</code>
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

                                <a href="#" class="btn btn-xs btn-success" data-target="#restoreModal{{ $blogItem->id }}" data-toggle="modal" >Restore</a>
                                <a href="#" class="btn btn-xs btn-danger" data-target="#forceDeleteModal{{ $blogItem->id }}" data-toggle="modal" >Permanently Delete</a>


                                <!-- modal starts -->
                                <div class="modal fade" id="restoreModal{{ $blogItem->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            {!! Form::open(['class' => 'form-horizontal', 'method' => 'post', 'route' => ['blog.restore', $blogItem->id]]) !!}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"> Restore: {{ $blogItem->id }} </h4>
                                            </div>
                            
                                            <div class="modal-body">
                                                Are you sure you want to RESTORE <code>{{ $blogItem->id }} ?</code>
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
                                <div class="modal fade" id="forceDeleteModal{{ $blogItem->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            {!! Form::open(['class' => 'form-horizontal', 'method' => 'post', 'route' => ['blog.force-delete', $blogItem->id]]) !!}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"> Permanently: {{ $blogItem->id }} </h4>
                                            </div>
                            
                                            <div class="modal-body">
                                                Are you sure you want to PERMANENTLY DELTE <code>{{ $blogItem->id }} ? Please note that this action cannot be reversed!</code>
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
            {!! $blogsData->links() !!}
        </div>
    </div>
    <script type="text/javascript">// <![CDATA[
    $(function(){
      $("td").each(function(i){
        len=$(this).text().length;
        if(len>80)
        {
          $(this).text($(this).text().substr(0,80)+'...');
        }
      });
    });
    // ]]></script>
    @section('modals')
    @parent
    <!-- blog search modal -->
    <div class="modal fade" id="searchModal">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['class' => 'form-horizontal', 'method' => 'get', 'route' => 'blog.index']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Search blogs</h4>
                </div>

                <div class="modal-body">                  
                    <div class="form-group">
					    {!! Form::label('Title', 'title', ['class' => 'col-sm-3']) !!}
					    <div class="col-sm-9">
					        {!! Form::text('blogs_title', Request::get('blogs_title'), ['class' => 'form-control']) !!}
					    </div>
					</div>
                    <div class="form-group">
					    {!! Form::label('Body', 'body', ['class' => 'col-sm-3']) !!}
					    <div class="col-sm-9">
					        {!! Form::text('blogs_body', Request::get('blogs_body'), ['class' => 'form-control']) !!}
					    </div>
					</div> 
                    <div class="form-group">
                        <label class="col-sm-3" for="exampleFormControlSelect1">Categories select</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="exampleFormControlSelect1">
                            <option value=""></option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{$cat->categories_name}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('Date start', 'Date start', ['class' => 'col-sm-3']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('start_date', Request::get('start_date'), ['class' => 'form-control', 'id' => 'datepicker']) !!}
                        </div>
                    </div> 

                    <div class="form-group">
                        {!! Form::label('Date End', 'Date End', ['class' => 'col-sm-3']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('end_date', Request::get('end_date'), ['class' => 'form-control', 'id' => 'datepickere']) !!}
                        </div>
                    </div> 

                    <script>
                        $('#datepicker').datepicker({
                            uiLibrary: 'bootstrap4'
                        });
                        $('#datepickere').datepicker({
                            uiLibrary: 'bootstrap4'
                        });

                    </script>                                     
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