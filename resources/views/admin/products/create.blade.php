@extends('admin.layout')

@section('header')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <h1>
        PRODUCTOS
        <small>Crear</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li><a href="{{ route('admin.products.index') }}"><i class="fa fa-barcode"></i>Productos</a></li>
        <li class="active">Crear</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <form method="POST" action="{{ route('admin.products.store') }}">
            @csrf
            <div class="col-md-8">
                <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                <label for="">Nombre producto:</label>
                                <input name="name"
                                       type="text"
                                       value="{{ old('name') }}"
                                       class="form-control"
                                       placeholder="Ingrese el nombre del producto">
                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('ean') ? 'has-error' : ''}}">
                                <label for="">Código producto:</label>
                                <input name="ean"
                                       value="{{ old('ean') }}"
                                       type="text"
                                       class="form-control"
                                       placeholder="EAN, UPC u otro GTIN (Código barras)">
                                {!! $errors->first('ean', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('branch') ? 'has-error' : ''}}">
                                <label for="">Marca producto:</label>
                                <input name="branch"
                                       value="{{ old('branch') }}"
                                       type="text"
                                       class="form-control"
                                       placeholder="Marca del producto">
                                {!! $errors->first('branch', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                                <label for="ProductImage">Imagen producto:</label>
                                <input type="file" name="image" id="ProductImage">
                                <p class="help-block">Imagen del producto en buena resolución</p>
                                {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                            <label for="">Precio producto:</label>
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input name="price"
                                       value="{{ old('price') }}"
                                       type="text"
                                       class="form-control"
                                       placeholder="Precio en COP">
                            </div>
                            {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="">Categoría</label>
                            <select name="category" class="form-control">
                                <option value="">Selecciona una categoría</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="">
                            <label>Etiquetas</label>
                                <select name="tags" class="form-control select2"
                                        multiple="multiple"
                                        data-placeholder="Etiquetas"
                                        style="width: 100%">
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                    <option>Option 3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-block">Guardar producto</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="/adminlte/plugins/select2/select2.min.css">
@endpush

@push('scripts')
    <script src="/adminlte/plugins/select2/select2.full.min.js"></script>
    <script>
        $('.select2').select2();
    </script>
@endpush
