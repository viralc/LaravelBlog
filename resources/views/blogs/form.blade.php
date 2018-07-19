@extends('dashboard.layouts')

@section('title') Blog - Form @stop

@section('page_title') Blog @stop
@section('page_subtitle') @if ($blog->exists) Editing Blog: {{ $blog->id }} @else Add New Blog @endif @stop

@section('title')
  @parent
  Blog
@stop

@section('summernote')
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ Request::root() }}/richtext.min.css">
<!-- Bootstrap core JavaScript -->
<script src="{{ Request::root() }}/vendor/jquery/jquery.min.js"></script>
<script src="{{ Request::root() }}/js/bootstrap.min.js"></script>
<script src="{{ Request::root() }}/jquery.richtext.js"></script>
@stop

@section('content')

  {!! Form::open(['method' => 'post', 'route' => 'blog.save', 'files'=>true]) !!}
  <div class="card">

    <div class="card-body row">
        {!! Form::hidden('id', $blog->id) !!}
              <div class="form-group col-md-6 col-xs-6 col-lg-6  has-feedback {{ $errors->has('user_id') ? 'has-error' : '' }}">
                <label control-label"> User <span class="required">*</span></label>
                {!! Form::select('user_id', $users, $blog->user_id, ['class' => 'form-control selectpicker', 'id' => 'user_id', 'placeholder' => 'Please select a user', 'data-live-search' => "true"]) !!}
                @if ($errors->has('user_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('user_id') }}</strong>
                  </span>
                @endif
              </div>
                <div class="form-group has-feedback col-md-8 col-xs-8 col-lg-8 {{ $errors->has('blogs_title') ? 'has-error' : '' }}">
            <label>Title</label>
            <input type="text" name="blogs_title" class="form-control" value="{{ $blog->blogs_title ?: old('blogs_title') }}">
            @if ($errors->has('blogs_title'))
                <span class="help-block">
                    <strong>{{ $errors->first('blogs_title') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group col-md-8 col-xs-8 col-lg-8  has-feedback {{ $errors->has('category_id') ? 'has-error' : '' }}">
          <label control-label"> Category <span class="required">*</span></label>
          {!! Form::select('category_id', $categories, $blog->category_id, ['class' => 'form-control selectpicker', 'id' => 'category_id', 'placeholder' => 'Please select a category', 'data-live-search' => "true"]) !!}
          @if ($errors->has('category_id'))
            <span class="help-block">
              <strong>{{ $errors->first('category_id') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group has-feedback col-xs-8 col-md-8 col-lg-8 {{ $errors->has('blogs_body') ? 'has-error' : '' }}">
            <label></label>
            <textarea name="blogs_body" id="editSectionss" class="form-control">{!! $blog->blogs_body ?: old('blogs_body') !!}</textarea>

            @if ($errors->has('blogs_body'))
                <span class="help-block">
                    <strong>{{ $errors->first('body') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="card-footer">
      <div class="row">
        <div class="col-sm-8">
          <input type="submit" class="btn-primary btn" value="Save">
        </div>
      </div>
    </div>

  </div>
  {!! Form::close() !!}

  @section('markdown')
          <script>
        $(document).ready(function() {
            $('#editSectionss').richText();
        });
        </script>
  @stop
@stop