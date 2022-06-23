<?php

namespace App\Http\Controllers;

use App\Http\Requests\SecurityQuestionAnswers\SecurityQuestionAnswerInsertRequest;
use App\Http\Requests\SecurityQuestionAnswers\SecurityQuestionAnswerUpdateRequest;
use App\Models\SecurityQuestionAnswer;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;
use function request;

class SecurityQuestionAnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(): Response|ResponseFactory
    {
        $questions = SecurityQuestionAnswer::where(['user_id' => auth()->id()])->get();
        $questionWithAnswers = $questions->loadMissing('question')->toArray();
        return inertia('SecurityQuestionsAnswers/index', [
            "answers" => $questionWithAnswers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\SecurityQuestionAnswers\SecurityQuestionAnswerInsertRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function store(SecurityQuestionAnswerInsertRequest $request): RedirectResponse
    {
        SecurityQuestionAnswer::create([
            "user_id" => auth()->id(),
            "question_id" => request()->get("question_id"),
            "answer" => request()->get("answer"),
        ]);
        return redirect()->route('security_questions_answers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create(): Response|ResponseFactory
    {
        return inertia('SecurityQuestionsAnswers/create', [
            "questions" => request()->user()->securityQuestions()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(SecurityQuestionAnswer $securityQuestionsAnswer): Response|ResponseFactory
    {
        return inertia('SecurityQuestionsAnswers/edit', [
            "answer" => $securityQuestionsAnswer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SecurityQuestionAnswerUpdateRequest $request, SecurityQuestionAnswer $securityQuestionsAnswer): RedirectResponse
    {
        $securityQuestionsAnswer->update($request->all());
        return redirect()->route('security_questions_answers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SecurityQuestionAnswer $securityQuestionsAnswer): RedirectResponse
    {
        $securityQuestionsAnswer->delete();
        return redirect()->route('security_questions_answers.index');
    }
}
