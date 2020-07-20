<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="{{ route('admin.products.store') }}" class="container">
        @csrf

        <h1>Crear un producto</h1>

        <div class="field">
            <label class="label" for="name">Nombre</label>

            <div class="control">
                <input type="text" class="input" placeholder="Nombre" name="name">
            </div>
        </div>

        <div class="field">
            <label class="label" for="branch">Marca</label>

            <div class="control">
                <input type="text" class="input" placeholder="Marca" name="branch">
            </div>
        </div>

        <div class="field">
            <label class="label" for="price">Precio</label>

            <div class="control">
                <input type="text" class="input" placeholder="Precio" name="price">
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="btn is-link">Crear producto</button>
            </div>
        </div>
    </form>
</body>
</html>
