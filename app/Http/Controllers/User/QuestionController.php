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
    const PAGINATECOUNT = 10;

    protected $question;
    protected $comment;
    protected $tagCategory;

    public function __construct(Question $question, Comment $comment, TagCategory $tagCategory)
    {
        $this->middleware('auth');
        $this->question = $question;
        $this->comment = $comment;
        $this->tagCategory = $tagCategory;
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
                                    ->orderBy('updated_at', 'desc')
                                    ->paginate(self::PAGINATECOUNT);
        $tagCategories = $this->tagCategory->all();
        return view('user.question.index', compact('questions', 'tagCategories'));
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
     * @param  int  $questionId
     * @return \Illuminate\View\View
     */
    public function show($questionId)
    {
        $question = $this->question->where('id', $questionId)->first();
        $questionUser = $question->user()->first();
        $tagCategoryName = $question->tagCategory()->first()->name;
        return view('user.question.show', compact('question', 'questionUser', 'tagCategoryName'));
    }

    /**
     * マイページ画面
     *
     * @param  int  $questionId
     * @return \Illuminate\View\View
     */
    public function showMypage()
    {
        $questions = $this->question->all()->where('user_id', Auth::id());
        return view('user.question.mypage', compact('questions'));
    }

    /**
     * 質問編集確認画面
     *
     * 
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @param  int  $questionId
     * @return \Illuminate\View\View
     */
    public function editConfirm(QuestionsRequest $request, $questionId)
    {
        $tagCategoryName = $this->tagCategory->all()->where('id', $request->tag_category_id)->first()->name;
        return view('user.question.confirm', compact('request', 'tagCategoryName', 'questionId'));
    }

    /**
     * 質問新規作成確認画面
     *
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @return \Illuminate\View\View
     */
    public function createConfirm(QuestionsRequest $request)
    {
        $tagCategoryName = $this->tagCategory->all()->where('id', $request->tag_category_id)->first()->name;
        return view('user.question.confirm', compact('request', 'tagCategoryName'));
    }

    /**
     * コメント新規作成
     *
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(CommentRequest $request)
    {
        $input = $request->all();
        $this->comment->fill($input)->save();
        return redirect()->route('question.index');
    }

    /**
     * 質問編集画面
     *
     * @param  int  $questionId
     * @return \Illuminate\View\View
     */
    public function edit($questionId)
    {
        $question = $this->question->all()->where('id', $questionId)->first();
        $tagCategories = $this->tagCategory->all();
        return view('user.question.edit', compact('question', 'tagCategories'));
    }

    /**
     * 質問編集のバリデーションと保存
     *
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @param  int  $questionId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionsRequest $request, $questionId)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $this->question->find($questionId)->fill($input)->save();
        return redirect()->route('question.index');
    }

    /**
     * 質問の削除
     *
     * @param  int  $questionId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($questionId)
    {
        $this->question->find($questionId)->delete();
        return redirect()->route('question.index');
    }
}
