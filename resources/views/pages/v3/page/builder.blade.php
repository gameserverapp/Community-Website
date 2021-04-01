@extends('layouts.v3.full-width', [
    'page' => [
        'title' => $title,
        'description' => $meta['description'],
        'class' => 'pagebuilder ' . $meta['class']
    ],
])

@section('page_content')
    @if(isset($content) and count($content))

        @if(
            auth()->check() and !auth()->user()->acceptedRules() and
            isset($settings['rules']) and $settings['rules']
        )
            @include('pages.v3.page._rulegate', ['top' => true])
        @endif

        @foreach($content as $row)
            @php
            if(isset($row['settings']['row_template'])) {
                $rowTemplate = $row['settings']['row_template'];
            } else {
                $rowTemplate = 'row';
            }
            @endphp

            @include('pagebuilder.v1.rows.' . $rowTemplate)
        @endforeach

        @if(
            auth()->check() and !auth()->user()->acceptedRules() and
            isset($settings['rules']) and $settings['rules']
        )
            @include('pages.v3.page._rulegate', ['bottom' => true])
        @endif
    @endif
@stop