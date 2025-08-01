@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Productos</h3>
    <a href="{{ route('products.create') }}" class="btn btn-success" style="background:#2A8D6C;">+ Nuevo Producto</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Formulario de importación de productos -->
<div class="card p-3 mb-3 shadow-sm">
    <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="d-flex">
        @csrf
        <input type="file" name="file" class="form-control me-2" required>
        <button class="btn btn-primary">Importar Excel</button>
    </form>
    <small class="text-muted mt-2">
        Formato: columnas (name, category, description, price, stock)
    </small>
</div>

<table class="table table-bordered bg-white shadow-sm">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>${{ number_format($product->price, 2) }}</td>
            <td>{{ $product->stock }}</td>
            <td>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm">Editar</a>
                <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">Ver</a>
                <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')">Eliminar</button>
                    <script>
                        function confirmDelete(id, name) {
                            Swal.fire({
                                title: '¿Estás seguro?',
                                text: `¿Quieres eliminar el producto "${name}"?`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Sí, eliminarlo'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Mostrar mensaje de éxito
                                    Swal.fire({
                                        title: 'Eliminado',
                                        text: `El producto "${name}" ha sido eliminado.`,
                                        icon: 'success',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                    timer = setTimeout(() => {
                                        // Enviar el formulario de eliminación
                                        document.getElementById(`delete-form-${id}`).submit();
                                    }, 1500);
                                } else {
                                    Swal.fire({
                                        title: 'Cancelado',
                                        text: `El producto "${name}" no ha sido eliminado.`,
                                        icon: 'error',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                }
                            });
                        }
                    </script>
                </form>
            </td>
        </tr>
    @endforeach
    @if($products->isEmpty())
        <tr>
            <td colspan="5" class="text-center p-3">No hay productos registrados.</td>
        </tr>
    @endif
    </tbody>
</table>

<div>
    {{ $products->links() }}
</div>
@endsection
