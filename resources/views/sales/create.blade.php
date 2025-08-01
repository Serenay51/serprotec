@extends('layouts.app')

@section('content')
<h3>Nueva Venta</h3>
<form action="{{ route('sales.store') }}" method="POST" class="card p-4 shadow bg-white" x-data="saleForm()">
    @csrf
    <div class="mb-3">
        <label for="client_id" class="form-label">Cliente</label>
        <select name="client_id" class="form-select" required>
            <option value="">Seleccionar...</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">Fecha</label>
        <input type="date" name="date" class="form-control" required value="{{ date('Y-m-d') }}">
    </div>

    <h5 class="mt-4">Productos</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cant.</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <template x-for="(item,index) in items" :key="index">
                <tr>
                    <td>
                        <select :name="'items['+index+'][product_id]'" class="form-select" x-model="item.product_id" @change="updatePrice(index)">
                            <option value="">--</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" data-price="{{ $p->price }}" data-stock="{{ $p->stock }}">
                                    {{ $p->name }} (Stock: {{ $p->stock }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" min="1" :max="item.stock" class="form-control"
                            :name="'items['+index+'][quantity]'" x-model="item.quantity" @input="calcSubtotal(index)">
                        <template x-if="item.stock > 0 && item.quantity > item.stock">
                            <div class="text-danger small">No hay suficiente stock</div>
                        </template>
                    </td>
                    <td><input type="number" step="0.01" class="form-control" :name="'items['+index+'][price]'" x-model="item.price" @input="calcSubtotal(index)"></td>
                    <td>
                        <input type="hidden" :name="'items['+index+'][subtotal]'" :value="item.subtotal">
                        <span x-text="item.subtotal.toFixed(2)"></span>
                    </td>
                    <td><button type="button" class="btn btn-sm btn-danger" @click="removeItem(index)">X</button></td>
                </tr>
            </template>
        </tbody>
    </table>
    <button type="button" class="btn btn-outline-primary mb-3" @click="addItem()">+ Agregar Producto</button>

    <div class="text-end fs-5">
        Total: $<span x-text="total.toFixed(2)"></span>
    </div>

    <button type="submit" class="btn btn-success mt-3" style="background:#2A8D6C;">Registrar Venta</button>
</form>

<script>
function saleForm() {
    return {
        items: [],
        addItem() { this.items.push({product_id:'',quantity:1,price:0,subtotal:0,stock:0}); },
        removeItem(i) { this.items.splice(i,1); },
        updatePrice(i) {
            let select = event.target;
            let price = select.options[select.selectedIndex].dataset.price || 0;
            let stock = select.options[select.selectedIndex].dataset.stock || 0;
            this.items[i].price = parseFloat(price);
            this.items[i].stock = parseInt(stock);
            // Si la cantidad supera el stock, la ajusta
            if (this.items[i].quantity > this.items[i].stock) {
                this.items[i].quantity = this.items[i].stock;
            }
            this.calcSubtotal(i);
        },
        calcSubtotal(i) {
            // Limita la cantidad al stock disponible
            if (this.items[i].quantity > this.items[i].stock) {
                this.items[i].quantity = this.items[i].stock;
            }
            this.items[i].subtotal = this.items[i].quantity * this.items[i].price;
        },
        get total() { return this.items.reduce((sum,it)=>sum+it.subtotal,0); }
    }
}
</script>
@endsection
