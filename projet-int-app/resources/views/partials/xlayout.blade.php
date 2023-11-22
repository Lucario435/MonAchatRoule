<!DOCTYPE html>
<html>
<div title="Page principale">@section('appname', 'MonAchatRoule')</div>
{{-- @section('appname', 'MonAchatRoule') --}}

<head>
    <script>
        //PARTIAL REFRESH
        let EndSessionAction = '/logout';

        class PartialRefresh {
            constructor(serviceURL, container, refreshRate, postRefreshCallback = null, params = {}) {
                this.serviceURL = serviceURL;
                this.container = container;
                this.postRefreshCallback = postRefreshCallback;
                this.refreshRate = refreshRate * 1000;
                this.paused = false;
                this.params = params;
                this.refresh(true);
                setInterval(() => {
                    this.refresh()
                }, this.refreshRate);
            }
            static setEndSessionAction(action) {
                EndSessionAction = action;
            }
            pause() {
                this.paused = true
            }

            restart() {
                this.paused = false
            }

            replaceContent(htmlContent) {
                if (htmlContent !== "") {
                    if (this.params.lastContent) {
                        if (this.lasthtml != null) {
                            if (this.lasthtml == htmlContent) {
                                return;
                            } else {
                                this.lasthtml = htmlContent;
                            }
                        } else {
                            this.lasthtml = htmlContent;
                        }
                    }
                    $("#" + this.container).html(htmlContent);
                    if (this.postRefreshCallback != null) this.postRefreshCallback();
                }
            }

            static redirectToEndSessionAction() {
                console.log(this.EndSessionAction)
                window.location = this.EndSessionAction;
            }

            refresh(forced = false) {
                if (!this.paused) {
                    $.ajax({
                        url: this.serviceURL + (forced ? (this.serviceURL.indexOf("?") > -1 ? "&" : "?") +
                            "forceRefresh=true" : ""),
                        dataType: "html",
                        success: (htmlContent) => {
                            this.replaceContent(htmlContent)
                        },
                        statusCode: {
                            408: function() {
                                if (EndSessionAction != "")
                                    window.location = EndSessionAction + "?xalert=Session expirée";
                                else
                                    alert("Time out occured!");
                            },
                            401: function() {
                                if (EndSessionAction != "")
                                    window.location = EndSessionAction + "?xalert=Access illégal";
                                else
                                    alert("Illegal access!");
                            },
                            403: function() {
                                if (EndSessionAction != "")
                                    window.location = EndSessionAction + "?xalert=Compte bloqué";
                                else
                                    alert("Illegal access!");
                            }
                        }
                    })
                }
            }

            command(url, moreCallBack = null) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: () => {
                        this.refresh(true);
                        if (moreCallBack != null)
                            moreCallBack();
                    }
                });
            }

            confirmedCommand(message, url, moreCallBack = null) {
                bootbox.confirm(message, (result) => {
                    if (result) this.command(url, moreCallBack)
                });
            }
        }
    </script>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('appname')</title>
    <link rel="icon" type="image/x-icon"
        href="https://media.discordapp.net/attachments/1149051976550731906/1149052038769016862/Logo-Slogan.png?width=585&height=585">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <style>
        body{
            min-width: 200px;
            min-height: 400px;
        }
    </style>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    

    {{-- <link rel="stylesheet" href="path/to/jquery.toast.min.css">
    <script src="path/to/jquery.toast.min.js"></script> --}}
    
    @vite('resources/js/app.js')
    @vite(['resources/css/app.css'])
    
    @stack('css')
    @stack('js')


</head>

<body>
    @include('partials.xheader')

    <div style="min-height:90px;"></div>
    
    <h1 id="xtitle">
        @yield('title'){{-- ici on mettra le nom de la page, doit etre défini dans le yield  --}}
    </h1>


    @yield('content')

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script deferred>
        function getQueryParam(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // XALERT momo
        const message = getQueryParam('xalert');
        // console.log(message);
        if (message) {
            Toastify({
                text: message,
                duration: 6000,
                position: "left",
                gravity: "bottom",
                style: {
                    background: "var(--blueheader);",
                },
            }).showToast();
        }
    </script>




    {{-- @include('partials.xfooter') --}}
</body>

</html>
