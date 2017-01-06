<?php
//echo '<pre>',print_r($data),'</pre>';
?>
@if(count($data))

@foreach($data as $consultor)
<div class="well bs-component table-responsive">
    <table class="table table-hover ">
        <thead>
            <tr>
                <td colspan="5"><strong>{{$consultor['name']}}</strong></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Período</strong></td>
                <td><strong>Beneficio Neto</strong></td>
                <td><strong>Costo Fijo</strong></td>
                <td><strong>Comisión</strong></td>
                <td><strong>Ingresos</strong></td>
            </tr>
            @foreach($consultor['data'] as $row)
            <tr>
                <td>{!! Helper::format_date_mon_year($row->fecha) !!}</td>
                <td class="text-right">R$ {!! Helper::format_money($row->beneficio_neto) !!}</td>
                <td class="text-right">- R$ {!! Helper::format_money($row->costo_fijo) !!}</td>
                <td class="text-right">- R$ {!! Helper::format_money($row->comision) !!}</td>
                @if($row->ganancia < 0)
                <td class="text-right money-losts">- R$ {!! Helper::format_money($row->ganancia) !!}</td>
                @else
                <td class="text-right">R$ {!! Helper::format_money($row->ganancia) !!}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr bgcolor="#efefef">
                <td><strong>SALDO</strong></td>
                <td class="text-right">R$ {!! Helper::format_money($consultor['t_beneficio']) !!}</td>
                <td class="text-right">- R$ {!! Helper::format_money($consultor['t_costo']) !!}</td>
                <td class="text-right">- R$ {!! Helper::format_money($consultor['t_comision']) !!}</td>
                @if($consultor['t_ganacia'] < 0)
                <td class="text-right money-losts">R$ {!! Helper::format_money($consultor['t_ganacia']) !!}</td>
                @else
                <td class="text-right money-earnings">R$ {!! Helper::format_money($consultor['t_ganacia']) !!}</td>
                @endif
            </tr>
        </tfoot>
    </table>
</div>
@endforeach

@endif