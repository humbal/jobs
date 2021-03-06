@extends('layouts.app')
@section('title', 'Edit Job')
@section('content')
    <div class="row">
        <h2 class="text-center">Edit Job</h2>
        <div class="col-sm-10 col-sm-offset-2">
            @if (Session::has('success'))
                <ul class="alert alert-success">
                    <li>{!! session('success') !!}</li>
                </ul>
            @endif
        </div>

        @if($errors->any())
            <div class="col-sm-10 col-sm-offset-2">
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>



    <div class="row">
        {!! Form::open(['route' => ['update-job',$job->id],'class' => 'form-horizontal', 'role' => 'form' ]) !!}

        <div class="form-group">
            {!! Form::label('title', 'Job Title', array('class'=>'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('title', $job->title, array('id' => 'title', 'class' => 'form-control', 'placeholder'   => 'Job Title','value' => '','required' => 'required')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Job Description', array('class'=>'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::textarea('description', $job->description, array('id' => 'description', 'class' => 'form-control', 'placeholder'   => 'Job Description', 'value' => '','required' => 'required',)) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('skills', 'Job Skills', array('class'=>'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                @foreach($skills as $skill)
                        <label class="checkbox-inline">  {!! Form::checkbox('skill_id[]',$skill->id, (in_array($skill->id, $associate_skill)) ? true : false) !!} {!! $skill->name !!}</label>

                @endforeach

                <span class="help-block m-b-none">Enter Your Job Skills. Eg: laravel, wordpress, mysql, git</span>
            </div>
        </div>

        @if(Auth::user()->is_admin = 1);
        <div class="form-group">
            {!! Form::label('Status', 'Status', array('class'=>'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                    <label class="checkbox-inline">
                        Enable{!!  Form::radio('status', 'enable', ($job->status == 'enable') ? true : false) !!}
                        Disable {!!  Form::radio('status', 'disable', ($job->status == 'disable') ? true : false) !!}
            </div>
        </div>
        @endif;

        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-2">
                {!! Form::button('Update', array('class' => 'btn btn-primary','type' => 'submit')) !!}
                <a class="btn btn-default" href="">Cancel</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@stop
