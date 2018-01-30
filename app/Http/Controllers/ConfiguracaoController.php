<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    public function createform(){
        $arquivo = "/var/www/html/asklunch/android/config.txt";
        $array = array();
        if (!file_exists($arquivo)) {
            touch($arquivo);
            return view('config.configuracao');
        }else{
            if ( 0 != filesize($arquivo)) {
                $fp = fopen($arquivo, "r");
                $i=0;
                while (!feof ($fp)) {
                    $valor = fgets($fp, 4096);
                    if ((strpos($valor, 'HORÁRIO_INÍCIO') !== FALSE) || strpos($valor, 'HORÁRIO_TÉRMINO') !== FALSE) {
                        $result = explode("=", $valor);
                        $array[$i] = $result[1];
                        $i++;
                    }

                }
                fclose($fp);
                $horarioIni = explode(":", $array[0]);
                $horasIni = (int) $horarioIni[0];
                $minutosIni = (int) $horarioIni[1];
                $horarioFim = explode(":", $array[1]);
                $horasFim = (int) $horarioFim[0];
                $minutosFim = (int) $horarioFim[1];
                return view('config.configuracao',compact('horasIni','minutosIni',
                    'horasFim','minutosFim'));
            }else{
                return view('config.configuracao');
            }
        }
    }
    public function save(Request $request){
        $horarioIni = $request->input('horasIni') . ":" . $request->input('minutosIni') . ":00";
        $horarioFim = $request->input('horasFim') . ":" . $request->input('minutosFim') . ":00";

        $arquivo = "/var/www/html/asklunch/android/config.txt";

        $fp = fopen($arquivo, "r+");
        fwrite ($fp, "HORÁRIO_INÍCIO=".$horarioIni."\n");
        fwrite ($fp, "HORÁRIO_TÉRMINO=".$horarioFim."\n");
        fclose($fp);

        return redirect('configuracao');

    }
}
