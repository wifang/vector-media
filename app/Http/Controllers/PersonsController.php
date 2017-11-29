<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Person;
use App\Interest;
use App\Person_interests;
use DB;

class PersonsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function index()
    {  
         $person =  DB::table('persons')
            ->select('persons.first_name', 'persons.last_name', 'persons.email', 'persons.age', 'persons.admission_date_time', 'persons.is_active')              
            ->get();
       
         $interest =  DB::table('person_interests')
            ->join('persons', 'person_interests.person_id', '=', 'persons.id')
            ->join('interests', 'person_interests.interest_id', '=', 'interests.id')
            ->select('persons.first_name', 'persons.last_name', 'persons.email', 'persons.age', 'persons.admission_date_time', 'persons.is_active', 'interests.name') 
            ->distinct()     
            ->get();
        if(!empty($person[0])){ 
             $data['person'] = $person;
             $data['interest'] = $interest;

               return view('index', ['data'=>$data]);
        }else{

            return view('no_data');
        }
    }
        
    public function post(Request $request)
    {  
        
       // $this->validate($request,['address'=>'required']);
        $this->validate($request, [
        'first_name' => 'required',
        'last_name' => 'required',    
        'age' => 'required', 
        'admission_date' => 'required', 
        'admission_time' => 'required', 
        'email' => 'required',
        'interests'=>'required'   
            
    ]);
        
        //  create person object and save person
       $person = new Person();
       
       $person->first_name = $request->get('first_name');
       $person->last_name = $request->get('last_name'); 
       $person->age = $request->get('age'); 
       $admission_date = $request->get('admission_date'); 
       $admission_time = $request->get('admission_time'); 
       $person->admission_date_time =$admission_date.' '. date("H:i", strtotime($admission_time));
       $person->email = $request->get('email'); 
       $person->is_active = $request->get('is_active');
     
       $person->save();
       
       $interests = $request->get('interests');
       // create interest object
       
       
       foreach ( $interests as $v){
           //save interest
           $interest = new Interest();
           $exist =  DB::table('interests')
                ->where('name', $v)->first();
           
           if( !isset($exist)){
                $interest->name = $v;
                $interest->save();
           }else{
               $interest->id = $exist->id;
           }
           
           // save person interest
           $person_interest = new Person_interests();
           $person_interest->interest_id = $interest->id;
           $person_interest->person_id = $person->id;
           $person_interest->save();
       }
       
      
       //return view('index');
       
        return response()->json(['success' =>true
        ]);
        
    }

    //
}
