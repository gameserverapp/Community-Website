<!DOCTYPE html>
<html>
    <head>
        <title>Be right back.</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="refresh" content="60">
        <link href="https://fonts.googleapis.com/css?family=Righteous|Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #eee;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                /*display: table-cell;*/
                /*vertical-align: middle;*/
                margin-top:60px;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            h1 {
                font-family: Righteous;
                font-size:50px;
                color:#FF4B3E;
                margin: 0 0 90px;
            }

            h3 {
                font-weight: 100;
                font-family: 'Lato';
                font-size: 42px;
                margin:0;
                color:#FF4B3E;
            }

            .small {
                font-size: 18px;
                margin-bottom: 40px;
                color:#FF4B3E;
            }

            @media (max-width: 767px) {
                h1 {
                    font-size:50px;
                }

                h3 {
                    font-size: 32px;
                }

                .small {
                    font-size: 16px;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <h1>Be right back!</h1>
                <h3>Updating the site...</h3>
                <div class="small">Page will automatically reload when update is done (50 sec).</div>
                <div id="_giphy_tv"></div>
                <script>
                    var _giphy_tv_tag="cat";
                    var g = document.createElement('script'); g.type = 'text/javascript'; g.async = true;
                    g.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'giphy.com/static/js/widgets/tv.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(g, s);
                </script>
            </div>
        </div>
    </body>
</html>
