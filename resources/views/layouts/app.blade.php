<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Каталог товаров</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">        <style>
            body {
                padding-top: 20px;
            }
            .product-card {
                margin-bottom: 20px;
                min-height: 180px; /* Чтобы карточки были одинаковой высоты */
            }
            .group-list-item {
                margin-bottom: 10px;
            }
            .breadcrumbs {
                margin-bottom: 20px;
                background-color: #f8f9fa;
                padding: 10px 15px;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            @yield('content') {{-- Здесь будет вставляться содержимое из дочерних шаблонов --}}
        </div>

        <!-- Bootstrap JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>    </body>
    </html>