<x-app-layout>
  <script>
  setTimeout(() => {
    const box = document.getElementById('box-message');

    // 👇️ removes element from DOM
    box.style.display = 'none';

    // 👇️ hides element (still takes up space on page)
    // box.style.visibility = 'hidden';
  }, 1000);
  </script>

  @include('layouts.header')

  <div class="row">

    <div class="col-md-2 -lg bg-light min-h-100">
      @include('layouts.sidebar')
    </div>
    <div class="col-md-9 mt-5">
      <div class="container">
        <div class="row">
          <h1 id="font" class="text-center fs-2">Produto {{$product->name}}</h1>
          @if($errors->any())
          <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
            {{ $error }}<br>
            @endforeach
          </div>
          @endif
          <form class="contact-form row" action="{{route('admin.products.update', $product->id )}}" method="POST"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-field col-lg-6">
              <input id="name" name="name" class="input-text js-input" type="text" value="{{$product->name}}" required>
              <label class="label" for="name">Nome</label>
            </div>
            <div class="form-field col-lg-6 ">
              <input id="atCost" name="atCost" class="input-text js-input" type="number" step="0.01" min="0"
                value="{{ $product->atCost }}" required>
              <label class="label" for="value">Preco de Custo</label>
            </div>
            <div class="form-field col-lg-6 ">
              <input id="salesPrice" name="salesPrice" class="input-text js-input" type="number" step="0.01" min="0"
                value="{{ $product->salesPrice }}" required>
              <label class="label" for="value">Preco de Venda</label>
            </div>
            <div class="form-field col-lg-6 ">
              <input id="quantity" name="quantity" class="input-text js-input" type="number"
                value="{{ $product->quantity }}" required>
              <label class="label" for="quantity">Quantidade</label>
            </div>
            <div class="form-field col-lg-12">
              <input id="description" name="description" class="input-text js-input" type="text"
                value="{{ $product->description }}" required>
              <label class="label" for="description">Descricao</label>
            </div>
            <div class="form-field col-lg-16 ">
              <input id="image_products" type="file" class="input-text js-input" name="image_products" />
              <label for="image_products" class="form-label">Selecione uma imagem</label>
            </div>
            <div class="form-field col-lg-12 d-grid gap-2 d-md-flex justify-content-md-end">
              <button type="submit" class="custom-btn btn-11">Confirmar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>