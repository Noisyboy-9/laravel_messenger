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
        return inertia('SecurityQuestionsAnswers/index', [
            "questions" => request()->user()->questions()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create(): Response|ResponseFactory
    {
        return inertia('SecurityQuestionsAnswers/create', [
            "questions" => request()->user()->questions()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SecurityQuestionAnswerInsertRequest $request): RedirectResponse
    {
        $request->user()->questions()->insert($request->all());

        return redirect()->route('security_questions_answers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(SecurityQuestionAnswer $securityQuestionAnswer): Response|ResponseFactory
    {
        return inertia('SecurityQuestionsAnswers/index', [
            "question" => $securityQuestionAnswer->question()
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
    public function updates(SecurityQuestionAnswerUpdateRequest $request, SecurityQuestionAnswer $securityQuestionAnswer): RedirectResponse
    {
        $securityQuestionAnswer->update($request->all());
        return redirect()->route('security_questions_answers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SecurityQuestionAnswer $securityQuestionAnswer): RedirectResponse
    {
        $securityQuestionAnswer->delete();
        return redirect()->route('security_questions_answers.index');
    }
}
