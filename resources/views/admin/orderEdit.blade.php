<x-app-layout>

    @include('layouts.header')

    <div class="row">
    
        @include('layouts.sidebar')
      
        <div class="col-md-10 h-auto bg-contrast">
            @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show text-center container-fluid" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
             @endif
             
            <div class="container">
                <div class="row d-flex justify-content-center mt-5 mb-3">
                    <h2 class="text-center text-secondary">Editar pedido nº {{ $selectOrder->id }}</h2>
                 </div>

                 <div class="row d-flex justify-content-center">
                    <form action="{{ route('admin.orders.update', $idorder) }}" method="post">
                        @csrf
                        @method('PUT')
                        @foreach($listItems as $orderItem)
                            <div class="col-md-12">
                                <div class="row">
                                    @php
                                        $inputName = 'name' . $orderItem->product->id;
                                        $inputPrice = 'price' . $orderItem->id;
                                        $inputQuantity = 'quantity' . $orderItem->id;
                                        $inputSubtotal = 'subtotal'.$orderItem->id;
                                    @endphp
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name">Nome</label>
                                            <input type="text" class="form-control" name="{{ $inputName }}" value="{{ $orderItem->product->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="price">Preço</label>
                                            <input type="text" class="form-control" name="{{ $inputPrice }}" value="{{ $orderItem->price }}" required>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="quantity">Quantidade</label>
                                            <input type="text" class="form-control" name="{{ $inputQuantity  }}" value="{{ $orderItem->quantityItem }}" required>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="subtotal">Subtotal</label>
                                            <input type="text" class="form-control" name="{{ $inputSubtotal }}" value="{{ $orderItem->subtotal }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="total">Total</label>
                                            <input type="text" class="form-control" name="total" id="total" value="@money($selectOrder->total)" required>
                                        </div>
                                    </div>
                                </div>                           
                            </div>
                        @endforeach

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="{{ $selectOrder->status }}">{{ $selectOrder->status }}</option>
                                    <option value="Processando">Processando</option>
                                    <option value="Aprovado">Aprovado</option>
                                    <option value="Reprovado">Reprovado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="payment">Método de pagamento</label>
                                <select class="form-control" id="payment" name="payment" required>
                                    <option value="{{ $selectOrder->payment }}">{{ $selectOrder->payment }}</option>
                                    <option value="Pix">Pix</option>
                                    <option value="Débito">Débito</option>
                                    <option value="Dinheiro">Dinheiro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1 mt-5 mx-auto">
                            <div class="row d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>
                    
                    </form>

</x-app-layout>