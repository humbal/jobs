<?php

namespace App\Http\Controllers;

use App\Job;
use App\Skill;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class JobSearchController extends Controller
{
    protected $user;
    protected $job;
    protected $skill;

    /**
     * JobSearchController constructor.
     * @param User $user
     * @param Job $job
     * @param Skill $skill
     */
    public function __construct(User $user, Job $job, Skill $skill)
    {
        $this->user = $user;
        $this->job = $job;
        $this->skill = $skill;
    }

    /**
     * @param Requests\JobSearchRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search (Request $request)
    {
        $search = $request->get('q');
        $query = Job::with('skills','user')
            ->where('status','enable')
            ->Where('title', 'like', '%' . $search . '%')
                ->orWhereHas('skills',function ($q) use ($search) {
                    $q->where(function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
                });
        $jobs = $query->paginate(20);
        return view('search.search', compact('jobs', 'search'));
    }
}
