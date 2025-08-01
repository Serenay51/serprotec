@extends('layouts.app')

@section('content')
<h3>Nuevo Presupuesto</h3>
<form action="{{ route('quotations.store') }}" method="POST" class="card p-4 shadow bg-white" x-data="quotationForm()">
    @csrf
    <div class="mb-3">
        <label for="client_id" class="form-label">Cliente</label>
        <select name="client_id" class="form-select" required>
            <option value="">Seleccionar...</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                    {{ $client->name }}
                </option>
            @endforeach
        </select>
        @error('client_id')
            <div class="text-danger">{{ $message }}</div>
        @enderror
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
                                <option value="{{ $p->id }}" data-price="{{ $p->price }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" min="1" class="form-control" :name="'items['+index+'][quantity]'" x-model="item.quantity" @input="calcSubtotal(index)"></td>
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

    <button class="btn btn-success mt-3" style="background:#2A8D6C;">Guardar Presupuesto</button>
</form>

<script>
function quotationForm() {
    return {
        items: [],
        addItem() { this.items.push({product_id:'',quantity:1,price:0,subtotal:0}); },
        removeItem(i) { this.items.splice(i,1); },
        updatePrice(i) {
            let select = event.target;
            let price = select.options[select.selectedIndex].dataset.price || 0;
            this.items[i].price = parseFloat(price);
            this.calcSubtotal(i);
        },
        calcSubtotal(i) {
            this.items[i].subtotal = this.items[i].quantity * this.items[i].price;
        },
        get total() { return this.items.reduce((sum,it)=>sum+it.subtotal,0); }
    }
}
</script>
@endsection
