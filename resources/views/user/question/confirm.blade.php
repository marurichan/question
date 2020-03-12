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
      {{ csrf_field() }}
      <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
      <input name="tag_category_id" type="hidden" value="{{ $request->tag_category_id }}">
      <input name="title" type="hidden" value="{{ $request->title }}">
      <input name="content" type="hidden" value="{{ $request->content }}">
      <button type="submit" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>
    {!! Form::close() !!}
  </div>
</div>

@endsection

