@extends('layouts.app')

@section('content')

    <h1>タスク新規作成ページ</h1>
    
    {!! Form::model($tasklist, ['route' => 'tasklists.store']) !!}

        {!! Form::label('status','ステータス:') !!}
        {!! Form::text('status') !!}
        
        {!! Form::label('content','タスク:') !!}
        {!! Form::text('content') !!}
        
        {!! Form::submit('登録') !!}
        
    {!! Form::close() !!}

@endsection