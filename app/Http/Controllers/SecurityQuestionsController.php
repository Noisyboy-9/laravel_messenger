<?php

namespace App\Http\Controllers;

use App\Http\Requests\SecurityQuestions\SecurityQuestionCreateRequest;
use App\Http\Requests\SecurityQuestions\SecurityQuestionUpdateRequest;
use App\Models\SecurityQuestion;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class SecurityQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(): Response|ResponseFactory
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
    public function store(SecurityQuestionCreateRequest $request): RedirectResponse
    {
        SecurityQuestion::create($request->all());

        return redirect()->route("security_questions.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create(): Response|ResponseFactory
    {
        return inertia("SecurityQuestions/create");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(SecurityQuestion $securityQuestion): Response|ResponseFactory
    {
        return inertia("SecurityQuestions/edit", [
            "question" => [
                "id" => $securityQuestion->id,
                "title" => $securityQuestion->title
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $securityQuestion
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SecurityQuestionUpdateRequest $request, SecurityQuestion $securityQuestion): RedirectResponse
    {
        $securityQuestion->update($request->all());
        return redirect()->route("security_questions.index", $securityQuestion->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\SecurityQuestion $securityQuestion
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SecurityQuestion $securityQuestion): RedirectResponse
    {
        $securityQuestion->delete();
        return redirect()->back();
    }
}
