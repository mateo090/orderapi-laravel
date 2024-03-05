<?php

namespace App\Http\Controllers;

use App\Models\Technician;

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
      $technicians = Technician::all();
      return response()->json($technicians, Response::HTTP_OK);  
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

        $technician = Technician::create($request->all());
        $response=[
            'message'=> 'Registro creado exitosamente',
            'Technician'=> $technician
        ];
        return response()->json($response, Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Technician $technician)
    {
        return response()->json($technician, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technician $technician)
    {
        $data = $this->applyValidator($request);
        if(!empty($data))
        {
            return $data;
        }

        $technician->update($request->all());
        $response=[
            'message'=> 'Registro actualizado exitosamente',
            'technician'=> $technician
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technician $technician)
    {
        $technician->delete();
        $response=[
            'message'=> 'Registro Eliminado exitosamente',
            'technician'=> $technician->id
        ];
        return response()->json($response, Response::HTTP_OK);
    }

}