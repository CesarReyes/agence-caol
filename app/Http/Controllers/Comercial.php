<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class Comercial extends Controller
{
    /**
     * Show the performance view
     */
    public function performance(Request $request)
    {
        $view_params = [];

        //Getting the POST data
        $from = $request->input('from-year') . '-' . $request->input('from-month');
        $to = $request->input('to-year') . '-' . $request->input('to-month');
        $consultores = $request->input('consultores');
        $action = $request->input('_action');

        if($action){
            //Defining the dates
            $from = "$from-01";
            $to = "$to-01";
            $to = date("Y-m-t", strtotime($to));

            //Factory
            $func = "get_$action";

            $view_params['action'] = $action;
            $view_params['data'] = $this->$func($from, $to, $consultores);
        }

        return view('comercial.performance',$view_params);
    }

    private function get_report($from, $to, $consultores){

        $result = Helper::getReport($from, $to, $consultores);

        //Making the struct and calculating the "Lucro"
        $data = [];
        foreach($result as $row){
            $row->ganancia = $row->beneficio_neto - ($row->costo_fijo + $row->comision);
            $data[$row->co_usuario]['name'] = $row->no_usuario;

            if(!isset($data[$row->co_usuario]['t_beneficio'])) $data[$row->co_usuario]['t_beneficio'] = 0;      
            $data[$row->co_usuario]['t_beneficio'] += $row->beneficio_neto;

            if(!isset($data[$row->co_usuario]['t_costo'])) $data[$row->co_usuario]['t_costo'] = 0;
            $data[$row->co_usuario]['t_costo'] += $row->costo_fijo;

            if(!isset($data[$row->co_usuario]['t_comision'])) $data[$row->co_usuario]['t_comision'] = 0;
            $data[$row->co_usuario]['t_comision'] += $row->comision;

            if(!isset($data[$row->co_usuario]['t_ganacia'])) $data[$row->co_usuario]['t_ganacia'] = 0;
            $data[$row->co_usuario]['t_ganacia'] += $row->ganancia;

            $data[$row->co_usuario]['data'][] = $row;
        }
        
        return $data;
    }

    private function get_graph($from, $to, $consultores){
        $result = Helper::getReport($from, $to, $consultores);

        //Making the struct
        $data = [];
        $cols = [];
        $costos = [];
        $dates = [];

        foreach($result as $row){
            $cols[$row->no_usuario] = (float) $row->beneficio_neto;
            $dates[$row->fecha] = 1;
            $data[$row->fecha][$row->no_usuario] = $row->beneficio_neto;
        }
        $costos = $cols;
        $cols = array_keys($cols);
        $dates = array_keys($dates);
        $promedio = array_sum($costos) / count($costos);
        $ndata = [];
        foreach($data as $date => $row){
            foreach($cols as $col){
                $nrow[$col] = isset($row[$col]) ? (float) $row[$col] : 0;
            }
            $ndata[$date] = $nrow;
        }

        array_unshift($cols, 'Fecha');
        array_push($cols, "Costo Fijo Medio");
        $final[] = $cols;
        unset($nrow);
        foreach($ndata as $date => $row){
    
            $nrow = array_values($row);
            array_unshift($nrow, str_replace('-', '/', $date));
            array_push($nrow, $promedio);
            $final[] = $nrow;
        }
        
        $range = [
            Helper::format_date_mon_year(array_shift($dates)),
            Helper::format_date_mon_year(array_pop($dates))
        ];
        
        //var_dump($range);
        return ['final' => $final, 'range' => $range];
    }

    private function get_cake($from, $to, $consultores){
        $result = Helper::getCake($from, $to, $consultores);

        return $result;
    }

}