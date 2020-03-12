@extends ('common.user')
@section ('content')

<h2 class="brand-header">投稿内容確認</h2>
<div class="main-wrap">
  <div class="panel panel-success">
    <div class="panel-heading">
      {{ $tagCategoryName }}の質問
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <tbody>
          <tr>
            <th class="table-column">Title</th>
            <td class="td-text">{{ $request->title }}</td>
          </tr>
          <tr>
            <th class="table-column">Question</th>
            <td class='td-text'>{{ $request->content }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="btn-bottom-wrapper">
  @if ($request->confirm === 'create')
    {!! Form::open(['route' => 'question.store', 'method' => 'POST']) !!}
  @else
    {!! Form::open(['route' => ['question.update', $id], 'method' => 'POST']) !!}
  @endif
      {!! Form::input('hidden', 'user_id', Auth::user()->id) !!}
      {!! Form::input('hidden', 'tag_category_id', $request->tag_category_id) !!}
      {!! Form::input('hidden', 'title', $request->title) !!}
      {!! Form::input('hidden', 'content', $request->content) !!}
      {!! Form::button('<i class="fa fa-check" aria-hidden="true"></i>', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection
