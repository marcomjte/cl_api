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
    public function getAll(Request $request){
      $valueSearch = $request->query('valueSearch');
      $persons = Person::join('phone', 'phone.person_id', '=', 'person.id')
        ->join('email', 'email.person_id', '=', 'person.id')
        ->join('address', 'address.person_id', '=', 'person.id')
        ->where(function ($query) use($valueSearch){
          $query
            ->orWhere('person.id', '=', '%'.$valueSearch)
            ->orWhere('person.name', 'like', '%'.$valueSearch.'%')
            ->orWhere('phone.phone_number', 'like', '%'.$valueSearch.'%')
            ->orWhere('email.email', 'like', '%'.$valueSearch.'%')
            ->orWhere('address.address', 'like', '%'.$valueSearch.'%');
        })
        ->select('person.*')
        ->groupBy('person.id')
        ->limit(10)
        ->paginate(30);
      return new PersonCollection($persons);
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
        $person->url_web_page = $request->url_web_page;
        $person->work_company = $request->work_company;
        $person->save();

        if($request->phones && count($request->phones) > 0){
          foreach ($request->phones as $key => $item) {
            $phone = new Phone();
            $phone->phone_number = $item;
            $phone->person_id = $person->id;
            $phone->save();
          }
        }

        if($request->emails && count($request->emails) > 0){
          foreach ($request->emails as $key => $item) {
            $email = new Email();
            $email->email = $item;
            $email->person_id = $person->id;
            $email->save();
          }
        }

        if($request->addresses && count($request->addresses) > 0){
          foreach ($request->addresses as $key => $item) {
            $address = new Address();
            $address->address = $item;
            $address->person_id = $person->id;
            $address->save();
          }
        }
        return response()->json(['status' => 'success', 'data'=>[], 'message'=>'El registro se ha realizado correctamente.'],200);
      }catch(Exception $e){
        return response()->json(['status' => 'error', 'data'=>[], 'message'=>'Ocurrió un problema al intentar realizar la petición, revisa los datos o vuelve a intentar. - '.$e->getMessage()],403);
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
        $person->url_web_page = $request->url_web_page;
        $person->work_company = $request->work_company;
        $person->save();

        if($request->phones && count($request->phones) > 0){
          // Se borran registros eliminados desde sistema front end
          $deletes = Phone::whereNotIn('phone_number', $request->phones)->where('person_id', '=', $person->id)->delete();

          foreach ($request->phones as $key => $item) {
            $phone = Phone::where('phone_number', '=', $item)->where('person_id', '=', $person->id)->first();
            // Registramos los nuevos datos
            if(!$phone){
              $phone = new Phone();
              $phone->phone_number = $item;
              $phone->person_id = $person->id;
              $phone->save();
            }
          }
        }

        if($request->emails && count($request->emails) > 0){
          // Se borran registros eliminados desde sistema front end
          $deletes = Email::whereNotIn('email', $request->emails)->where('person_id', '=', $person->id)->delete();

          foreach ($request->emails as $key => $item) {
            $email = Email::where('email', '=', $item)->where('person_id', '=', $person->id)->first();
            // Registramos los nuevos datos
            if(!$email){
              $email = new Email();
              $email->email = $item;
              $email->person_id = $person->id;
              $email->save();
            }
          }
        }

        if($request->addresses && count($request->addresses) > 0){
          // Se borran registros eliminados desde sistema front end
          $deletes = Address::whereNotIn('address', $request->addresses)->where('person_id', '=', $person->id)->delete();

          foreach ($request->addresses as $key => $item) {
            $address = Address::where('address', '=', $item)->where('person_id', '=', $person->id)->first();
            // Registramos los nuevos datos
            if(!$address){
              $address = new Address();
              $address->address = $item;
              $address->person_id = $person->id;
              $address->save();
            }
          }
        }
        return response()->json(['status' => 'success', 'data'=>[],'message'=>'El registro se ha realizado correctamente.'],200);
      }catch(Exception $e){
        return response()->json(['status' => 'error', 'data'=>[],'message'=>'Ocurrió un problema al intentar realizar la petición, revisa los datos o vuelve a intentar. - '.$e->getMessage()],403);
      }
    }

    public function getByID($id){
      $person = Person::find($id);
      if(!$person){
        return response()->json(['status' => 'error', 'data'=>[],'message'=>'No existen registros con el ID enviado o el tipo de dato no es correcto.'],403);
      }
      return new PersonResource($person);
    }

    public function destroy($id){
      $person = Person::find($id);
      if(!$person){
        return response()->json(['status' => 'error', 'data'=>[],'message'=>'No existen registros con el ID enviado o el tipo de dato no es correcto.'],403);
      }
      Person::destroy($id);
      return response()->json(['status' => 'success', 'data'=>[],'message'=>'El registro se ha eliminado correctamente.'],200);
    }
}
