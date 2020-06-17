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

                {{--<span class="paypal">--}}
                    {{--<a href="{{route('token.index')}}">--}}
                        {{--Donate via--}}
                        {{--<img src="/img/other/PP_logo_h_200x51.png" width="100">--}}
                    {{--</a>--}}
                {{--</span>--}}
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
                    <span>&copy; GameserverApp.com 2015 - {{date('Y')}}</span> &nbsp; <i>//</i> &nbsp;
                    <a href="http://steampowered.com/" target="_blank" rel="nofollow">Powered by Steam Login</a>

                    &nbsp; <i>//</i> &nbsp;
                    <a style="color:#ccc" href="https://www.gameserverapp.com/?camp=fe&grp=fo" target="_blank" rel="FOLLOW">Free gameserver website</a>



                    @if(config('app.debug'))
                        &nbsp;
                        <span>
                            <form style="display:inline-block" method="post" action="{{route('user.switch-theme')}}">
                                {{csrf_field()}}
                                <?php
                                $themePath = base_path('resources/assets/sass/v2/layout/themes');
                                $dirs = scandir($themePath);

                                $dirs = array_filter($dirs, function($item) {
                                    return !in_array($item, ['.', '..', 'index.scss']);
                                });

                                $overrideCookie = 0;
                                if(Cookie::has('override_theme')) {
                                    $overrideCookie = Cookie::get('override_theme');
                                }
                                ?>

                                <select name="theme" onchange="submit();">
                                    <option @if($overrideCookie === '0') selected @endif value="0">- Inherit from settings -</option>

                                    @foreach($dirs as $dir)
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
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
