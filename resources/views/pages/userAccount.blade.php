@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos personales</h3>
                    </div>
                    <div class="box-body">
                        @if($errors->any())
                            <ul class="list-group">
                                @foreach($errors->all() as $error)
                                    <li class="list-group-item list-group-item-danger">
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <form method="" action="#" >
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre:</label>
                                <input name="name" class="form-control" type="text" value="">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input name="email" class="form-control" type="text" value="">
                            </div>
                            <button class="btn btn-primary btn-block ">Actualizar información</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
