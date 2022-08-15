<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Academico_matricula;

class Academico_matriculaController extends Controller
{
    /**
     * Devuelve un mensaje con estado falso y el mensaje de error
     *
     * @param  int  $codigo
     * @param  String  $mensaje
     * @return \Illuminate\Http\Response
     */
    function errors(Int $codigo, String $mensaje){

        return response()->json([
            'status' => false,
            'message' => $mensaje,
        ], $codigo);

    }


    /**
     * Devuelve los datos del estudiante consultado
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(!isset($request->codigo) or !is_numeric($request->codigo)){

            return $this->errors(400, 'El codigo del estudiante es requerido y debe ser tipo numerico');
        }

        $academicoMatricula = Academico_matricula::
        where("mat_id","=", $request->codigo)
        ->get();

        $matriculaExiste = count($academicoMatricula->all());
        if($matriculaExiste === 0){
            return $this->errors(200, 'No existe ningún estudiante con este código.');  
        }

        $resultado = json_decode($academicoMatricula, true);

        return response()->json([
            'status' => true,
            'datos' => [
                "id" => $academicoMatricula[0]['mat_id'],
                "apellidoUno" => $academicoMatricula[0]['mat_primer_apellido'],
                "apellidoDos" => $academicoMatricula[0]['mat_segundo_apellido'],
                "nombres" => $academicoMatricula[0]['mat_nombres']
            ]
        ], 200);


    }

    
}
