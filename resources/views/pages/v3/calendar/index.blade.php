@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Calendar events',
        'description' => 'Find out what is happening and what is coming up!',
        'class' => 'calendar'
    ],

    'breadcrumbs' => [
        [
            'title' => translate('calendar', 'Calendar')
        ]
    ]
])

@section('page_content')

<div class="row">
    <div class="col-md-12">
        <div class="calendar-js" style="height:1000px"></div>
    </div>
</div>

@stop