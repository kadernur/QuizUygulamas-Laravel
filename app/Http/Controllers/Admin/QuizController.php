<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Http\Requests\QuizCreateRequest;
use App\Http\Requests\QuizUpdateRequest;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Veri Filtreleme
        $quizzes=Quiz::withCount('questions');

       if(request()->get('title')){
        $quizzes = $quizzes->where('title','LIKE', "%".request()->get('title')."%");

       }
       
       if(request()->get('status')){
        $quizzes=$quizzes->where('status',request()->get('status'));

       }
       
       $quizzes=$quizzes->paginate(5);
        return view('admin.quiz.list',compact('quizzes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.quiz.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizCreateRequest $request)
    {
         
       Quiz::create($request ->post());
       return redirect()->route('quizzes.index')->withSuccess('Quiz Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $quiz=Quiz::withCount('questions')->find($id) ?? abort(404,'Quiz not found');
        return view('admin.quiz.edit',compact('quiz'));
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
        $quiz=Quiz::find($id) ?? abort(404,'Quiz not found');
        Quiz::where('id',$id)->update($request->except(['_method','_token']));
        return redirect()->route('quizzes.index')->withSuccess('The quiz update has been successfully completed.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quiz=Quiz::find($id) ?? abort(404,'Quiz not found');
        $quiz->delete();
        return redirect()->route('quizzes.index')
        ->withSuccess('The quiz delete has been successfully completed.');

    }
}
