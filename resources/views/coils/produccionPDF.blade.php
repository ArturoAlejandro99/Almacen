<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    table{
        width: 100%;
        border-spacing: 0px;
    }
    .bigWidth{
        width: 120px;
    }

    .smallWidth{
        width: 90px;
        padding-left: 6px;
    } 

    th{
        background-color: #3490dc;
        height: 25px;
        text-align: left;
    } 

    tr:nth-child(even){
        background-color: rgba(0, 0, 0, 0.05);
    }  
    </style>
</head>
<body>
    <table class="table table-striped my-4" id="tabla">
        <thead class="bg-info">
            <tr>
                <th scope="col" class="bigWidth" >Bobina</th>
                <th class="smallWidth">Medida</th>
                <th class="smallWidth">Peso</th>
                <th class="bigWidth">Rollos</th>
                <th class="smallWidth">Peso</th>
                <th class="bigWidth">Bolsas</th>
                <th class="smallWidth">Peso</th>
                <th class="smallWidth">Medida</th>
                <th class="smallWidth">Unidad</th>
                <th class="smallWidth">Cantidad</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach($produccion as $bobina)
            @php
            $BanderaBobina = true;  
            @endphp
            <tr>
                {{-- Escribe bobinas --}}
                <td class="bigWidth">{{$bobina->nomenclatura}}</td>
                <td class="smallWidth">{{$bobina->coilType->alias}}</td>
                <td class="smallWidth">{{$bobina->pesoBruto}}</td>
                {{-- Escribe rollos --}}
               @if ($bobina->ribbons->isEmpty() && $bobina->related->isEmpty())
                    <td class="bigWidth">_</td>
                    <td class="smallWidth">_</td>
                    <td class="smallWidth">_</td>
                    <td class="smallWidth">_</td>
                    <td class="smallWidth">_</td>
                    <td class="smallWidth">_</td>
                    <td class="smallWidth">_</td>
               @endif
                @foreach ($bobina->ribbons as $ribbon)
                    @if ($BanderaBobina == false )
                    {{--Si ya se imprimio la bobina perteneciente a este rollo deja los espacios en blanco de bobina--}}
                        <tr>
                        <td class="bigWidth">_</td>
                        <td class="smallWidth">_</td>
                        <td class="smallWidth">_</td>
                    @endif
                    {{--imprime el rollo--}}
                    <td class="bigWidth">{{$ribbon->nomenclatura}}</td>
                    <td class="smallWidth">{{$ribbon->peso}}</td>
                    @php
                        $rollo =  true
                    @endphp
                    {{--Si no tiene bolsas el rollo entonces deja vacio--}}
                    @if (!$ribbon->related->isEmpty())
                        @foreach ($ribbon->related as $bolsas)
                        {{--si ya se imprimio la información del rollo--}}
                                @if ($rollo == false )
                                    <tr>
                                    <td class="smallWidth">_</td>
                                    <td class="smallWidth">_</td>
                                    <td class="smallWidth">_</td>
                                    <td class="smallWidth">_</td>
                                    <td class="smallWidth">_</td>
                                @endif
                                {{--Si no imprime la info de las bolsas--}}
                                <td class="bigWidth">{{$bolsas->nomenclatura}}</td>
                                <td class="smallWidth">{{$bolsas->peso}}</td>
                                <td class="smallWidth">{{($bolsas->medidaBolsa == null)?'-':$bolsas->medidaBolsa}}</td>
                                <td class="smallWidth">{{($bolsas->unidad == null)?'-':$bolsas->unidad}}</td>
                                <td class="smallWidth">{{($bolsas->cantidad == null)?'-':$bolsas->cantidad}}</td>
                            </tr>
                            @php
                                $rollo =  false
                            @endphp
                        @endforeach                 
                    @else
                    {{--Deja los espacios vacios en caso de que no tenga bolsas relacionadas al rollo--}}
                        <td class="bigWidth">_</td>
                        <td class="smallWidth">_</td>
                        <td class="smallWidth">_</td>
                        <td class="smallWidth">_</td>
                        <td class="smallWidth">_</td>
                        </tr>
                    @endif
                    @php
                    $BanderaBobina = false;  
                    @endphp
                @endforeach
                {{--imprime las mermas y los huesos de las bobinas--}}
                @foreach ($bobina->related as $coilProduct)
                    @if ($coilProduct->coil_product_type != "App\Models\Ribbon")
                        @if ($BanderaBobina == false )
                            {{--Si ya se imprimio la bobina perteneciente a este rollo deja los espacios en blanco de bobina--}}
                            <tr>
                            <td class="bigWidth">_</td>
                            <td class="smallWidth">_</td>
                            <td class="smallWidth">_</td>
                        @endif
                        {{--Sino imprime la el producto de bobina y pone vacios los campos de bolsas--}}
                        <td class="bigWidth">{{$coilProduct->nomenclatura}}</td>
                        <td class="smallWidth">{{$coilProduct->peso}}</td>
                        <td class="bigWidth">_</td>
                        <td class="smallWidth">_</td>
                        <td class="smallWidth">_</td>
                        <td class="smallWidth">_</td>
                        <td class="smallWidth">_</td>
                    @endif
                    {{--Termina la linea y da salto--}}
                    </tr>
                    @php
                        $BanderaBobina = false;  
                    @endphp
                @endforeach
                </tr>
            @endforeach
            </tbody>
    </table>
</body>
</html>