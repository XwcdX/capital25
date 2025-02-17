<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends BaseController
{
    protected $teamController;
    public function __construct(User $model)
    {
        parent::__construct($model);
        $this->teamController = new TeamController(new Team());
    }

    public function viewRegistUser()
    {
        $currentTeam = Auth::user();
        $title = 'User Registration';
        $name = $currentTeam->name;
        $proof = $currentTeam->proof_of_payment;
        return $proof !== null
            ? view('user.userRegistrationForm', compact('title', 'name', 'proof'))
            : view('user.userRegistrationForm', compact('title', 'name'));
    }


    public function saveUsers(Request $request)
    {
        if (!$request->has('user') || empty($request->input('user'))) {
            return response()->json(['errors' => 'Nothing to save'], 500);
        }

        $currentTeam = Auth::user();
        $users = $request->input('user');
        $proofOfPayment = $request->file('user.4.proof_of_payment');
        $errors = [];

        DB::beginTransaction();
        try {
            if ($currentTeam && $currentTeam->valid === 2) {
                $currentTeam->valid = 0;
                $currentTeam->save();
            }
            foreach ($users as $index => $userData) {
                $userId = $userData['id'] ?? null;
                $existingUser = $userId ? $this->model::find($userId) : null;
                $imageFields = ['student_card', 'twibbon'];

                $rules = [
                    'name' => 'required|string|max:255',
                    'gender' => 'required|integer|in:0,1',
                    'phone_number' => [
                        'required',
                        'string',
                        'max:15',
                        Rule::unique('users', 'phone_number')->ignore($userId),
                        'regex:/^08[0-9]{1,2}-?[0-9]{4}-?[0-9]{4,5}$/',
                    ],
                    'position' => 'required|integer|in:0,1,2,3',
                    'line_id' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('users', 'line_id')->ignore($userId),
                    ],
                    'consumption_type' => 'required|integer|in:0,1,2',
                    'food_allergy' => 'nullable|string|max:255',
                    'drug_allergy' => 'nullable|string|max:255',
                    'medical_history' => 'nullable|string|max:255',
                ];

                foreach ($imageFields as $field) {
                    if (!$userId || $request->hasFile("user.{$index}.{$field}")) {
                        $rules[$field] = 'file|mimes:jpeg,png,pdf|max:2048';
                    }
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
                $validated['team_id'] = $currentTeam->id;
                foreach ($imageFields as $field) {
                    if ($request->hasFile("user.{$index}.{$field}")) {
                        if ($existingUser && $existingUser->$field) {
                            Storage::disk('public')->delete(str_replace('storage/', '', $existingUser->$field));
                        }
                        $file = $request->file("user.{$index}.{$field}");
                        $fileName = sprintf(
                            '%s_%s_%s_%s.%s',
                            $field,
                            $userData['phone_number'],
                            $userData['line_id'],
                            now()->format('YmdHis'),
                            $file->getClientOriginalExtension()
                        );
                        $filePath = $file->storeAs("{$field}s", $fileName, 'public');
                        $validated[$field] = 'storage/' . $filePath;
                    } elseif ($existingUser) {
                        $validated[$field] = $existingUser->$field;
                    }
                }

                foreach ($imageFields as $field) {
                    if (!empty($validated[$field])) {
                        $users[$index][$field] = $validated[$field];
                    }
                }

                if ($existingUser) {
                    $existingUser->update($validated);
                } else {
                    $newUser = $this->model::create($validated);
                    $users[$index]['id'] = $newUser->id;
                }
            }

            if ($proofOfPayment) {
                $proofValidator = Validator::make(
                    ['proof_of_payment' => $proofOfPayment],
                    ['proof_of_payment' => 'file|mimes:jpeg,png,pdf|max:2048']
                );

                if ($proofValidator->fails()) {
                    $errors["user[4]"] = ['Proof of payment:', ...$proofValidator->errors()->all()];
                } else {
                    if ($currentTeam->proof_of_payment) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $currentTeam->proof_of_payment));
                    }

                    $fileName = sprintf(
                        'Proof_of_Payment_%s_CAPITAL_2025.%s',
                        $currentTeam->name,
                        $proofOfPayment->getClientOriginalExtension()
                    );

                    $filePath = $proofOfPayment->storeAs('proof_of_payment', $fileName, 'public');
                    $proofOfPaymentUrl = 'storage/' . $filePath;

                    $this->teamController->saveProofOfPayment($proofOfPaymentUrl);
                }
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