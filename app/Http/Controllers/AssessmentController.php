<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentItem;
use App\Models\FirstCategory;
use App\Models\SecondCategory;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class AssessmentController extends Controller
{
    public function index()
    {
        $academicYears = DB::table('tblacyear')
        ->select('acyear_desc as academicYear', 'acterm as term')
        ->where('deleted', '0')
        ->where('current_term', '1')
        ->orderBy('acyear_desc', 'desc')
        ->get();

        $studentD = Student::where('deleted', '0')
        ->select(
            'tblstudent.student_no',
            'tblstudent.current_class',
            'tblstudent.current_grade',
            'tblstudent.gender',
        DB::raw("TRIM(CONCAT(COALESCE(tblstudent.fname, ''), ' ', COALESCE(tblstudent.mname, ''), ' ', COALESCE(tblstudent.lname, ''))) AS student_name"))
            ->orderBy('fname')
            ->get();

        $students = Student::where('deleted', '0')
            ->orderBy('fname')
            ->get();
        
        return view('modules.assessments.index', compact('students', 'academicYears', 'studentD'));
    }
    
    public function create()
    {
        $students = Student::where('deleted', '0')
        ->select(
            'tblstudent.student_no',
            'tblstudent.current_class',
            DB::raw("TRIM(CONCAT(COALESCE(tblstudent.fname, ''), ' ', COALESCE(tblstudent.mname, ''), ' ', COALESCE(tblstudent.lname, ''))) AS student_name"))
            ->orderBy('fname')
            ->get();
        
            $academicYears = DB::table('tblacyear')
            //->select('acyear_desc as academicYear', 'acterm as term')
            ->where('deleted', '0')
            ->where('current_term', '1')
            ->orderBy('acyear_desc', 'desc')
            ->get();
        
        // $academicYears = [
        //     '2024/2025' => '2024/2025',
        //     '2023/2024' => '2023/2024',
        //     '2022/2023' => '2022/2023'
        // ];
        
        $terms = [
            '1' => 'Term 1',
            '2' => 'Term 2',
            '3' => 'Term 3'
        ];
        
        return view('modules.assessments.create', compact('students', 'academicYears', 'terms'));
    }
    
    public function getAssessmentItems(Request $request)
    {
        $studentNo = $request->input('student_no');
        $acyear = $request->input('acyear');
        $term = $request->input('term');
        
        //$student = Student::where('student_no', $studentNo)->first();
        $student = Student::where('deleted', '0')
        ->where('student_no', $studentNo)
        ->select(
            'tblstudent.student_no',
            'tblstudent.current_class',
            'tblstudent.current_grade',
            DB::raw("TRIM(CONCAT(COALESCE(tblstudent.fname, ''), ' ', COALESCE(tblstudent.mname, ''), ' ', COALESCE(tblstudent.lname, ''))) AS student_name"))
            ->first();
        
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }
        
        // Get all categories and their items
        $firstCategories = FirstCategory::with(['secondCategories.assessmentItems'])
            ->where('deleted', '0')
            ->orderBy('desc')
            ->get();
        
        // Get existing assessments for this student in this term/year
        $existingAssessments = Assessment::where([
                'student_no' => $studentNo,
                'acyear' => $acyear,
                'term' => $term,
                'deleted' => '0'
            ])
            ->get()
            ->keyBy('mcode');
        
        return response()->json([
            'student' => $student,
            'firstCategories' => $firstCategories,
            'existingAssessments' => $existingAssessments
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'student_no' => 'required',
            'acyear' => 'required',
            'term' => 'required',
            'school_code' => 'required',
            'assessments' => 'required|array',
            'assessments.*.mcode' => 'required',
            'assessments.*.result' => 'required|in:O,A,B,C,D'
        ]);
        
        $currentDate = Carbon::now()->format('Y-m-d');
        $username = Auth::user()->userid;
        
        foreach ($request->assessments as $assessment) {
            // Check if assessment already exists
            $existingAssessment = Assessment::where([
                'student_no' => $request->student_no,
                'acyear' => $request->acyear,
                'term' => $request->term,
                'mcode' => $assessment['mcode'],
                'deleted' => '0'
            ])->first();
            
            if ($existingAssessment) {
                // Update existing assessment
                $existingAssessment->update([
                    'result' => $assessment['result'],
                    'modifyuser' => $username,
                    'modifydate' => $currentDate
                ]);
            } else {
                // Create new assessment
                Assessment::create([
                    'school_code' => $request->school_code,
                    'acyear' => $request->acyear,
                    'term' => $request->term,
                    'student_no' => $request->student_no,
                    'mcode' => $assessment['mcode'],
                    'result' => $assessment['result'],
                    'deleted' => '0',
                    'createuser' => $username,
                    'createdate' => $currentDate,
                    'modifyuser' => $username,
                    'modifydate' => $currentDate
                ]);
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Assessments saved successfully!'
        ]);
    }
    

    public function view($studentNo, $startYear, $endYear, $term)
{
    $academicYear = $startYear . '/' . $endYear;

        $student = Student::where('student_no', $studentNo)
        ->select(
            'tblstudent.student_no',
            'tblstudent.current_class',
            'tblstudent.current_grade',
            DB::raw("TRIM(CONCAT(COALESCE(tblstudent.fname, ''), ' ', COALESCE(tblstudent.mname, ''), ' ', COALESCE(tblstudent.lname, ''))) AS student_name"))
        ->first();
        
        if (!$student) {
            return redirect()->route('assessments.index')->with('error', 'Student not found!');
        }
        
        $assessments = Assessment::where([
                'student_no' => $studentNo,
                'acyear' => $academicYear,
                'term' => $term,
                'deleted' => '0'
            ])
            ->get();

        
        $assessmentItems = [];
        
        foreach ($assessments as $assessment) {
            $item = AssessmentItem::where('mcode', $assessment->mcode)
                ->with(['firstCategory', 'secondCategory'])
                ->first();
            
            if ($item) {
                if (!isset($assessmentItems[$item->fcat])) {
                    $assessmentItems[$item->fcat] = [
                        'name' => $item->firstCategory->desc,
                        'subcategories' => []
                    ];
                }
                
                if (!isset($assessmentItems[$item->fcat]['subcategories'][$item->scat])) {
                    $assessmentItems[$item->fcat]['subcategories'][$item->scat] = [
                        'name' => $item->secondCategory->desc,
                        'items' => []
                    ];
                }
                
                $assessmentItems[$item->fcat]['subcategories'][$item->scat]['items'][] = [
                    'desc' => $item->desc,
                    'result' => $assessment->result
                ];
            }
        }
        
        return view('modules.assessments.view', compact('student', 'assessmentItems', 'academicYear', 'term'));
    }
    
    public function generatePDF($studentNo, $startYear, $endYear, $term)
    {
        $academicYear = $startYear . '/' . $endYear;

        $student = Student::where('student_no', $studentNo)->first();
        
        if (!$student) {
            return redirect()->route('assessments.index')->with('error', 'Student not found!');
        }
        
        $assessments = Assessment::where([
                'student_no' => $studentNo,
                'acyear' => $academicYear,
                'term' =>  $term,
                'deleted' => '0'
            ])
            ->get();
        
        $assessmentItems = [];
        
        foreach ($assessments as $assessment) {
            $item = AssessmentItem::where('mcode', $assessment->mcode)
                ->with(['firstCategory', 'secondCategory'])
                ->first();
            
            if ($item) {
                if (!isset($assessmentItems[$item->fcat])) {
                    $assessmentItems[$item->fcat] = [
                        'name' => $item->firstCategory->desc,
                        'subcategories' => []
                    ];
                }
                
                if (!isset($assessmentItems[$item->fcat]['subcategories'][$item->scat])) {
                    $assessmentItems[$item->fcat]['subcategories'][$item->scat] = [
                        'name' => $item->secondCategory->desc,
                        'items' => []
                    ];
                }
                
                $assessmentItems[$item->fcat]['subcategories'][$item->scat]['items'][] = [
                    'desc' => $item->desc,
                    'result' => $assessment->result
                ];
            }
        }
        
        //$pdf = PDF::loadView('modules.assessments.pdf', compact('student', 'assessmentItems', 'academicYear', 'term'));
        //return $pdf->download($student->full_name . ' - Assessment Report.pdf');
    }



    public function edit($studentNo, $startYear, $endYear, $term)
{
     $academicYear = $startYear . '/' . $endYear;
    //[$startYear, $endYear] = explode('/', $academicYear);
    $student = Student::where('student_no', $studentNo)->first();
    $studentName = Student::where('student_no', $studentNo)
    ->select(DB::raw("TRIM(CONCAT(COALESCE(tblstudent.fname, ''), ' ', COALESCE(tblstudent.mname, ''), ' ', COALESCE(tblstudent.lname, ''))) AS student_name"))
    ->first();
    
    if (!$student) {
        return redirect()->route('assessments.index')->with('error', 'Student not found!');
    }
    
    $assessments = Assessment::where([
            'student_no' => $studentNo,
            'acyear' => $academicYear,
            'term' => $term,
            'deleted' => '0'
        ])
        ->get();
    
    if ($assessments->isEmpty()) {
        return redirect()->route('assessments.view', ['student' => $studentNo, 'academicYear' => $academicYear, 'term' => $term])
            ->with('error', 'No assessment records found for this student.');
    }
    
    $assessmentItems = [];
    
    foreach ($assessments as $assessment) {
        $item = AssessmentItem::where('mcode', $assessment->mcode)
            ->with(['firstCategory', 'secondCategory'])
            ->first();
        
        if ($item) {
            if (!isset($assessmentItems[$item->fcat])) {
                $assessmentItems[$item->fcat] = [
                    'name' => $item->firstCategory->desc,
                    'subcategories' => []
                ];
            }
            
            if (!isset($assessmentItems[$item->fcat]['subcategories'][$item->scat])) {
                $assessmentItems[$item->fcat]['subcategories'][$item->scat] = [
                    'name' => $item->secondCategory->desc,
                    'items' => []
                ];
            }
            
            $assessmentItems[$item->fcat]['subcategories'][$item->scat]['items'][] = [
                'desc' => $item->desc,
                'result' => $assessment->result,
                'mcode' => $assessment->mcode
            ];
        }
    }
    
    // Get teacher comments if they exist
    $teacherComments = null; // You would fetch this from your database if you have a comments table

    return view('modules.assessments.edit', compact('student', 'assessmentItems', 'academicYear', 'term', 'teacherComments', 'studentName'));
}

