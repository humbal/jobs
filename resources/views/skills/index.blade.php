@extends('layouts.app')
@section('title', 'Jobs Skills')
@section('content')

<div class="row">
    <h2 class="text-center"> Jobs Skills </h2>

    <?php $flashmsg = ['add','update','delete']; ?>
    @foreach($flashmsg as $flash)
        @if(Session::has('flash_message_'.$flash))
            <div class="alert alert-success">
                {{ Session::get('flash_message_'.$flash) }}
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            </div>
        @endif
    @endforeach
</div>

<div class="row">
    {!! Form::open(['action'=>'SkillsController@skills_add','class' => 'form-horizontal','method'=>'POST']) !!}
    <div class="form-group {{ $errors->has('skill') ? 'has-error' : '' }}">
        {!! Form::label('skill','Job Skill',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('skill',null,['id'=>'InputSkill','class'=>'form-control','placeholder'=>'Job Skill']) !!}
            {!! $errors->first('skill','<p class="alert-danger">:message</p>') !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-8 col-sm-offset-2">
            {!! Form::button('Add', array('class' => 'btn btn-primary','type' => 'submit')) !!}
            <a class="btn btn-default" href="">Cancel</a>
        </div>
    </div>

    {!! Form::close() !!}
</div>


    <table class="table">
        <thead>
        <th> Skills </th>
        </thead>

        <tbody>
            @if(!empty($skills))
                @foreach($skills as $skill)
                    <tr>
                        <td> {{ $skill-> name}}</td>
                        <td>
                            <a href='{{URL::to("/editSkill/".$skill->id)}}' ><span class="glyphicon glyphicon-edit "></span></a>
                        </td>

                        <td>
                            <a href='{{ URL::to("/deleteSkill/".$skill->id) }}' onclick="return confirm('Are you sure?')"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@stop