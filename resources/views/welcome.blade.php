<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                background: #808080;
            }

            img {
                display: block;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
            }

            .position-ref {
                position: relative;
            }

            .image-container {
                margin-bottom: 30px;
            }

            .rate__btn {
                padding: 10px 15px;
                width: 150px;
                cursor: pointer;
                margin: 1px;
            }

            .rate__btn:hover {
                /*background-color: #6B6B6B;*/
                /*outline: rgb(0, 166, 255);*/
            }

            /** Animation styles. */
            .modal-enter {
                opacity: 0;
            }

            .modal-leave-active {
                opacity: 0;
            }

            .modal-enter .modal-container,
            .modal-leave-active .modal-container {
                -webkit-transform: scale(1.1);
                transform: scale(1.1);
            }
        </style>
    </head>
    <body>
        <div id="app">
            <experiment></experiment>
        </div>

        <script src="./js/app.js"></script>
    </body>
</html>
