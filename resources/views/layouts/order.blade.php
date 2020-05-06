<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="keywords" content="{{ config('app.name') }}" />
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="author" content="">

    <!-- Title -->
    <title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Mobile Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('front/images/favicon.png') }}" type="image/x-icon">

    <!-- CSS -->
    <link href="{{ asset('front/lib/bootstrap/css/bootstrap.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('front/css/colors.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('front/css/font.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('front/lib/jQuery.filer-master/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('front/lib/jQuery.filer-master/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('front/lib/Magnific-Popup-master/magnific-popup.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('front/lib/popup/css/component.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('front/lib/icon8/styles.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
    <link type="text/css" rel="stylesheet" href="{{ asset('front/lib/jquerym.menu/css/jquery.mmenu.all.css') }}" />
    <link href='{{ asset('front/css/mapbox.css') }}' rel='stylesheet' />
    <link href='{{ asset('front/lib/chosen/chosen.css') }}' rel='stylesheet' />
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css' rel='stylesheet' />
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css' rel='stylesheet' />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}">

    <!-- Optional theme -->
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap-theme.min.css') }}" >
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="{{ asset('front/css/sweetalert2.min.css') }}" >

    <link href="{{ asset('front/css/main.css') }}" type="text/css" rel="stylesheet" />

    <!-- IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('head')
    <link href="{{ asset('front/css/custom.css') }}" type="text/css" rel="stylesheet" />

    <!-- Jquery Library -->
    <script type="text/javascript" src="{{ asset('front/js/jquery-lib.js') }}"></script>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>

<div id="overlayLoading">
    <div>
        <img src="{{ asset('front/images/loading.svg') }}" style="width:100%;" />
    </div>
