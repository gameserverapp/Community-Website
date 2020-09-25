@isset($item['dropdown'])
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{!! $item['title'] !!} <span class="caret"></span></a>
        <ul class="dropdown-menu">

            @forelse($item['dropdown'] as $subItem)
                @isset($subItem['type'])
                    @if($subItem['type'] == 'separator')
                        <li role="separator" class="divider"></li>
                    @endif
                @else
                    <li>
                        <a href="{{$subItem['route']}}">{!! $subItem['title'] !!}</a>
                    </li>
                @endisset
            @empty

            @endforelse
        </ul>
    </li>
@else
    <?php
    $active = GameserverApp\Helpers\RouteHelper::isCurrentUrl($item['route']);
    ?>

    <li class="{{ $active ? 'active' : '' }}">
        <a href="{{$item['route']}}">{!! $item['title'] !!}@if($active)<span class="sr-only">(current)</span>@endif</a>
    </li>
@endisset
