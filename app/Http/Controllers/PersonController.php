<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PersonResource;
use Illuminate\Support\Facades\Validator;

Use App\Models\Person;

class PersonController extends Controller
{
    public function show($id){

      $person = Person::find($id);
      if(!$person){
        return response()->json(['data'=>[],'message'=>'No existen registros con el ID enviado o el tipo de dato no es correcto.'],200);
      }

      return new PersonResource($person);
    }
}
