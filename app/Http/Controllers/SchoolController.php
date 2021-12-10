<?php

namespace App\Http\Controllers;

use App\Helpers\{ImageHandler, SchoolHelper, ResponseBuilder};
use App\Http\Resources\SchoolResource;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) return ResponseBuilder::buildErrorResponse('Your request is invalid', $validator->errors(), 400);

        if ($request->hasFile('profile_picture')) $request->profile_picture = ImageHandler::store($request->file('profile_picture'), 'school/profiles', 'public');

        if ($request->hasFile('cover')) $request->cover = ImageHandler::store($request->file('cover'), 'schools/covers', 'public');

        $request->user()->schools()->create([
            'name' => $request->name,
            'profile_picture' => $request->profile_picture,
            'cover' => $request->cover,
            'description' => $request->description,
            'address' => $request->address,
            'code' => SchoolHelper::generate_code(),
        ]);

        return ResponseBuilder::buildResponse('School created successfuly', []);
    }

    public function update($code, Request $request)
    {
        $school = School::where('code', $code)->first();

        if(!$school) return ResponseBuilder::buildErrorResponse('School Not Found', [], 404);

        $validator = $this->validator($request->all());

        if ($validator->fails()) return ResponseBuilder::buildErrorResponse('Your request is invalid', $validator->errors(), 400);

        if ($request->hasFile('profile_picture')) $request->profile_picture = ImageHandler::store($request->file('profile_picture'), 'school/profiles', 'public');
        else $request->profile_picture = $school->profile_picture;

        $school->update([
            'name' => $request->name,
            'profile_picture' => $request->profile_picture,
            'cover' => $request->cover,
            'description' => $request->description,
            'address' => $request->address,
        ]);

        return ResponseBuilder::buildResponse('School updated successfuly', []);
    }

    public function show($code)
    {
        $school = School::where('code', $code)->first();

        if(!$school) return ResponseBuilder::buildErrorResponse('School Not Found', [], 404);

        return new SchoolResource($school);
    }

    public function destroy($code)
    {
        $school = School::where('code', $code)->first();

        if(!$school) return ResponseBuilder::buildErrorResponse('School Not Found', [], 404);

        $school->delete();

        return ResponseBuilder::buildResponse('School deleted successfuly', []);
    }

    public function validator($data)
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'min:5', 'max:32'],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
            'cover' => ['nullable', 'image', 'max:2048'],
        ]);

        return $validator;
    }
}
