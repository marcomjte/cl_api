<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PersonResource;
use App\Http\Resources\PersonCollection;
use Illuminate\Support\Facades\Validator;

Use App\Models\Person;
Use App\Models\Phone;
Use App\Models\Email;
Use App\Models\Address;

class PersonController extends Controller
{
    public function getAll(){
      return new PersonCollection(Person::all());
    }

    public function store(Request $request){
      try{
        $validate = Validator::make($request->all(), [
          'name' => 'required|string|max:250'
        ]);

        if($validate->fails()){
          return response()->json([
              'data' => [],
              'message' => $validate->errors()
          ], 403);
        }

        $person = new Person();
        $person->name = $request->name;
        $person->note = $request->note;
        $person->date_of_birth = $request->date_of_birth;
        $person->url_web_age = $request->url_web_age;
        $person->work_company = $request->work_company;
        $person->save();

        if($request->phones && count($request->phones) > 0){
          foreach ($request->phones as $key => $item) {
            $phone = new Phone();
            $phone->phone_number = $item["phone_number"];
            $phone->person_id = $person->id;
            $phone->save();
          }
        }

        if($request->emails && count($request->emails) > 0){
          foreach ($request->emails as $key => $item) {
            $email = new Email();
            $email->email = $item["email"];
            $email->person_id = $person->id;
            $email->save();
          }
        }

        if($request->addresses && count($request->addresses) > 0){
          foreach ($request->addresses as $key => $item) {
            $address = new Address();
            $address->address = $item["address"];
            $address->person_id = $person->id;
            $address->save();
          }
        }
        return response()->json(['data'=>[],'message'=>'El registro se ha realizado correctamente.'],200);
      }catch(Exception $e){
        return response()->json(['data'=>[],'message'=>'Ocurrió un problema al intentar realizar la petición, revisa los datos o vuelve a intentar. - '.$e->getMessage()],403);
      }
    }

    public function update(Request $request, $id){
      try{
        $validate = Validator::make($request->all(), [
          'name' => 'required|string|max:250'
        ]);

        if($validate->fails()){
          return response()->json([
              'data' => [],
              'message' => $validate->errors()
          ], 403);
        }

        $person = Person::find($id);
        $person->name = $request->name;
        $person->note = $request->note;
        $person->date_of_birth = $request->date_of_birth;
        $person->url_web_age = $request->url_web_age;
        $person->work_company = $request->work_company;
        $person->save();

        if($request->phones && count($request->phones) > 0){
          foreach ($request->phones as $key => $item) {
            if($item["id"] != "0"){
              $phone = Phone::find($item["id"]);
            }else{
              $phone = new Phone();
            }
            $phone->phone_number = $item["phone_number"];
            $phone->person_id = $person->id;
            $phone->save();
          }
        }

        if($request->emails && count($request->emails) > 0){
          foreach ($request->emails as $key => $item) {
            if($item["id"] != "0"){
              $email = Email::find($item["id"]);
            }else{
              $email = new Email();
            }
            $email->email = $item["email"];
            $email->person_id = $person->id;
            $email->save();
          }
        }

        if($request->addresses && count($request->addresses) > 0){
          foreach ($request->addresses as $key => $item) {
            if($item["id"] != "0"){
              $address = Address::find($item["id"]);
            }else{
              $address = new Address();
            }
            $address->address = $item["address"];
            $address->person_id = $person->id;
            $address->save();
          }
        }
        return response()->json(['data'=>[],'message'=>'El registro se ha realizado correctamente.'],200);
      }catch(Exception $e){
        return response()->json(['data'=>[],'message'=>'Ocurrió un problema al intentar realizar la petición, revisa los datos o vuelve a intentar. - '.$e->getMessage()],403);
      }
    }

    public function show($id){
      $person = Person::find($id);
      if(!$person){
        return response()->json(['data'=>[],'message'=>'No existen registros con el ID enviado o el tipo de dato no es correcto.'],403);
      }
      return new PersonResource($person);
    }

    public function destroy($id){
      $person = Person::find($id);
      if(!$person){
        return response()->json(['data'=>[],'message'=>'No existen registros con el ID enviado o el tipo de dato no es correcto.'],403);
      }
      Person::destroy($id);
      return response()->json(['data'=>[],'message'=>'El registro se ha eliminado correctamente.'],200);
    }
}
