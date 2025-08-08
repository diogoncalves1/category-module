@extends('layouts.frontend')

@section('title', 'Adicionar Utilizador ')

@section('breadcrumb')
<li class="breadcrumb-item active"><a class="text-white" href="{{ route('admin.users.index') }}">Utilizadores</a>
</li>
<li class="breadcrumb-item active">{{ isset($user) ? 'Editar' : 'Adicionar' }}</li>
@endsection

@section('css')
<link rel="stylesheet" href="/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@endsection

@section('content')
<section class="content">
    <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store')  }}"
        method="POST">
        @csrf
        @if(isset($category))
        <input hidden name="user_id" value="{{ $category->id }}" type="text">
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Geral</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputCode">Nome <span class="text-danger">*</span></label>
                            <input type="text" name="name" value='{{ $category->name ?? "" }}' class="validate form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="inputDisplayName">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value='{{ $category->email ?? "" }}'
                                class="validate form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="inputDisplayName">Password
                                <span class="text-danger"> {{ isset($category) ? '' : '*'}}</span> </label>
                            <input type="password" name="password" minlength="8" class="validate form-control"
                                {{ isset($category) ? '' : 'required' }}>
                        </div>


                        <div class="form-group">
                            <label for="inputDisplayName">Password
                                <span class="text-danger"> {{ isset($category) ? '' : '*'}}</span> </label>
                            <input type="password" name="password" minlength="8" class="validate form-control"
                                {{ isset($category) ? '' : 'required' }}>
                        </div>

                </div>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-12 ">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-success float-right">{{ isset($user) ? 'Editar' : 'Adicionar' }}
                    Utilizador</button>
            </div>
        </div>
    </form>
</section>
@endsection