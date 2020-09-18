<footer class="footer container-fluid">
    <div class="container">

        <div class="row links">
            <div class="col-sm-5 mission">
                <h3 class="logo">
                    {{GameserverApp\Helpers\SiteHelper::name()}}
                </h3>
                <p>
                    {!! Markdown::convertToHtml(
                        GameserverApp\Helpers\SiteHelper::footerDescription()
                    ) !!}
                </p>
            </div>

            <div class="col-sm-7">
                <div class="row">

                    <div class="col-md-5 col-md-offset-1 col-sm-6 left">
                        {!! Markdown::convertToHtml(
                            GameserverApp\Helpers\SiteHelper::footerLinks('left')
                        ) !!}
                    </div>

                    <div class="col-md-6 col-sm-6 right">
                        {!! Markdown::convertToHtml(
                            GameserverApp\Helpers\SiteHelper::footerLinks('right')
                        ) !!}
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="colofon">
        <div class="container">
            <div class="row">

                <div class="col-md-12 content">
                    <span>&copy; GameServerApp.com 2015 - {{date('Y')}}</span>
                    <i>//</i>
                    <a href="http://steampowered.com/" target="_blank" rel="nofollow">Powered by Steam Login</a>
                    <i>//</i>
                    <a href="https://www.gameserverapp.com/?camp=fe&grp={{GameserverApp\Helpers\SiteHelper::slug()}}" target="_blank" rel="FOLLOW">Free game server website</a>

                    @if(config('app.debug'))
                        <span>
                            <form style="display:inline-block" method="post" action="{{route('user.switch-theme')}}">
                                {{csrf_field()}}
                                <?php
                                $overrideCookie = 0;
                                if(Cookie::has('override_theme')) {
                                    $overrideCookie = Cookie::get('override_theme');
                                }
                                ?>

                                <select name="theme" onchange="submit();">
                                    <option @if($overrideCookie === '0') selected @endif value="0">- Inherit from settings -</option>

                                    @foreach(themes() as $dir)
                                        <option  @if($overrideCookie === $dir) selected @endif value="{{$dir}}">{{$dir}}</option>
                                    @endforeach
                                </select>
                            </form>

                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

</footer>

<script async src="https://use.fontawesome.com/e8189963c5.js"></script>
<script type="text/javascript" src="{{ mix('js/bundle.js') }}"></script>

@if(config('app.env') == 'local')
    <script src="http://localhost:35729/livereload.js"></script>
@endif
