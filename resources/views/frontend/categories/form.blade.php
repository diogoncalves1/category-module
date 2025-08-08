@extends('layouts.frontend')

@section('title', 'Adicionar Categoria')

@section('breadcrumb')
<li class="breadcrumb-item active"><a class="text-white" href="{{ route('categories.index') }}">Categorias</a>
</li>
<li class="breadcrumb-item active">{{ isset($category) ? 'Editar' : 'Adicionar' }}</li>
@endsection

@section('css')
<link rel="stylesheet" href="/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@endsection

@section('content')
<section class="content">
    <form action="{{ isset($category) ? route('api.categories.update', $category->id) : route('api.categories.store')  }}"
        method="POST">
        @csrf
        @if(isset($category))
        <input hidden name="category_id" value="{{ $category->id }}" type="text">
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Geral</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Nome <span class="text-danger">*</span></label>
                                <input type="text" name="name" value='{{ $category->name ?? "" }}' class="validate form-control" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Tipo <span class="text-danger">*</span></label>
                                <select name="type" value='{{ $category->type ?? "" }}' class="select2 validate form-control" required>
                                    <option value="revenue">{{ __('frontend.revenue') }}</option>
                                    <option value="expense">{{ __('frontend.expense') }}</option>
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label>Categoria Pai</label>
                                <select name="parent_id" value='{{ $category->parent_id ?? "" }}' class="select2 form-control">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 ">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-success float-right">{{ isset($category) ? 'Editar' : 'Adicionar' }}
                    Categoria</button>
            </div>
        </div>
    </form>
</section>
@endsection