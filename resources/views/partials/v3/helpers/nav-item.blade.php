@isset($item['dropdown'])

    <?php
    $active = false;

    if(isset($item['route'])) {

        if(is_array($item['route'])) {

            $active = false;

            foreach($item['route'] as $route) {
                $active = GameserverApp\Helpers\RouteHelper::isCurrentUrl($route);

                if($active) {
                    break;
                }
            }
        } else {
            $active = GameserverApp\Helpers\RouteHelper::isCurrentUrl($item['route']);
        }
    }
    ?>

    <li class="dropdown {{ $active ? 'active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{!! $item['title'] !!} <span class="caret"></span></a>
        <ul class="dropdown-menu">

            @forelse($item['dropdown'] as $subItem)
                @isset($subItem['type'])
                    @if($subItem['type'] == 'separator')
                        <li role="separator" class="divider"></li>
                    @endif
                @else
                    <?php
                    $subActive = GameserverApp\Helpers\RouteHelper::isCurrentUrl($subItem['route']);
                    ?>
                    <li class="{{ $subActive ? 'active' : '' }}">
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
