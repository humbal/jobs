@extends('layouts.app')
@section('title', 'Edit Job Skill')
@section('content')

<div class="row">
    <h2 class="text-center"> Edit Job Skills </h2>
</div>

<div class="row">
    {!! Form::open(['url'=>'updateSkill/'.$skill->id,'class' => 'form-horizontal','method'=>'POST']) !!}

        <div class="form-group {{ $errors->has('skill') ? 'has-error' : '' }}">
            {!! Form::label('skill','Job Skill',['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('skill',$skill->name,['id'=>'InputSkill','class'=>'form-control','placeholder'=>'Edit Job Skill']) !!}
                {!! $errors->first('skill','<p class="alert-danger">:message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-2">
                {!! Form::button('Update', array('class' => 'btn btn-primary','type' => 'submit')) !!}
                <a class="btn btn-default" href="{{ url('/skills') }}">Cancel</a>
            </div>
        </div>

    {!! Form::close() !!}
</div>

@stop