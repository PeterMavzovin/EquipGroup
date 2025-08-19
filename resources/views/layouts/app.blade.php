<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Каталог товаров</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
    </html>