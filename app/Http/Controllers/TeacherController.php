<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $teachers = Teacher::orderBy('id','desc')->get();

        return view('admin.teachers.index', [
            'teachers' => $teachers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {
        //
        $validated=$request->validated();

        $user = User::where('email',$validated['email'])->first();

        if(!$user){
            return back()->withErrors([
                'email' => 'Data tidak ditemukan'
            ]);
        }

        
        if($user->hasRole('teacher')){
            return back()->withErrors([
                'email' => 'Email tersebut telah menjadi guru'
            ]);
        }

        DB::transaction(function()use ($user, $validated) {

            $validated['user_id'] = $user->id;
            $validated['is_active'] = true;

            Teacher::created($validated);

            if($user->hasRole('student')){
                $user->removeRole('student');
            }
            $user->assignRole('teacher');

        });

        return redirect()->route('admin.teachers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
}
