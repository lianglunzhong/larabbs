@extends('layouts.app')
@section('title', '首页')

@section('content')
    <h1>这里是首页</h1>
    <h1>{{ config('app.url') }}</h1>
@stop