public function update(Request $request, $student, $startYear, $endYear, $term)
{
    $academicYear = $startYear . '/' . $endYear;

    $request->validate([
        'student_no' => 'required',
        'acyear' => 'required',
        'term' => 'required',
        'school_code' => 'required',
        'assessments' => 'required|array',
        'assessments.*.mcode' => 'required',
        'assessments.*.result' => 'required|in:O,A,B,C,D'
    ]);
    
    $currentDate = Carbon::now()->format('Y-m-d');
    $username = Auth::user()->userid;
    
    foreach ($request->assessments as $assessment) {
        // Check if assessment already exists
        $existingAssessment = Assessment::where([
            'student_no' => $request->student_no,
            'acyear' => $request->acyear,
            'term' => $request->term,
            'mcode' => $assessment['mcode'],
            'deleted' => '0'
        ])->first();
        
        if ($existingAssessment) {
            // Update existing assessment
            $existingAssessment->update([
                'result' => $assessment['result'],
                'modifyuser' => $username,
                'modifydate' => $currentDate
            ]);
        } else {
            // Create new assessment
            Assessment::create([
                'school_code' => $request->school_code,
                'acyear' => $request->acyear,
                'term' => $request->term,
                'student_no' => $request->student_no,
                'mcode' => $assessment['mcode'],
                'result' => $assessment['result'],
                'deleted' => '0',
                'createuser' => $username,
                'createdate' => $currentDate,
                'modifyuser' => $username,
                'modifydate' => $currentDate
            ]);
        }
    }
    
    // Save teacher comments if you have a comments table
    // This is just a placeholder - you would need to implement based on your database schema
    // if (!empty($request->teacher_comments)) {
    //     // Save the comments
    // }
    
    return response()->json([
        'success' => true,
        'message' => 'Assessment updated successfully!'
    ]);
}
}
