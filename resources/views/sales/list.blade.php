@forelse($products as $product)
  <a href="#" data-unit="{{$product->id}}"  data-price="{{$product->price}}" data-volumen="{{$product->volumen}}" data-name="{{$product->name}}" class="list-group-item list-group-item-action"> {{$product->name}} <sub>{{$product->volumen}}</sub> BOB.{{$product->price}} </a>
@empty
    <p class="list-group-item list-group-item-action">No se encuentran coincidencias</p>

@endforelse
