<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\QuestionsRequest;
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
    const paginateCount = 10;

    public function __construct(Question $question, Comment $comment, TagCategory $tagCategory)
    {
        $this->middleware('auth');
        $this->question = $question;
        $this->comment = $comment;
        $this->tagCategory = $tagCategory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->question->orderBy('created_at', 'desc')
                                    ->paginate(self::paginateCount);
        $tagCategories = $this->tagCategory->all();
        $users = User::all();
        $comments = $this->comment->all();
        return view('user.question.index', compact('questions', 'tagCategories', 'users', 'comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tagCategories = $this->tagCategory->all();
        return view('user.question.create', compact('tagCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionsRequest $request)
    {
        return redirect()->to('question');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->question->where('id', $id)->first();
        $user = User::all()->where('id', $question->user_id)->first();
        $category = $this->tagCategory->where('id', $question->tag_category_id)->first();
        return view('user.question.show', compact('question', 'user', 'category'));
    }

    /**
     * 
     *
     * 
     * 
     */
    public function mypage()
    {
        return view('user.question.mypage');
    }

    /**
     * 
     *
     * 
     * 
     */
    public function editConfirm()
    {
        return view('user.question.confirm');
    }

    /**
     * 
     *
     * 
     * 
     */
    public function createConfirm(QuestionsRequest $request)
    {
        $tagCategoryName = $this->tagCategory->where('id', $request->tag_category_id)->first()->name;
        return view('user.question.confirm', compact('request', 'tagCategoryName'));
    }

    /**
     * 
     *
     * 
     * 
     */
    public function comment($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('user.question.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
