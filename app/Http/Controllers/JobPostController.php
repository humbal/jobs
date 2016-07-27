<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Requests\JobPostRequest;
use App\Skill;
use App\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class JobPostController extends Controller
{



    public function _construct(){


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Job $job, Skill $skill)
    {
//        $jobs = $job->with('user','skills')->get();
        if(Auth::user()->is_admin == 1){
            $jobs = $job->with('user','skills')->get();
        }else{
            $jobs = Auth::user()->jobs;
        }
        return view('postjob.index',compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $skills = Skill::all();
        return view('postjob.create',compact('skills'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobPostRequest $request, Job $job)
    {
        $inputs = $request->all();
        $inputs['user_id'] = Auth::user()->id;
        $inputs['status'] = (Auth::user()->is_admin == 1) ? 1 : 0;
        $records = $job->create($inputs);
        $records->skills()->attach($request->get('skill_id'));
        Session::flash('success','Your Job is Successfully posted. ');
        return redirect('jobpost/index');

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
    public function edit($id, Job $job , Skill $skill)
    {
        $skills = Skill::all();
        $job = $job->with('user','skills')->where('id', $id)->first();
        $associate_skill = $job->skills->pluck('id')->toArray();
        if(!$job){
            return redirect()->route('home')->with('error', 'Sorry Please check your auth code! Or the job doesnot exists!!');
        }
        return view('postjob.edit', compact('job','skills', 'associate_skill'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobPostRequest $request, $id, Job $job, Skill $skill)
    {
        //
        $inputs = $request->all();

        $job = $job->findOrFail($id);
        $records = $job->update($inputs);
        $job->skills()->sync($request->get('skill_id'));
        Session::flash('success','Your Job is Successfully Updated. ');
        return redirect('jobpost/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Job $job, Skill $skill)
    {
        //
        $job = $job->findOrFail($id);
        $job->destroy($id);
        Session::flash('success','Your Job is Successfully Deleted. ');
        return redirect('jobpost/index');
    }
}
