{!! Form::open(['route'=>'inspector.index', 'method' => 'get']) !!}

<h3>Filters</h3>

<div class="form-group">
    {!! Form::text('search', Request::get('search'), array('class' => 'form-control', 'placeholder' => 'Search for...')) !!}
</div>


<hr>
<h4>Search for</h4>

<label>
    {!! Form::radio('search_type', 'character', Request::get('search_type') == 'character' or !Request::has('search_type')) !!} &nbsp; Character
</label><br>
<label>
    {!! Form::radio('search_type', 'tribe', Request::get('search_type') == 'tribe') !!} &nbsp; {{ ucfirst(GameserverApp\Helpers\SiteHelper::groupName())}}
</label>

<div id="tribeSearch" class="searchFilters @if(Request::has('search_type') and Request::get('search_type') == 'tribe') show @endif">

</div>

<div id="characterSearch" class="searchFilters @if(!Request::has('search_type') or Request::get('search_type') == 'character') show @endif">

    <hr>
    <div class="form-group">
        <h4>Gender</h4>

        <label>
            {!! Form::checkbox('gender-m', 1, Request::get('gender-m')) !!} Male
        </label>
        <br>
        <label>
            {!! Form::checkbox('gender-f', 1, Request::get('gender-f')) !!} Female
        </label>
    </div>

    <hr>

    <div class="form-group">
        <h4>{{ ucfirst(GameserverApp\Helpers\SiteHelper::groupName())}} status</h4>

        <label>
            {!! Form::checkbox('has_tribe-y', 1, Request::get('has_tribe-y')) !!} Part of {{ GameserverApp\Helpers\SiteHelper::groupName()}}
        </label>
        <br>
        <label>
            {!! Form::checkbox('has_tribe-n', 1, Request::get('has_tribe-n')) !!} Without {{ GameserverApp\Helpers\SiteHelper::groupName()}}
        </label>
    </div>

    <hr>

    <div class="form-group">
        <h4>Order results by</h4>


        <?php
        $orderBy = [
            'name' => 'Name',
            'level' => 'Level',
            'created' => 'Create date',
        ];

        if(GameserverApp\Helpers\SiteHelper::featureEnabled('player_status')) {
            $orderBy['activity'] = 'Last activity';
        }
        ?>

        {!! Form::select('order_by', $orderBy, Request::get('order_by')) !!}
        <br>

        {!! Form::select('order', [
            'asc' => 'Ascending',
            'desc' => 'Descending'
        ],
        Request::get('order')) !!}

    </div>

    @if(GameserverApp\Helpers\SiteHelper::featureEnabled('player_status'))
        <hr>

        <label>
            {!! Form::checkbox('only_online', 1, Request::get('only_online')) !!} Show online only
        </label>
    @endif

    {{--<label>--}}
        {{--{!! Form::checkbox('only_donators', 1, Request::get('only_donators')) !!} Show donators only--}}
    {{--</label>--}}

</div>

<div id="generalSearch">

    <hr>

    <div class="form-group">
        <h4>Server</h4>

        @foreach($servers as $server)

            <label>
                {!! Form::checkbox('server_' . $server->id, 1, Request::get('server_' . $server->id)) !!} {{$server->name()}}
            </label><br>

        @endforeach
    </div>

    <hr>
</div>

{!! Form::submit('GO!', array('class' => 'btn champ')) !!}

{!! Form::close() !!}