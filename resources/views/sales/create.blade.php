@extends('layouts.app')

@section('content')
<h3>Nueva Venta</h3>

<form action="{{ route('sales.store') }}" method="POST" class="card p-4 shadow bg-white" x-data="posForm()" @submit="submitForm($event)">
    @csrf

    <!-- BUSCADOR CLIENTES -->
    <div class="mb-4" style="position: relative; max-width: 500px;">
        <label class="form-label">Buscar Cliente</label>
        <input type="text" x-model="clientSearch" @input.debounce.300ms="filterClients" @focus="showClientDropdown = true" @click.away="showClientDropdown = false"
            class="form-control" placeholder="Escribí para buscar cliente..." autocomplete="off" required>

        <div x-show="showClientDropdown" style="position: absolute; z-index: 1000; width: 100%; max-height: 200px; overflow-y: auto; background: white; border: 1px solid #ddd; border-radius: 4px;"
            x-transition>
            <template x-for="(client, idx) in filteredClients" :key="client.id">
                <div @click="selectClient(client)" 
                    class="p-2 cursor-pointer hover:bg-primary hover:text-white" 
                    :class="{'bg-primary text-white': idx === clientHighlightIndex}"
                    @mouseenter="clientHighlightIndex = idx"
                >
                    <strong x-text="client.name"></strong><br>
                    <small x-text="client.email ? client.email : ''"></small>
                </div>
            </template>
            <div x-show="filteredClients.length === 0" class="p-2 text-muted">No se encontraron clientes</div>
        </div>

        <template x-if="selectedClient">
            <div class="mt-2 p-2 border rounded bg-light">
                <b>Cliente seleccionado:</b> <span x-text="selectedClient.name"></span><br>
                <small x-text="selectedClient.email ? 'Email: ' + selectedClient.email : ''"></small><br>
                <small x-text="selectedClient.phone ? 'Teléfono: ' + selectedClient.phone : ''"></small><br>
                <input type="hidden" name="client_id" :value="selectedClient.id" required>
            </div>
        </template>
    </div>

    <!-- FECHA DE VENTA -->
    <div class="mb-4">
        <label for="date" class="form-label">Fecha</label>
        <input type="date" name="date" class="form-control" required value="{{ date('Y-m-d') }}">
    </div>

    <!-- BUSCADOR DE PRODUCTOS -->
    <div class="mb-3" style="position: relative; max-width: 600px;">
        <label class="form-label">Buscar Producto</label>
        <input type="text" x-model="productSearch" @input.debounce.300ms="filterProducts" @focus="showProductDropdown = true" @click.away="showProductDropdown = false"
            class="form-control" placeholder="Escribí para buscar producto..." autocomplete="off">

        <div x-show="showProductDropdown" style="position: absolute; z-index: 1000; width: 100%; max-height: 250px; overflow-y: auto; background: white; border: 1px solid #ddd; border-radius: 4px;"
            x-transition>
            <template x-for="(product, idx) in filteredProducts" :key="product.id">
                <div @click="addProduct(product)" 
                    class="d-flex p-2 cursor-pointer hover:bg-primary hover:text-white align-items-center"
                    :class="{'bg-primary text-white': idx === productHighlightIndex}"
                    @mouseenter="productHighlightIndex = idx"
                >
                    <img :src="product.image ?? 'https://via.placeholder.com/40?text=No+Img'" alt="" style="width:40px; height:40px; object-fit:cover; margin-right:10px; border-radius:4px;">
                    <div>
                        <div x-text="product.name"></div>
                        <small x-text="'Stock: ' + product.stock"></small><br>
                        <small x-text="product.description ?? ''"></small>
                    </div>
                </div>
            </template>
            <div x-show="filteredProducts.length === 0" class="p-2 text-muted">No se encontraron productos</div>
        </div>
    </div>

    <!-- TABLA DE PRODUCTOS AGREGADOS -->
    <h5 class="mt-4">Productos en la Venta</h5>
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Stock</th>
                <th>Cant.</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <template x-for="(item, index) in items" :key="item.id">
                <tr>
                    <td x-text="item.name"></td>
                    <td x-text="item.description ?? ''"></td>
                    <td x-text="item.stock"></td>
                    <td>
                        <input type="number" min="1" :max="item.stock" class="form-control form-control-sm" 
                            :name="'items['+index+'][quantity]'" x-model.number="item.quantity" @input="recalcSubtotal(index)">
                        <input type="hidden" :name="'items['+index+'][product_id]'" :value="item.id" />
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control form-control-sm" 
                            :name="'items['+index+'][price]'" x-model.number="item.price" @input="recalcSubtotal(index)">
                    </td>
                    <td>
                        <input type="hidden" :name="'items['+index+'][subtotal]'" :value="item.subtotal.toFixed(2)">
                        <span x-text="item.subtotal.toFixed(2)"></span>
                    </td>
                    <td><button type="button" class="btn btn-danger btn-sm" @click="removeProduct(index)">X</button></td>
                </tr>
            </template>
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="text-end fs-4 fw-bold">
        Total: $ <span x-text="total.toFixed(2)"></span>
    </div>

    <button type="submit" class="btn btn-success mt-3" style="background:#2A8D6C;">Registrar Venta</button>
</form>

<script>
function posForm() {
    return {
        clientSearch: '',
        clients: @json($clients),
        filteredClients: [],
        showClientDropdown: false,
        clientHighlightIndex: 0,
        selectedClient: null,

        productSearch: '',
        products: @json($products),
        filteredProducts: [],
        showProductDropdown: false,
        productHighlightIndex: 0,

        items: [],

        filterClients() {
            this.filteredClients = this.clients.filter(c => c.name.toLowerCase().includes(this.clientSearch.toLowerCase()));
            this.clientHighlightIndex = 0;
        },
        selectClient(client) {
            this.selectedClient = client;
            this.clientSearch = client.name;
            this.showClientDropdown = false;
        },

        filterProducts() {
            this.filteredProducts = this.products.filter(p => p.name.toLowerCase().includes(this.productSearch.toLowerCase()));
            this.productHighlightIndex = 0;
        },
        addProduct(product) {
            this.showProductDropdown = false;
            this.productSearch = '';
            let exists = this.items.find(i => i.id === product.id);
            if(exists) {
                if(exists.quantity < product.stock) exists.quantity++;
                this.recalcSubtotal(this.items.indexOf(exists));
            } else {
                this.items.push({
                    id: product.id,
                    name: product.name,
                    description: product.description ?? '',
                    stock: product.stock,
                    quantity: 1,
                    price: parseFloat(product.price),
                    subtotal: parseFloat(product.price),
                    image: product.image ?? null,
                });
            }
        },

        recalcSubtotal(index) {
            let item = this.items[index];
            if(item.quantity > item.stock) item.quantity = item.stock;
            item.subtotal = item.quantity * item.price;
        },

        removeProduct(index) {
            this.items.splice(index, 1);
        },

        get total() {
            return this.items.reduce((sum, item) => sum + item.subtotal, 0);
        },

        submitForm(event) {
            if(!this.selectedClient) {
                alert('Por favor seleccioná un cliente válido');
                event.preventDefault();
                return;
            }
            if(this.items.length === 0) {
                alert('Agregá al menos un producto');
                event.preventDefault();
                return;
            }
            // Si pasa todo, deja enviar el form normalmente
        },

        init() {
            this.filteredClients = this.clients;
            this.filteredProducts = this.products;
        }
    }
}
</script>

@endsection
