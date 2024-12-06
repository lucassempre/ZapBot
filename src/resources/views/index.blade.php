<html><head>

    <meta charset="UTF-8">
    <title>Docs</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

    <style>
        @import url("https://fonts.googleapis.com/css?family=Nunito:400,700");
        * {
            transition: all 0.3s ease-out;
        }

        html,
        body {
            height: 100%;
            font-family: "Nunito", sans-serif;
            font-size: 16px;
        }

        .container {
            width: 100%;
            height: 100%;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }

        h3 {
            color: #262626;
            font-size: 17px;
            line-height: 24px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        p {
            font-size: 17px;
            font-weight: 400;
            line-height: 20px;
            color: #666666;
        }
        p.small {
            font-size: 14px;
        }

        .go-corner {
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            width: 32px;
            height: 32px;
            overflow: hidden;
            top: 0;
            right: 0;
            background-color: #00838d;
            border-radius: 0 4px 0 32px;
        }

        .go-arrow {
            margin-top: -4px;
            margin-right: -4px;
            color: white;
            font-family: courier, sans;
        }

        .card1 {
            display: block;
            position: relative;
            max-width: 262px;
            background-color: #f2f8f9;
            border-radius: 4px;
            padding: 32px 24px;
            margin: 12px;
            text-decoration: none;
            z-index: 0;
            overflow: hidden;
        }
        .card1:before {
            content: "";
            position: absolute;
            z-index: -1;
            top: -16px;
            right: -16px;
            background: #00838d;
            height: 32px;
            width: 32px;
            border-radius: 32px;
            transform: scale(1);
            transform-origin: 50% 50%;
            transition: transform 0.25s ease-out;
        }
        .card1:hover:before {
            transform: scale(21);
        }

        .card1:hover p {
            transition: all 0.3s ease-out;
            color: rgba(255, 255, 255, 0.8);
        }
        .card1:hover h3 {
            transition: all 0.3s ease-out;
            color: #ffffff;
        }
    </style>
</head>

<body translate="no">
<div class="container">
    <a class="card1" href="/docs/redoc">
        <h3>REDOC</h3>
        <p class="small">Visualize a documentação da api com REDOC</p>
        <div class="go-corner" href="#">
            <div class="go-arrow">
                →
            </div>
        </div>
    </a>
    <a class="card1" href="/docs/swagger">
        <h3>SWAGGER</h3>
        <p class="small">Visualize a documentação da api com SWAGGER</p>
        <div class="go-corner" href="#">
            <div class="go-arrow">
                →
            </div>
        </div>
    </a>
    <a class="card1" href="/docs/file/postman">
        <h3>POSTMAN</h3>
        <p class="small">Visualize o arquivo de configuração do POSTMAN</p>
        <div class="go-corner" href="#">
            <div class="go-arrow">
                →
            </div>
        </div>
    </a>
</div>
</body></html>
