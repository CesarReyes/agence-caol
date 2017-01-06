<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helper
{
    public static function monthsOpt()
    {
        ?>
            <option value="1">Ene</option>
            <option value="2">Feb</option>
            <option value="3">Mar</option>
            <option value="4">Abr</option>
            <option value="5">May</option>
            <option value="6">Jun</option>
            <option value="7">Jul</option>
            <option value="8">Ago</option>
            <option value="9">Sep</option>
            <option value="10">Oct</option>
            <option value="11">Nov</option>
            <option value="12">Dic</option>
        <?php
    }

    public static function yearsOpt($yr_list = [])
    {
        if(!count($yr_list)){
            $min_max = DB::select("SELECT
                    year( min(data_emissao) ) as min_year,
                    year( max(data_emissao) ) as max_year
                FROM cao_fatura");
            for($i = $min_max[0]->min_year; $i <= $min_max[0]->max_year; $i++) 
                $yr_list[] = $i;
        }

        foreach($yr_list as $y):
        ?>
            <option value="<?php echo $y?>"><?php echo $y?></option>
        <?php
        endforeach;
    }

    public static function getConsultants()
    {
        return DB::select("SELECT 
                    u.co_usuario,
                    u.no_usuario
                FROM permissao_sistema ps, cao_usuario u
                WHERE 
                ps.in_ativo = 'S'
                AND ps.co_tipo_usuario IN (0,1 ,2)
                AND ps.co_sistema = 1
                AND ps.co_usuario = u.co_usuario
                ORDER BY u.no_usuario");
    }

    public static function htmlConsultants()
    {
        $consultants = Helper::getConsultants();
        foreach($consultants as $c):
        ?>
            <option value="<?php echo $c->co_usuario ?>"><?php echo $c->no_usuario?></option>
        <?php
        endforeach;
    }

    public static function format_money($number){
        return number_format ( $number , 2 , "," , "." );
    }

    public static function format_date_mon_year($date){
        if(!$date)
            return '';
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $parts = explode('-', $date);
        return "{$meses[$parts[1] - 1]} de {$parts[0]}";
    }

    public static function getReport($from, $to, $consultores){
        
        return DB::select("SELECT
                os.co_usuario, 
                (SELECT u.no_usuario FROM cao_usuario u WHERE u.co_usuario = os.co_usuario LIMIT 1) AS no_usuario,
                CONCAT(year(ft.data_emissao), '-', month(ft.data_emissao)) as fecha,
                ft.total,
                ft.valor,
                ft.comissao_cn,
                ft.total_imp_inc,
                SUM((ft.valor - (ft.valor * (ft.total_imp_inc / 100)))) AS beneficio_neto,
                (SELECT sa.brut_salario FROM cao_salario sa WHERE sa.co_usuario = os.co_usuario LIMIT 1) AS costo_fijo,
                SUM(((ft.valor - (ft.valor * (ft.total_imp_inc / 100))) * (ft.comissao_cn / 100))) AS comision
            FROM cao_os os, cao_fatura ft
            WHERE 
            os.co_usuario IN ('" . implode("','", $consultores) . "')
            AND os.co_os = ft.co_os
            AND ft.co_cliente IS NOT NULL
            AND ft.data_emissao BETWEEN '$from' AND '$to'
            AND os.co_sistema IS NOT NULL
            GROUP BY os.co_usuario,fecha
            ORDER BY os.co_usuario, ft.data_emissao ASC");
            
    }

    public static function getCake($from, $to, $consultores){
        return DB::select("SELECT 
                os.co_usuario, 
                (SELECT u.no_usuario FROM cao_usuario u WHERE u.co_usuario = os.co_usuario LIMIT 1) AS no_usuario, 
                SUM((ft.valor - (ft.valor * (ft.total_imp_inc / 100)))) AS beneficio_neto
            FROM cao_os os, cao_fatura ft 
            WHERE 
                os.co_usuario IN ('" . implode("','", $consultores) . "') 
                AND os.co_os = ft.co_os 
                AND ft.co_cliente IS NOT NULL 
                AND ft.data_emissao BETWEEN '$from' AND '$to' 
                AND os.co_sistema IS NOT NULL 
                GROUP BY os.co_usuario 
                ORDER BY os.co_usuario");
    }

}