@extends('layouts.tablaIndex')

@section('title', 'Bolsas')

@section('imgUrl',  asset('images/bolsa-de-papel.svg'))

@section('namePage', 'Bolsas')

@section('route', route('bag.create'))

@section('table')
<tr>
    <th scope="col"> # </th>
    <th scope="col"> Nomenclatura </th>
    <th scope="col"> Fecha Adquisición </th>
    <th scope="col"> Medida </th>
    <th scope="col"> Tipo </th>
    <th scope="col"> <span class="sr-only"> (botonConsultar) </span> </th>
</tr>
</thead>
<tbody>
    @foreach ($bags as $bag)
    <tr>
        <th scope="row" class="align-middle"> {{ $bag->id }} </th>
        <td class="align-middle"> {{ $bag->nomenclatura }} </td>
        <td class="align-middle"> {{ $bag->fechaFinTrabajo }} </td>
        <td class="align-middle"> {{ $bag->medida }} </td>
        <td class="align-middle"> {{ $bag->tipo }} </td>
        <td><a href="{{ route('bag.show', $bag) }}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
    </tr>
    @endforeach
@endsection