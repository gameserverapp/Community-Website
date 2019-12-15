@extends('layouts.v2.builder', [
    'page' => [
        'title' => $title,
        'description' => $meta['description'],
        'class' => $settings['class'] . ' pagebuilder'
    ],
])

@section('page_content')
    @if(isset($content) and count($content))
        @foreach($content as $row)
            @php
            if(isset($row['settings']['row_template'])) {
                $rowTemplate = $row['settings']['row_template'];
            } else {
                $rowTemplate = 'row';
            }
            @endphp

            @include('pages.v1.page.rows.' . $rowTemplate)
        @endforeach

        @if(
            auth()->check() and !auth()->user()->acceptedRules() and
            isset($settings['rules']) and $settings['rules']
        )
            @include('pages.v1.page.partials.rulegate-form')
        @endif
    @endif
@stop