<?php

namespace App\Http\Controllers;

use App\Skill;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SkillsRequest;
use Illuminate\Support\Facades\Redirect;

use DB;

class SkillsController extends Controller
{
    public function skills_show(){
        $skills = Skill::all();
        return view('skills.index',compact('title','skills'));
    }

    public function skills_add(SkillsRequest $request){
//        dd($request->all());
        $skills = new Skill();
        $skills->name = $request->skill;
        $skills->save();

        \Session::flash('flash_message_add','New Skill Added Successfully..');
        return Redirect::back();
    }

    public function skills_edit($id){
        $skill = Skill::findOrFail($id);

        return view('skills.editSkills',compact('title','skill'));
    }

    public function skills_update(SkillsRequest $request,$id){
        $skill = Skill::findOrFail($id);

        DB::table('skills')
            ->where('id',$id)
            ->update(['name' => $request->skill]);

        \Session::flash('flash_message_update','New Skill Updated Successfully..');
        return Redirect::to('skills');
    }

    public function destroy($id){
        $skill = Skill::findOrFail($id);
        $skill->delete();

        \Session::flash('flash_message_delete','Skill Deleted Successfully..');
        return Redirect::to('skills');
    }
}
