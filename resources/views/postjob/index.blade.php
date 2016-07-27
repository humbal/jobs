@extends('layouts.app')
@section('title', 'All Posted Jobs')
@section('content')
    <div class="row">
        <h2 class="text-center">Job List</h2>
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

        <div class="col-md-12">

            @forelse($jobs as $k =>  $job)
            <div class="job-wrapper">
                <div class="entry-header">
                    <h2>{{ $job->title }}</h2>
                    <p class="lead">by <a href="mailto:{{ $job->user->email }}">{{ $job->user->email }}</a></p>
                </div>
                <div class="entry-content">
                    {{ $job->description }}
                    <div class="pull-right">
                        <a href="{{ route('job-edit',$job->id) }}" ><span class="glyphicon glyphicon-edit "></span></a>
                        <a href="{{ route('job-delete',$job->id) }} " onclick="return confirm('Are you sure?')"><span class="glyphicon glyphicon-trash"></span></a>
                    </div>
                </div>
                <div class="skills">
                    <h4>Skills</h4>
                    @foreach($job->skills as $skill)
                        <span class="label label-primary">{{ $skill->name }}</span>
                    @endforeach
                </div>

            </div>
                <hr>
            @empty
                <div class="job-wrapper">
                     <h1>No records Found</h1>

                </div>
                @endforelse

        </div>

    </div>
@stop