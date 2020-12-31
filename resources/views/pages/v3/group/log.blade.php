@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Log - ' . $group->name(),
        'description' => str_limit($group->about(), 200),
        'class' => 'group-single',
        'bg' => $group->backgroundImage()
    ]
])

@section('page_content')
    @include('pages.v3.group._header')

    <div class="row">
        <div class="col-md-12">

            @if(
                auth()->check() and
                auth()->user()->isGroupMember($group) and
                !$group->discordChannelSetup()
            )
                <div class="alert alert-info">Read the logs on your group Discord server. <a href="{{route('group.settings', $group->id)}}">Setup Discord &raquo;</a></div>
                <br>
            @endif

            @component('partials.v3.frame', ['class' => 'no-padding'])
                <table class="table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Message</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>
                                    <span class="local-time" data-time="{{$log->created_at}}"></span>
                                </td>
                                <td>
                                    <span style="@isset($log->rgba_color) color:rgba({{$log->rgba_color}}) @endisset">
                                        {{$log->message}}
                                    </span>

                                    @if($log->game_date)
                                        <span class="gamedate">
                                            ({{$log->game_date}})
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">
                                    <em>No logs...</em>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            @endcomponent

        </div>

        <div class="paginate">
            {!! $logs->links() !!}
        </div>
    </div>
@stop