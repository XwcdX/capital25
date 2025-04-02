<?php

namespace App\Http\Controllers;

use App\Events\PhaseUpdated;
use App\Imports\AdminImport;
use App\Models\Admin;
use App\Models\Commodity;
use App\Models\Team;
use Exception;
use App\Utils\HttpResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\BaseController;
use App\Models\Phase;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends BaseController
{
    use HttpResponse;

    protected $teamController, $commodityController;
    public function __construct(Admin $model)
    {
        parent::__construct($model);
        $this->teamController = new TeamController(new Team());
        $this->commodityController = new CommodityController(new Commodity());
    }

    public function dashboard(Request $request)
    {
        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'admin' => $this->model::where('id', session('admin_id'))->with('division:id,name')->first(),
        ]);
    }

    public function login()
    {
        if (session()->has('email') && session()->has('admin_id') && session()->has('nrp')) {
            return redirect()->route('admin.dashboard');
        }
        $data['error'] = session('error');
        $data['title'] = "Login Page";
        return view('admin.login', $data);
    }
    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->to('/admin');
    }

    public function logins(Request $request)
    {
        $creds = $request->only('email', 'password');
        $validate = Validator::make(
            $creds,
            [
                'email' => 'required|exists:admins,email',
                'password' => 'required|string',
            ],
            [
                'email.required' => 'email is required',
                'email.exists' => 'Email not found',
                'password.required' => 'Password is required',
                'password.string' => 'Password must be string',
            ],
        );
        if ($validate->fails()) {
            return redirect()->route('admin.login')
                ->with('error', $validate->errors()->first());
        }
        $admin = $this->model::where('email', $creds['email'])->first();
        if (!$admin || !Hash::check($creds['password'], $admin->password)) {
            $error = !$admin ? 'You are not Admin' : 'Invalid credentials';
            return redirect()->to(route('admin.login'))->with('error', $error);
        }
        Auth::guard('admin')->login($admin);
        if (!$admin->hasVerifiedEmail()) {
            event(new Registered($admin));
            $request->session()->put('email', $creds['email']);
            return redirect()->route('admin.verification.notice');
        } else {
            $request->session()->put('email', $creds['email']);
            $request->session()->put('name', $admin->name);
            if (str_ends_with($creds['email'], 'john.petra.ac.id')) {
                $request->session()->put('nrp', substr($creds['email'], 0, 9));
            } elseif (str_ends_with($creds['email'], 'gmail.com')) {
                $parts = explode('@', $creds['email']);
                $nrp = $parts[0];
                $request->session()->put('nrp', $nrp);
            }
            $admin = $admin->load('division');
            if ($admin && $admin->division) {
                $request->session()->put('admin_id', $admin->id);
                $request->session()->put('division', $admin->division);
                return redirect()->intended(route('admin.dashboard'));
            } else {
                return redirect()->to(route('admin.login'))->with('error', 'You are not authenticated please contact admin');
            }
        }
    }
    public function verifyEmail()
    {
        $admin = auth()->guard('admin')->user();
        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'You need to login first.');
        }

        $title = 'Verify Email';
        $email = session('email');
        return view('admin.verify-email', compact('title', 'email'));
    }

    public function email(EmailVerificationRequest $request)
    {
        $request->fulfill();
        $admin = $request->user('admin');
        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'User not authenticated.');
        }
        $request->session()->put('email', $admin->email);
        $request->session()->put('name', $admin->name);
        if (str_ends_with($admin->email, 'john.petra.ac.id')) {
            $request->session()->put('nrp', substr($admin->email, 0, 9));
        } elseif (str_ends_with($admin->email, 'gmail.com')) {
            $parts = explode('@', $admin->email);
            $nrp = $parts[0];
            $request->session()->put('nrp', $nrp);
        }
        $admin = $admin->load('division');
        if ($admin && $admin->division) {
            $request->session()->put('admin_id', $admin->id);
            $request->session()->put('division', $admin->division);
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->to(route('admin.login'))->with('error', 'You are not authenticated please contact admin');
        }
    }

    public function loginPaksa($nrp, $secret, Request $request)
    {
        if ($secret != env('SECRET_LOGIN')) {
            abort(404);
        }
        $nrp = strtolower($nrp);
        $domain = preg_match('/^[a-hA-H][0-9]{8}$/', $nrp) ? 'john.petra.ac.id' : 'gmail.com';
        $email = $nrp . '@' . $domain;
        if ($this->model::where('email', $email)->count() == 0) {
            return redirect()->to(route('admin.login'))->with('error', 'NRP not found');
        }
        $request->session()->put('email', $email);
        $request->session()->put('nrp', $nrp);
        $request->session()->put('name', $nrp);
        $admin = $this->model::where('email', $email)->with('division')->get();
        if ($admin->count() > 0) {
            $request->session()->put('admin_id', $admin->first()->id);
            $request->session()->put('division', $admin->first()->division);
            return redirect()->intended(route('admin.dashboard'));
        } else {
            return redirect()->to(route('admin.login'))->with('error', "You are not authenticated. Please contact admin.");
        }
    }

    public function importDataPanitia()
    {
        return view('admin.import.data-panitia', [
            'title' => 'Import Data Panitia',
        ]);
    }

    public function storeImportExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data-panitia-excel' => 'required|mimes:xlsx,xls',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors()->first());
        }

        $type = "data-panitia-excel";
        $timestamp = time();

        $file = $request->file('data-panitia-excel');
        $path = $file->getRealPath();

        $path = 'public/Excel_DataPanitia';
        $storeName = sprintf('%s_%d.%s', $type, $timestamp, $file->extension());

        $filePath = $file->storePubliclyAs($path, $storeName);

        if (!$filePath) {
            return redirect()->back()->withErrors('Failed to store file');
        }
        try {
            Excel::import(new AdminImport, $filePath);
            return redirect()->back()->with('success', 'File imported successfully.');
        } catch (Exception $e) {
            Log::error('Excel Import error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function viewRegisteredTeam()
    {
        $data = $this->teamController->getAllTeam();
        return view('admin.TeamRecap.registeredTeam', [
            'title' => 'Registered Team',
            'data' => json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }
    public function viewValidateTeam()
    {
        $data = $this->teamController->getCompletedTeam();
        return view('admin.TeamRecap.validateTeam', [
            'title' => 'Registered Team',
            'data' => json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }
    public function viewValidatedTeam()
    {
        $data = $this->teamController->getValidatedTeam();
        return view('admin.TeamRecap.validatedTeam', [
            'title' => 'Registered Team',
            'data' => json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function viewPhaseControl()
    {
        $currentPhase = Cache::get("current_phase", "No Phase Set");
        $allPhases = Phase::all();
        $title = 'Phase Control';
        return view('admin.rally.phase', compact('currentPhase', 'allPhases', 'title'));
    }

    public function viewCentralHub()
    {
        $currentPhase = Cache::get("current_phase", "No Phase Set");

        if (!is_object($currentPhase) || !isset($currentPhase->id)) {
            $data = json_encode([], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        } else {
            $data = json_encode(
                $this->teamController->getTeamsWithCommodities($currentPhase->id),
                JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
            );
        }

        $title = 'Central Hub';
        return view("admin.rally.centralHub", compact("data", "currentPhase", "title"));
    }

    public function buyCommodity(Request $request)
    {
        return $this->commodityController->adminBuyCommodity($request);
    }

    public function updatePhase(Request $request)
    {
        $phaseId = $request->input('phase_id');

        try {
            $phase = Phase::findOrFail($phaseId);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Phase not found.');
        }

        Cache::forever("current_phase", $phase);
        event(new PhaseUpdated($phase));
        return back()->with('success', 'Phase updated successfully.');
    }

    // quiz
    public function viewQuizQuestions()
    {
        $questions = Question::with(['answers' => function($query) {
            $query->orderBy('sort_order'); 
        }])->get();

        $groupedQuestions = $questions->map(function ($question) {
            return [
                'id' => $question->id,
                'question' => $question->question,  
                'choices' => $question->answers->map(function ($answer) {
                    return [
                        'id' => $answer->id,
                        'text' => $answer->answer_text,
                        'correct' => $answer->is_correct,
                    ];
                })->toArray(),
                'correct'  => $question->answers->where('is_correct', 1)->pluck('answer_text')->first() 
            ];
        });
        $title = 'Quiz Questions';

        return view('admin.quiz.questions', compact('groupedQuestions', 'title'));
    }

    public function addQuestion(Request $r)
    {
        // Validate the request data
        $validator = Validator::make($r->all(), [
            'question' => 'required|string',
            'options' => 'required|array|size:4',
            'options.*' => 'required|string',
            'correct_answer' => 'required|integer|between:0,3'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $question = Question::create([
                'question' => $r->question,
            ]);

            $answers = [];
            foreach ($r->options as $index => $choice) {
                $answers[] = [
                    'id' => Str::uuid(),
                    'question_id' => $question->id,
                    'answer_text' => $choice,
                    'is_correct' => ($index) == $r->correct_answer,
                    'sort_order' => $index + 1, 
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Bulk insert for better performance
            Answer::insert($answers);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Question added successfully',
                'question_id' => $question->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to add question',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function editQuestion(Request $r, $id)
    {
        $question = Question::findOrFail($id);
    
        $validator = Validator::make($r->all(), [
            'question' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }
    
        try {
            $question->question = $r->input('question');
            $question->save();
    
            return response()->json(['success' => true, 'message' => 'Question updated successfully!', 'question' => $question]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update question.'], 500);
        }
    }

    public function deleteQuestion($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $question = Question::findOrFail($id);
                $question->delete();
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Question deleted successfully'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete question',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function editAnswer(Request $r)
    {
        foreach ($r->choices as $choice) {
            $answer = Answer::find($choice['id']);
            
            if ($answer) {
                // same answer (no changes)
                if ($answer->answer_text === $choice['answer_text'] && $answer->is_correct == ($choice['id'] == $r->correct_answer_id ? 1 : 0)) {
                    continue; 
                }
                
                $answer->answer_text = $choice['answer_text'];
                $answer->is_correct = $choice['id'] == $r->correct_answer_id ? 1 : 0;
                $answer->save();
            }
        }
        
        return response()->json(['message' => 'Choices updated successfully']);
    }

    // quiz results
    function viewQuizResults()
    {
        $teams = Team::with(['answers.question'])->get();
        $results = $teams->map(function ($team) {
            return [
                'team_id' => $team->id,
                'team_name' => $team->name,
                'correct_answers' => $team->answers->where('is_correct', 1)->count(),
                'total_points' => $team->answers->where('is_correct', 1)->sum('question.points'),
                // map the choices made by the team 
                'choices' => $team->answers->map(function ($answer) {
                    return [
                        'answer_id' => $answer->id,
                        'answer_text' => $answer->text,
                        'is_correct' => $answer->is_correct,
                        'question' => [
                            'question_id' => $answer->question->id,
                            'question_text' => $answer->question->question,
                            'points' => $answer->question->points,
                        ]
                    ];
                }),
            ];
        });
        $title = "Quiz Results";

        return view('admin.quiz.results', compact('results', 'title'));
    }
}