</div>
<div id="page">

    @yield('content')


    <!--==================================Footer Open=================================-->
    <footer class="text-center">
        <div class="footer-upper-bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="footer-menu">
                            <li><a href="{{ url('/frontend') }}">Home</a></li>
                            <li><a href="{{ url('/about') }}">About</a></li>
                            <li><a href="{{ url('/contact') }}">Contact</a></li>
                            <li><a href="{{ url('/register') }}">Join Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div><!-- ../footer-upper-bar -->
        <div class="footer-bottom-bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="footer-about-company">
                            <li>Copyright © 2018 BiteMe</li>
                            <li>6000 Ohrid, Macedonia</li>
                            <li>Tel: 00389 - 7# ### ###</li>
                        </ul>
                        <ul class="social-icons footer-social-icons">
                            <li>
                                <a href="#"><!-- Facebook icon by Icons8 -->
                                    <img class="icon icons8-Facebook" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAC10lEQVRoQ+1ai3HTQBTc7QAqgFQQqADoAFcAHZBUAFRAUgGkApIKCBUkqYCkA6hgmVXuPGf7ZF0snyTP6GY8ceyT7+17+z7Se0TLkvQBwFsAr8KrbesQn98C8OuS5FXuQK5/KOk9gG8AXg4h4Q5n3AM4JXmZXrsCRJIBnIQNDwDOAFyTtDZGW5LMCrPDsr0IgpyRPI1CLYFIstCfwhdG7P8ntyQZjBXudU6yUXwDJNDpZ/jy9dgW6NJesNBN2LcwzSKQP8EnJmuJjC9Hy9yTPKKkjwC+A3ggOVUHzxpJkh3fPrMwkB8AHGoPxhoRVeIvFwZirjkqTN43MvSy3Jb/1kDUeD25kVO6nG4K3y/lHwNIqBqceK3R1C+vAZj3zlu/S6LnKEBC2HSYLw0qTUTaZvnBgQQQvwA8s7YBOMi4dvqbOK+zt0H6rwNQJ+XHABKDygVJh/ytq5TygwJJKofiXDVVIE/OVVMF4mj0BsA7kn6/XJLsM58BOIptBIGutDA0tVpzVVJZZH3mkIA0IHPW6goIoXJ/VFIpF0t+tG3PtjP6nj8lavUqkaoDiQekVsrxPbdvzbLP06SZKRzrUmtfQEZ39j7cl+QSxeWMC0e/b12DUatLozkJJX0JuaWznJk6kFgJfCVpUAdrkdZK4FCd/Yikb7TGt0iP8PuPpOuwrau6j6Snz5m9yxyPT0nrJsTZIgVWyCqpTwYuPXP2kQJNzT5SoKSNLTO1CrQ2U6tASTO1eilJkh/hH9ds9NRy9qQpejdI660ikNgQbVpvflTpnkVnL2IX0/uaikBiN3oR29OxO1qlIVoDSNIIbZ7wDzIwsG8grQMDwfzpCMcJyfNdqdR6X51puD61aJXkMZM4XrI6whEPXptHMd18QVFTsui+ekcgwQJuS9i5Y+thCcJnt405GUCcwtmXYfb1O55aMmPax5zWblgczWIL2XlmzHWXDJ6tAIhC/QfJdOM+5ZDCYAAAAABJRU5ErkJggg==" alt="facebook">
                                </a>
                            </li>
                            <li>
                                <a href="#"><!-- LinkedIn icon by Icons8 -->
                                    <img class="icon icons8-LinkedIn" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAADv0lEQVRoQ+1a7VEbMRTcrSDpIFBBoIKQCoIrSKggUEGggkAFgQogFYRUELuCQAUJFbzMnp8uurNOJxv7Ds9YM/6B0fm02vf2fUhExzCzjwCOABz4p2vqEN9PAehzT/Im9UK2vzSzYwBfAewNscIV3vEA4IzkXfxsA4iZCcCpT5gBuPZd0G6MNsxMViHr+ATgrS/kkuRZWFQNxMwuAXwG8ATgnKT+fnHDzLTR5wBeAbgiWW18BcTN6dZBHJEclYG+3XOGfvm8icwsAPntPiHbe5FMJHxZTMgVHkju08xkd98AzEjKFrdmmJksRz4zERA5tKR2a9gIO+3+IlZuBES2JiYOu3zDY4qoDIxpJ6QaSU0fitLIV6YCYpXXkwsxxYVAZifzS41rkidDLTz1nnr9OSARdZJkMRKCkIKmREESeEJS5jnKKAUSzK6SuHilkUhMSR6OgmIeOuYW1cNIp9mZ2WsAf3JmOQS4UiB/3Xz2SSrHqYeZKRdT/HkiKVCjjFIgQZrvSE5aQJQJyFduSHaJwcbBlQLRrktq5dRiJHZ2/U8icNBma+Orb1pGv4+4/Cp2CMCb1gIfxcjYeVkRIy1TUhqtj4aUqqFiQ7LQWlc/I1HUz62z8p8l52pDPkQVqH5fwiIz1gZ9LzXXIkbCpL7dVlZQOtcXKpHIDYFSCnTR9+6lgGTSlzrOFKQ61VwfEgllBmKzqn08LokpgVQSW5kwgPckBSw5xgSiElrFW25xEph7V8sF6V/FR/oSymUYCVVnFkRYpAfcIP2d+dzgjPTZeur/UT5XVYEdc4pUa22MRDv9xcsCBVQFWWUPaiIkTc3MNEcxbCFxdd8aHkhGojud2szUMRH4umMyto+EZkGdEbgfKG6o7r4gqUU3hplJyX4A+EkyBOR6zuA+ErHRcNyoFZWsa6JyIeknYwDJ1TbFvphgbFgfWbWAazh0oq+wYySpGFGuVZLOdJpHdyen3yzXRXlprpUCupZnd0DiVszOtObesjOtdTTo2ju5ll3dqdYzWqY7RnJpxjNNKxxfLRz0lHZGlumi5AJiXxXZfjY66Jllj97MTA2Adz0vUA/qeJm5iRSl+D2tFCnUONXRWzgMHfWco4+Njnr9//mNO22oi7fmQDQ6TXskude+MKAGgBpi23lhwFkJVzgERlc4rlahe9PPmJmumYRLDc0rHFGrJoDRV2JFrRoV/aMy5Ook0ZE/hyPyRlel65qTALXPQza92aW/ry7MafaaU0vahD5cPAtXi0pftu556heHi2fJo/B/rbIkXGKb1eoAAAAASUVORK5CYII=" alt="linkedin">
                                </a>
                            </li>
                            <li>
                                <a href="#"><!-- Instagram icon by Icons8 -->
                                    <img class="icon icons8-Instagram" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAFNUlEQVRoQ9WagVUUQQyGkwqUCpQKlArUCoQKxAqUCoQKhAqECsQK1AqECtQKxAri+8ZkzQ67d3vL3HHOe/dg7/Z25k/+JP9kTmVkmNkrEXkuIk/9NXbrJt6/EhFel6r6aWhCrd80s30ReS8ijzexwhlz/BCRI1W9zN/tATEzALz1G36KyKmIfFFVrHFvw8xgBexgbY98IaeqehSL6oCYGYt+4x+AmOutG2YGGAzOOFPVYvgCxOn00T/cu28PLLOee+ib33cAzQLId4+JrfGEmT0UkQ8iQszmQWy8FpFD98wPVd1VM+MNvvBTVbcmwM3ss8fFkIM+qeq+mRH4xMwBQM5FhFS7Nd5wupsj2FHVG38PL/0qMaHK2iNeLriAa2SFrYoNMytAWHB2SX4/xcoVQAa/sCzg1v35FCDZc82BuJWgKl6GCvxlUIugCH8vlmXGACIio9RaCxAze+eZZGrCIFDPVfVkyLtm9kVEno14vgR7UyBmRsUl6wUAFAEpktdNWN49hYdYAK+o0AB6raosvBuefklELyswaK3DlAD+hsZdYqSSNF9F5Lhe0FgsuQGOk9XfqurZqrHXrX8uEDPDC9QgRi91mxlWxOp4KccI1u8p2EpyQDWK3eQxCiSl4ykP+82Cwwsu/dFoUGjRIOjxwIXzHHpCxQdTJnUh+2JhjKRsMeWZLwDhfKYSh/WhGfy+qmKEz/FiBDEZjGfcONV4xqQR9WWRR0brii+YAgplCp0qENdu6V7g1ivzReO5J56OA0xUaihIgS4VPY86FOYCIThJs19VFTqgnEMZAOL50ORDJnYDALiAUdU9f16k3RNVZb61AAmVHJQKYCuBiJVVYMrCE8WKqm0OJO1Zikr2RQCMwC7AJpH7toXxLLEBjXY9Xv6p2mpLe2dqpR1k2ZUl+d/RbA6Qik4UxvN6rqYxkiRD0Ip0Sb0ok88F4UBiTxT7jPDSLSO18Aj7AGhU5H5L+d+T46p76RqJs9PaI720PFcRjHlu1NIL9iOTCuKiDU3vAdVEcym2SSBUYXJ+UKt3PReAG4WKTz26VtWniVrlujW1olD998EeDbw6/dKJLAJu7kgdk42k33B/qbheEClcKNYWBREl/dgLYiiIWw2RO6df5zLVt1u4mYVE6VTsKl6pBGctUQb7bK2AxMILnWrhF5J8CphaNUdQp/q0PtHoXgkdlGV8UAzP8P4UGU8jGrpmSoWMH+16NvGIA2ELGw3vvLEKSc5t/I9sIX2WIwlPqaRv5EjZAvB5SP9qY1Ua00OebQbEFxUUI2aYNHaJWJTXsi0rXiALcsYRu0OMgwQapFSAagrEwUTPmMuuA+Lcj5YPO0m8ENYvzQdvQEQ/lzOZOIuhcRcNjcFQaw6k8kzQCWtO2pc4lSJO+P5CT6zNI+nBWB+L5oZbNOh+VzEC5bK3eAwNPTw6GBO1W9bikTyJ15Qp8RFfK3EytC9flL7XDiR5KFo+0cTOMRJNbBpxsw5YVwbi+2eCc2uGmZE8kC/duUluB9XyPLawW3WC5cklCmZsif/J//roLTUVoAEFbxYFWrvRCyrdFmpNqOTe0VtU6q6PlBoNgKH4YYF7oZnTiSYH6wBEPhsJlXwQx9ND+gmKjR20tDb41Od1ZyOpi1902cIfDDjN8Fh92DJ14lb3AYDjiNJ2Gv3BgH+Yf8Ix69Cl1aqX1JEsafo/4Ug1IIOBblzTJLvXgHcPQHOCO474OhAlHQ9IgFpybMLQq8wxKGluAak0FKDI1VGdV5mw5b3sW+KHZ4Oa7A8mMc1cZlo+UAAAAABJRU5ErkJggg==" alt="instagram">
                                </a>
                            </li>
                            <li>
                                <a href="#"><!-- Tumblr icon by Icons8 -->
                                    <img class="icon icons8-Tumblr" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAADeUlEQVRoQ+2ajXHTQBCF91UAVACpAKgAOgBXQFIBSQWECkgqIKkgSQWECnAqIKmApIJlPs2d5uScrL8jthndjMdjSzrtu919tz8naxnu/snM3pvZm/Bpu/Up/l+aGZ9LSVe5F2r1T3f/aGbfzOzVU0g44h23ZnYk6TJ9tgHE3QFwGG64M7MTM7uWxGpsbLg7VoF1INvLIMiJpKMoVA3E3RH6c7gAYn5v3XB3wLDgjFNJ1cJXQII5XYSLbzetga7VCxr6Fe5bYGYRyO/gE1uriYwvR83cStqTu++b2Xczu5O0rQ6eVZK74/j4zAIgZ2YG1e6MNiKqxF/OAYKtwQqTfcPdj83sS2b5aqfssv8h1xNfWQLEK6+XHu0pQyYNpPHHzJ7nnisxf27eWv5SQNwdAAB5kFSDKTV/26L+CyBEBFD4T0lsXtXYRSBZ0tgpIInTPbAfSbrfOY0E34D52IO+SoK56rETGnF3hMcvoO8bSXw3xtYDCfkKgSUMdUN0mprUqmmtofIzSQdDqf6R6Q5dseAPRJ+RmUh09nMgAmtdm9m7dYJO2WNG06+7xwCTfOVYEmw1agxdxKIbYomXl2S0KRopGdJMnmsGEldgxV6pbixabPhHQgxZX9qUs6e5fS1YmzAtwFNA55JI7kaN0aY1dMMrSQ5FWWsGUiBxmzXSx/u6fKDrep93rLtndvbZ2WdnX+9Fs4+M8BF6K6+r+uxKcyYkXiRotDMIVRrNmz6MVlIjUdBsyTWpz1JZoYJO4Zlcn/yeWlgsnN9LetFH+PSekkBYxQ9mdtCWLSaF8pycZJpVF2pMFFwSSOxTXElihbMjNJOiBtAKH8L/5ZRNsySQWPMFwJ4kBBw0tgJIcNhYLm1NsHqFGSP2mmIaCUBwWJz+mZn1rlO5O4xFP4XvRhW/r0pTIGtZZ8CECIPjAwbzonRK9bFubbs79S1MkXvjYQReQc2Y2tgg+k1qzjdFW29hYoSJvfCudYCxMEt65nXhu+uheH219Rb7GlV3tO8kHTZPDs68rDoaioPSKtqKxzEmHURIioWL2J6O3dGdaYgm2qi60f/XgYHAPGmZ51DSaQkzKz2HuxOXxeMlzSMcifOkYDA3ftMTnGTLU8EEEoHxiCJibNZoebcdcwJAX+aZKufQ52E6LKb9mFM6YxIbEaUShm9ywHaR6bJ7zV8Cie0+55PMmQAAAABJRU5ErkJggg==" alt="tumblr">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div><!-- ../footer-bottom-bar -->
    </footer>
</div>
<!--==================================Footer Close=================================-->


<!--==================================Javscript=================================-->


<script type="text/javascript" src="{{ asset('front/js/bootstrap.min.js') }}"></script><!-- Jquery Library -->
<script type="text/javascript" src="{{ asset('front/js/sweetalert2.min.js') }}"></script><!-- Jquery Library -->
<script type="text/javascript" src="{{ asset('front/js/jquery-migrate-1.3.0.min.js') }}"></script>
<script type="text/javascript" src='{{ asset('front/js/mapbox.js') }}'></script>
<script type="text/javascript" src='{{ asset('front/js/leaflet.markercluster.js') }}'></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script type="text/javascript" src="{{ asset('front/js/build.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/lib/chosen/chosen.jquery.js') }}" ></script>
<script type="text/javascript" src="{{ asset('front/js/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/lib/slick/slick.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/lib/jquerym.menu/js/jquery.mmenu.min.all.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/lib/Magnific-Popup-master/jquery.magnific-popup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/lib/jQuery.filer-master/js/jquery.filer.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap-rating.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/lib/popup/js/classie.js') }}"></script> <!-- Popup -->
<script type="text/javascript" src="{{ asset('front/js/main.js') }}"></script>

@yield('footer')
</body>
</html>