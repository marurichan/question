@extends ('common.user')
@section ('content')

<h1 class="brand-header">質問編集</h1>

<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => ['question.editConfirm', $question->id], 'method' => 'POST']) !!}
      <div class="form-group">
        <select name='tag_category_id' class = "form-control selectpicker form-size-small" id ="pref_id">
          <option value="{{ $tagCategories->where('id', $question->tag_category_id)->first()->id }}">{{ $tagCategories->where('id', $question->tag_category_id)->first()->name}}</option>
            @foreach ($tagCategories as $tagCategory)
            <option value= "{{ $tagCategory->id }}">{{ $tagCategory->name }}</option>
            @endforeach
        </select>
        <span class="help-block"></span>
      </div>
      <div class="form-group">
        {!! Form::input('text', 'title', $question->title, ['class' => 'form-control', 'placeholder' => 'title']) !!}
        <span class="help-block">{{ $errors->first('title') }}</span>
      </div>
      <div class="form-group">
        {!! Form::textarea('content', $question->content, ['class' => 'form-control', 'placeholder' => 'Please write down your question here...', 'cols' => '50', 'rows' => '10']) !!}
        <span class="help-block">{{ $errors->first('content') }}</span>
      </div>
      {!! Form::input('submit', 'confirm', 'update', ['class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection

