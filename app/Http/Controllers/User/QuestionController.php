<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\QuestionsRequest;
use App\Http\Requests\User\CommentRequest;
use App\Models\Question;
use App\Models\Comment;
use App\Models\TagCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    protected $question;
    protected $comment;
    protected $tagCategory;
    protected $user;
    const paginateCount = 10;

    public function __construct(Question $question, Comment $comment, TagCategory $tagCategory, User $user)
    {
        $this->middleware('auth');
        $this->question = $question;
        $this->comment = $comment;
        $this->tagCategory = $tagCategory;
        $this->user = $user;
    }

    /**
     * 質問掲示板一覧画面
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $searchCategory = $request->input('tag_category_id');
        $searchWord = $request->input('search_word');
        $questions = $this->question->where('tag_category_id', 'LIKE', $searchCategory)
                                    ->where('title', 'LIKE', '%' . $searchWord . '%')
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(self::paginateCount);
        $tagCategories = $this->tagCategory->all();
        $users = $this->user->all();
        $comments = $this->comment->all();
        return view('user.question.index', compact('questions', 'tagCategories', 'users', 'comments'));
    }

    /**
     * 新規作成画面
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tagCategories = $this->tagCategory->all();
        return view('user.question.create', compact('tagCategories'));
    }

    /**
     * 新規作成のバリデーションと保存
     *
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionsRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $this->question->fill($input)->save();
        return redirect()->route('question.index');
    }

    /**
     * 質問詳細画面
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $question = $this->question->where('id', $id)->first();
        $users = $this->user->all();
        $tagCategoryName = $this->tagCategory->where('id', $question->tag_category_id)->first()->name;
        $comments = $this->comment->all()->where('question_id', $question->id);
        return view('user.question.show', compact('question', 'users', 'tagCategoryName', 'comments'));
    }

    /**
     * マイページ画面
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function mypage($id)
    {
        $questions = $this->question->all()->where('user_id', $id);
        $tagCategories = $this->tagCategory->all();
        return view('user.question.mypage', compact('questions', 'tagCategories'));
    }

    /**
     * 質問編集確認画面
     *
     * 
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function editConfirm(QuestionsRequest $request, $id)
    {
        $tagCategoryName = $this->tagCategory->where('id', $request->tag_category_id)->first()->name;
        return view('user.question.confirm', compact('request', 'tagCategoryName', 'id'));
    }

    /**
     * 質問新規作成確認画面
     *
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @return \Illuminate\View\View
     */
    public function createConfirm(QuestionsRequest $request)
    {
        $tagCategoryName = $this->tagCategory->where('id', $request->tag_category_id)->first()->name;
        return view('user.question.confirm', compact('request', 'tagCategoryName'));
    }

    /**
     * コメント新規作成
     *
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(CommentRequest $request, $id)
    {
        $input = $request->all();
        $this->comment->fill($input)->save();
        return redirect()->route('question.index');
    }

    /**
     * 質問編集画面
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $question = $this->question->all()->where('id', $id)->first();
        $tagCategories = $this->tagCategory->all();
        return view('user.question.edit', compact('question', 'tagCategories'));
    }

    /**
     * 質問編集のバリデーションと保存
     *
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionsRequest $request, $id)
    {
        $input = $request->all();
        $this->question->find($id)->fill($input)->save();
        return redirect()->route('question.index');
    }

    /**
     * 質問の削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->question->find($id)->delete();
        return redirect()->route('question.index');
    }
}
