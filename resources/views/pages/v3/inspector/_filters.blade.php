<h4>Search for</h4>
<label>
    <input type="radio" name="search_type" value="character" {{ (Request::get('search_type') == 'character' or !Request::has('search_type')) ? 'checked' : '' }}> &nbsp; Character
</label><br>
<label>
    <input type="radio" name="search_type" value="tribe" {{ Request::get('search_type') == 'tribe' ? 'checked' : '' }}> &nbsp; {{ ucfirst(GameserverApp\Helpers\SiteHelper::groupName())}}
</label>

<div id="tribeSearch" class="searchFilters @if(Request::has('search_type') and Request::get('search_type') == 'tribe') show @endif">

</div>

<div id="characterSearch" class="searchFilters @if(!Request::has('search_type') or Request::get('search_type') == 'character') show @endif">

    <hr>
    <div class="form-group">
        <h4>Gender</h4>

        <label>
            <input type="checkbox" name="gender-m" value="1" {{ Request::get('gender-m') ? 'checked' : '' }}> Male
        </label>
        <br>
        <label>
            <input type="checkbox" name="gender-f" value="1" {{ Request::get('gender-f') ? 'checked' : '' }}> Female
        </label>
    </div>

    <hr>

    <div class="form-group">
        <h4>{{ ucfirst(GameserverApp\Helpers\SiteHelper::groupName())}} status</h4>

        <label>
            <input type="checkbox" name="has_tribe-y" value="1" {{ Request::get('has_tribe-y') ? 'checked' : '' }}> Part of {{ GameserverApp\Helpers\SiteHelper::groupName()}}
        </label>
        <br>
        <label>
            <input type="checkbox" name="has_tribe-n" value="1" {{ Request::get('has_tribe-n') ? 'checked' : '' }}> Without {{ GameserverApp\Helpers\SiteHelper::groupName()}}
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

        <select name="order_by">
            @foreach($orderBy as $key => $val)
                <option value="{{ $key }}" {{ Request::get('order_by') == $key ? 'selected' : '' }}>{{ $val }}</option>
            @endforeach
        </select>
        <br>

        <select name="order">
            <option value="asc" {{ Request::get('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
            <option value="desc" {{ Request::get('order') == 'desc' ? 'selected' : '' }}>Descending</option>
        </select>

    </div>

    @if(GameserverApp\Helpers\SiteHelper::featureEnabled('player_status'))
        <hr>

        <label>
            <input type="checkbox" name="only_online" value="1" {{ Request::get('only_online') ? 'checked' : '' }}> Show online only
        </label>
    @endif

    {{--<label>--}}
    {{--<input type="checkbox" name="only_donators" value="1" {{ Request::get('only_donators') ? 'checked' : '' }}> Show donators only--}}
    {{--</label>--}}

</div>

<div id="generalSearch">

    <hr>

    <div class="form-group">
        <h4>Server</h4>

        @foreach($servers as $server)

            <label>
                <input type="checkbox" name="server_{{ $server->id }}" value="1" {{ Request::get('server_' . $server->id) ? 'checked' : '' }}> {{$server->name()}}
            </label><br>

        @endforeach
    </div>
</div>