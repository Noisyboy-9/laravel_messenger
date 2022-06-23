<?php

namespace App\Http\Controllers;

use App\Http\Requests\SecurityQuestions\SecurityQuestionCreateRequest;
use App\Http\Requests\SecurityQuestions\SecurityQuestionUpdateRequest;
use App\Models\SecurityQuestion;

class SecurityQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index()
    {
        return inertia("SecurityQuestions/index", [
            "questions" => SecurityQuestion::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SecurityQuestionCreateRequest $request)
    {
        SecurityQuestion::create($request->all());

        return redirect()->route("security_questions.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create()
    {
        return inertia("SecurityQuestions/create");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\SecurityQuestion $question
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function show(SecurityQuestion $question)
    {
        return inertia("SecurityQuestions/show", [
            "question" => $question
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(SecurityQuestion $question)
    {
        return inertia("SecurityQuestions/edit", [
            "question" => $question
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $question
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SecurityQuestionUpdateRequest $request, SecurityQuestion $question)
    {
        $question->update($request->all());
        return redirect()->route("security_questions.edit", $question->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $question
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SecurityQuestion $question)
    {
        $question->delete();
        return redirect()->back();
    }
}
