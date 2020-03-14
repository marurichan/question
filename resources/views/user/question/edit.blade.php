@extends ('common.user')
@section ('content')

<h1 class="brand-header">質問編集</h1>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => ['question.editConfirm', $question->id], 'method' => 'POST']) !!}
      <div class="form-group @if ($errors->has('tag_category_id')) has-error @endif">
        {!! Form::select(
          'tag_category_id',
          [$question->tag_category_id => $question->tagCategory->name] + array_pluck($tagCategories, 'name', 'id'),
          old('tag_category_id'),
          ['class' => 'form-control selectpicker form-size-small', 'id' => 'tag_categry_id']
        ) !!}
        <span class="help-block">{{ $errors->first('tag_category_id') }}</span>
      </div>
      <div class="form-group @if ($errors->has('title')) has-error @endif">
        {!! Form::input('text', 'title', $question->title, ['class' => 'form-control', 'placeholder' => 'title']) !!}
        <span class="help-block">{{ $errors->first('title') }}</span>
      </div>
      <div class="form-group @if ($errors->has('content')) has-error @endif">
        {!! Form::textarea('content', $question->content, ['class' => 'form-control', 'placeholder' => 'Please write down your question here...', 'cols' => '50', 'rows' => '10']) !!}
        <span class="help-block">{{ $errors->first('content') }}</span>
      </div>
      {!! Form::input('submit', 'confirm', 'update', ['class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection
