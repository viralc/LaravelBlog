@extends('dashboard.layouts')

@section('title') Category - Form @stop
@section('total_Blogs'){{ $total_Blogs }}@stop 
@section('total_User'){{ $total_User }}@stop 
@section('total_Cat'){{ $total_Cat }}@stop 

@section('page_title') Category @stop
@section('page_subtitle') @if ($category->exists) Editing Category: {{ $category->id }} @else Add New Category @endif @stop

@section('title')
  @parent
  Category
@stop

@section('content')

  {!! Form::open(['method' => 'post', 'route' => 'category.save', 'files'=>true]) !!}
  <div class="card">

    <div class="card-body row">
        {!! Form::hidden('id', $category->id) !!}
                <div class="form-group col-md-4 col-xs-4 col-lg-4  has-feedback {{ $errors->has('categories_name') ? 'has-error' : '' }}">
            <label>Categories</label>
            <input type="text" name="categories_name" class="form-control" value="{{ $category->categories_name ?: old('categories_name') }}">
            @if ($errors->has('categories_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('categories_name') }}</strong>
                </span>
            @endif
        </div>

    </div>

    <div class="card-footer">
      <div class="row">
        <div class="col-sm-4">
          <input type="submit" class="btn-primary btn" value="Add">
        </div>
      </div>
    </div>

  </div>
  {!! Form::close() !!}
@stop