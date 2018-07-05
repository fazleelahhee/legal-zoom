<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="/css/app.css" rel="stylesheet" type="text/css">
        <link href="/css/faces/cards.css" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <div class="show-result"></div>
                    <br />
                    <button name="high" class="btn btn-primary hit">High</button>&nbsp;<button name="low" class="btn btn-warning hit">Low</button>
                    <button name="restart" class="btn btn-primary restart">Restart Game</button>
                </div>


            </div>
        </div>

        <script
                src="https://code.jquery.com/jquery-3.3.1.min.js"
                integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            var lastCard= null;
            var score = 0;

            $('.restart').hide();

            $.ajax({
                url: '/get-card',
                success: function (response) {
                    var html = '<div class="card rank-'+response.value+' '+response.suit+'"> ' +
                            '<span class="rank">'+response.value+'</span> ' +
                            '<span class="suit">'+response.suit+'</span> ' +
                            '</div>';



                    var currentCard = response;

                    console.log(currentCard);

                    if(currentCard.value.toLowerCase() == 'j') {
                        currentCard.value = 11;
                    } else if(currentCard.value.toLowerCase() == 'q') {
                        currentCard.value = 12;
                    } else if(currentCard.value.toLowerCase() == 'k') {
                        currentCard.value = 13;
                    }else  if(currentCard.value.toLowerCase() == 'a') {
                        currentCard.value = 1;
                    }

                    lastCard = currentCard;
                    $('.show-result').html(html);
                }
            });

            $('.hit').click(function (e) {
                e.preventDefault();
                var self = $(this);
                $.ajax({
                    url: '/get-card',
                    success: function (response) {

                        var currentCard = response;
                        var suit = response.suit;
                        var value = response.value;

                        console.log(currentCard);
                        if(currentCard.value.toLowerCase() == 'j') {
                            currentCard.value = 11;
                        } else if(currentCard.value.toLowerCase() == 'q') {
                            currentCard.value = 12;
                        } else if(currentCard.value.toLowerCase() == 'k') {
                            currentCard.value = 13;
                        } else if(currentCard.value.toLowerCase() == 'a') {
                            currentCard.value = 1;
                        }

                        var _continue = true;

                        console.log(self.attr('name'));
                        if(self.attr('name') === 'high') {
                            if(lastCard.value === currentCard.value) {
                                // do nothing its tie.
                            } else if(lastCard.value > currentCard.value) {
                                _continue = false;
                            } else {
                                score += 1;
                            }

                        } else {
                            if(lastCard.value === currentCard.value) {
                                // do nothing its tie.
                            } else if(lastCard.value < currentCard.value) {
                                _continue = false;
                            } else {
                                score += 1;
                            }
                        }

                        if(_continue) {

                            var html = '<div class="card rank-'+value+' '+suit+'"> ' +
                                    '<span class="rank">'+value+'</span> ' +
                                    '<span class="suit">'+suit+'</span> ' +
                                    '</div>';
                            $('.show-result').html(html);
                        } else {
                            $('.hit').hide();
                            $('.restart').show();



                            var html = '<div class="card rank-'+value+' '+suit+'"> ' +
                                    '<span class="rank">'+value+'</span> ' +
                                    '<span class="suit">'+suit+'</span> ' +
                                    '</div> <p>>Your score:'+score+' </p>';
                            $('.show-result').html(html);
                        }

                        lastCard  = currentCard;
                    }
                });
            });

            $('.restart').click(function () {
                location.reload();
            });
        });
    </script>
    </body>
</html>
