@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Clientes</h3>
    <div>
        <a href="{{ route('clients.create') }}" class="btn btn-success" style="background:#2A8D6C;"><i class="fa fa-user-plus"></i> Nuevo Cliente</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Formulario de importación -->
<div class="card p-3 mb-3 shadow-sm">
    <form action="{{ route('clients.import') }}" method="POST" enctype="multipart/form-data" class="d-flex">
        @csrf
        <input type="file" name="file" class="form-control me-2" required>
        <button class="btn btn-primary">Importar Excel</button>
    </form>
    <small class="text-muted mt-2">Formato: columnas (name, email, phone, address, cuit)</small>
</div>

@if(session('import_error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error en el archivo',
        text: "{{ session('import_error') }}",
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#d33'
    });
</script>
@endif

<!-- Barra de búsqueda Clientes -->
<form method="GET" action="{{ route('clients.index') }}" class="mb-4">
    <div class="input-group">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control"
            placeholder="Buscar por nombre o CUIT..."
            autocomplete="off"
        />
        <button class="btn btn-primary" type="submit">
            <i class="fa fa-search"></i> Buscar
        </button>
    </div>
</form>

<table class="table table-bordered bg-white shadow-sm">
    <thead class="table-light text-center">
        <tr>
            <th>N° Cliente</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>CUIT</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @forelse($clients as $client)
        <tr>
            <td>{{ $client->id }}</td>
            <td>{{ $client->name }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->phone }}</td>
            <td>{{ $client->cuit }}</td>
            <td>
                <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                </form>
                <button class="btn btn-sm btn-success" 
                        onclick="openWhatsAppModal('{{ $client->name }}', '{{ $client->phone }}')">
                    <i class="fa-brands fa-whatsapp"></i>
                </button>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">No hay clientes cargados.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $clients->appends(request()->except('page'))->links() }}

<!-- Modal WhatsApp -->
<div class="modal fade" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="whatsappModalLabel"><i class="fa-brands fa-whatsapp"></i> Enviar mensaje</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-2">Vas a enviar un mensaje a:</p>
        <h5 id="clientName" class="fw-bold"></h5>
        <p><i class="fa fa-phone"></i> <span id="clientPhone"></span></p>
        <textarea id="whatsappMessage" class="form-control mt-3" rows="2" placeholder="Escribe un mensaje..."></textarea>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a id="whatsappLink" href="#" target="_blank" class="btn btn-success">
            <i class="fa-brands fa-whatsapp"></i> Abrir en WhatsApp
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    function openWhatsAppModal(name, phone) {
        document.getElementById('clientName').innerText = name;
        document.getElementById('clientPhone').innerText = phone;
        document.getElementById('whatsappLink').href = `https://api.whatsapp.com/send?phone=${phone}`;
        new bootstrap.Modal(document.getElementById('whatsappModal')).show();
    }

    // Actualiza el enlace con el mensaje escrito
    document.getElementById('whatsappMessage').addEventListener('input', function() {
        const phone = document.getElementById('clientPhone').innerText;
        const message = encodeURIComponent(this.value);
        document.getElementById('whatsappLink').href = `https://api.whatsapp.com/send?phone=${phone}&text=${message}`;
    });
</script>
@endsection
