<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends BaseController
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function viewRegistUser()
    {
        $title = 'User Registration';
        $name = Auth::user()->name;
        return view('user.userRegistrationForm', compact('title', 'name'));
    }

    public function saveUsers(Request $request)
    {
        if (!$request->has('user') || empty($request->input('user'))) {
            return response()->json(['errors' => 'Nothing to save'], 500);
        }

        $users = $request->input('user');
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($users as $index => $userData) {
                $rules = [
                    'name' => 'required|string|max:255',
                    'gender' => 'required|integer|in:0,1',
                    'phone_number' => [
                        'required',
                        'string',
                        'max:15',
                        Rule::unique('users', 'phone_number')->ignore($userData['id'] ?? null),
                        'regex:/^08[0-9]{1,2}-?[0-9]{4}-?[0-9]{4,5}$/',
                    ],
                    'position' => 'required|integer|in:0,1,2,3',
                    'line_id' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('users', 'line_id')->ignore($userData['id'] ?? null),
                    ],
                    'consumption_type' => 'required|integer|in:0,1,2',
                    'food_allergy' => 'nullable|string|max:255',
                    'drug_allergy' => 'nullable|string|max:255',
                    'medical_history' => 'nullable|string|max:255',
                ];

                if (!isset($userData['id']) || $request->hasFile("user.{$index}.student_card")) {
                    $rules['student_card'] = 'file|mimes:jpeg,png,pdf|max:2048';
                }

                $validator = Validator::make($userData, $rules);

                if ($validator->fails()) {
                    $role = match ($index) {
                        0 => 'Leader form:',
                        1 => '1st member:',
                        2 => '2nd member:',
                        3 => '3rd member:',
                        default => '',
                    };
                    $errors["user[{$index}]"] = [$role, ...$validator->errors()->all()];
                    continue;
                }

                $validated = $validator->validated();
                $validated['team_id'] = session('team_id');
                if ($request->hasFile("user.{$index}.student_card")) {
                    $validated['student_card'] = $request->file("user.{$index}.student_card")
                        ->store('student_cards', 'public');
                }
                if ($request->hasFile("user.{$index}.student_card")) {
                    $studentCardFile = $request->file("user.{$index}.student_card");
                    $fileName = sprintf(
                        'student_card_%s_%s_%s.%s',
                        $userData['phone_number'],
                        $userData['line_id'],
                        now()->format('YmdHis'),
                        $studentCardFile->getClientOriginalExtension()
                    );
                    $filePath = $studentCardFile->storeAs('student_cards', $fileName, 'public');
                    $validated['student_card'] = 'storage/' . $filePath;
                } elseif (isset($userData['id'])) {
                    $validated['student_card'] = session('users')[$index]['student_card'];
                }

                if (!empty($validated['student_card'])) {
                    $users[$index]['student_card'] = $validated['student_card'];
                }

                if (isset($userData['id'])) {
                    $user = $this->model::findOrFail($userData['id']);
                    $user->update($validated);
                } else {
                    $user = $this->model::create($validated);
                }

                $users[$index]['id'] = $user->id;
            }

            if (!empty($errors)) {
                DB::rollBack();
                return response()->json(['errors' => $errors], 422);
            }
            DB::commit();
            session(['users' => $users]);
            return response()->json(['message' => 'Users saved successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Failed to save users.'], 500);
        }
    }
}
