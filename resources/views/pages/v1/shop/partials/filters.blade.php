{!! Form::open(['route'=>'page.inspector', 'method' => 'get']) !!}


<h3>Filters</h3>

<div class="form-group">
    {!! Form::text('search', Request::get('search'), array('class' => 'form-control', 'placeholder' => 'Search for...')) !!}
</div>

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
    <h4>Server</h4>

    @foreach($servers as $server)

        <label>
            {!! Form::checkbox('server_' . $server->name, 1, Request::get('server_' . $server->name)) !!} {{$server->name}}
        </label><br>

    @endforeach
</div>

<hr>

<div class="form-group">
    <h4>Order results by</h4>

    {!! Form::select('order_by', [
        'name' => 'Name',
        'level' => 'Level',
        'activity' => 'Last activity',
        'created' => 'Create date',
    ],
    Request::get('order_by')) !!}
    <br>


    {!! Form::select('order', [
        'asc' => 'Ascending',
        'desc' => 'Descending'
    ],
    Request::get('order')) !!}

    <br><br>

    <label>
        {!! Form::checkbox('only_online', 1, Request::get('only_online')) !!} Show online only
    </label>
</div>

<hr>

{!! Form::submit('GO!', array('class' => 'btn champ')) !!}

{!! Form::close() !!}