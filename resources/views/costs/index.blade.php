@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Listas de Precios</h3>
    <a href="{{ route('costs.create') }}" class="btn btn-success" style="background:#2A8D6C;">
        <i class="fa fa-tag"></i> Nueva Lista
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered bg-white shadow-sm">
    <thead class="table-light text-center">
        <tr>
            <th>Proveedor</th>
            <th>Archivo</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="text-center">
        @forelse($costs as $c)
        <tr>
            <td>{{ $c->provider->name }}</td>
            <td>{{ $c->filename }}</td>
            <td>{{ $c->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="#" class="btn btn-sm btn-info btn-preview" data-file="{{ asset('storage/' . $c->file) }}">
                    <i class="fa fa-eye"></i>
                </a>
                <a href="{{ route('costs.download', $c) }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-download"></i>
                </a>
                <form action="{{ route('costs.destroy', $c) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No hay listas cargadas.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $costs->links() }}


<!-- Modal para vista previa -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="previewModalLabel">Vista previa del archivo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="previewContent" style="min-height:500px;">
        <p class="text-center text-muted">Cargando vista previa...</p>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.btn-preview').forEach(btn => {
    btn.addEventListener('click', e => {
        e.preventDefault();
        const fileUrl = btn.dataset.file;
        const previewDiv = document.getElementById('previewContent');

        if(fileUrl.toLowerCase().endsWith('.pdf')) {
            previewDiv.innerHTML = `<iframe src="${fileUrl}" width="100%" height="600px" style="border:none;"></iframe>`;
        } else if(fileUrl.toLowerCase().endsWith('.xlsx') || fileUrl.toLowerCase().endsWith('.xls')) {
            const officeUrl = `https://view.officeapps.live.com/op/embed.aspx?src=${encodeURIComponent(fileUrl)}`;
            previewDiv.innerHTML = `<iframe src="${officeUrl}" width="100%" height="600px" frameborder="0"></iframe>`;
        } else {
            previewDiv.innerHTML = `<p class="text-danger text-center">Formato no soportado para vista previa.</p>`;
        }

        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    });
});
</script>
@endsection
