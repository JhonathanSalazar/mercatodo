@extends('admin.layout')

@section('content')
        <div class="row">
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
                        <form method="POST" action="{{ route('admin.users.update', $user) }}" >
                            @csrf @method('PUT')
                            <div class="form-group">
                                <label for="name">Nombre:</label>
                                <input name="name" class="form-control" type="text" value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input name="email" class="form-control" type="text" value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="form-group">
                                <label for="Habilitación usuario">Habilitación usuario</label>
                                <select name="enable" class="form-control">
                                    <option value="">Seleccione un estado</option>
                                    <option value=0 {{ old('enable' ,$user->enable) == 0 ? 'selected' : '' }} >Deshabilitado</option>
                                    <option value=1 {{ old('enable' ,$user->enable) == 1 ? 'selected' : '' }}>Habilitado</option>
                                </select>
                            </div>

                            <button class="btn btn-primary btn-block ">Actualizar información</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
