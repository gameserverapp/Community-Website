<article class="mod_list_wrapper">

    <?php
    $settings = [
        'class' => 'no-padding no-bottom-margin',
    ];

    if(isset($block['title']) and !empty($block['title'])) {
        $settings['title'] = $block['title'];
    }
    ?>

    @component('partials.v3.frame', $settings)

        <div class="mod_list">

            @if(
                !is_array($mods) or
                !count($mods)
            )
                <div class="no-mods-available">
                    <p>No mods available</p>
                </div>
            @else
                <table class="mod_list--table table striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>ID</th>
                    </tr>
                    </thead>

                    @foreach( $mods as $mod )
                        <tr>
                            <td width="80">
                                <a href="{{$mod->info->url}}" target="_blank"><img src="{{$mod->info->logo}}" width="50"></a>
                            </td>
                            <td>
                                @isset($mod->info->url)
                                    <a href="{{$mod->info->url}}" target="_blank">{{$mod->name}}</a>
                                @else
                                    {{$mod->name}}
                                @endisset
                            </td>
                            <td>

                                @isset($mod->external_id)
                                    <small>
                                        {{$mod->external_id}}
                                    </small>
                                @endisset
                            </td>
                        </tr>

                    @endforeach

                </table>
            @endif
        </div>


    @endcomponent
</article>