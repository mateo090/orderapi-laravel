<?php

namespace App\Http\Controllers;

use App\Models\TypeActivity;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CausalController extends Controller
{
    private $rules = [
        'description' => 'required|string|max:50|min:3',        
    ];

    private $traductionAttributes = array(
        'description' => 'descripción',
    );

    public function applyValidator(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);
        $data =[];
        if($validator->fails())
        {
            $data = response()->json([
                'errors'=> $validator->errors(),
                'data' => $request->all()
            ], Response::HTTP_BAD_REQUEST);
        }

        return $data;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $type_activitys = TypeActivity::all();
      return response()->json($type_activitys, Response::HTTP_OK);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->applyValidator($request);
        if(!empty($data))
        {
            return $data;
        }

        $type_activity = TypeActivity::create($request->all());
        $response=[
            'message'=> 'Registro creado exitosamente',
            'type_activity'=> $type_activity
        ];
        return response()->json($response, Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeActivity $type_activity)
    {
        return response()->json($type_activity, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeActivity $type_activity)
    {
        $data = $this->applyValidator($request);
        if(!empty($data))
        {
            return $data;
        }

        $type_activity->update($request->all());
        $response=[
            'message'=> 'Registro actualizado exitosamente',
            'type_activity'=> $type_activity
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeActivity $type_activity)
    {
        $type_activity->delete();
        $response=[
            'message'=> 'Registro Eliminado exitosamente',
            'type_Activity'=> $type_activity->id
        ];
        return response()->json($response, Response::HTTP_OK);
    }

}