@extends('layouts.v3.default', [
    'page' => [
        'title' => 'About - ' . $user->name(),
        'description' => '',
        'class' => 'user-single'
    ]
])

@section('page_content')
    @include('pages.v3.user._header')

@endsection