<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        // Get the logged-in teacher's assigned class
        $teacherClass = DB::table('tblclass_teacher')
            ->where('staff_no', Auth::user()->userid)
            ->value('class_code');

        // Filter parameters
        $acyear = $request->input('acyear');
        $term = $request->input('term');

        // Query to get students with assessments in the teacher's class
        $students = DB::table('tblreport_assessment as ra')
            ->join('tblstudent as s', 'ra.student_no', '=', 's.student_no')
            ->leftJoin('tblcomment_ia as ci', function($join) use ($acyear, $term) {
                $join->on('ra.student_no', '=', 'ci.student_no')
                     ->where('ci.acyear', $acyear)
                     ->where('ci.term', $term)
                     ->where('ci.deleted', '0');
            })
            ->where('s.current_class', $teacherClass)
            //->where('tblcomment_ia.deleted', '0')
            ->when($acyear, function($query) use ($acyear) {
                return $query->where('ra.acyear', $acyear);
            })
            ->when($term, function($query) use ($term) {
                return $query->where('ra.term', $term);
            })
            ->select(
                's.student_no', 
                DB::raw('CONCAT(s.fname, " ", s.mname, " ", s.lname) as full_name'), 
                's.current_class',
                'ci.ct_remarks',
                'ci.transid as comment_id'
            )
            ->distinct()
            ->get();

        // Get unique academic years and terms for filtering
        $academicYears = DB::table('tblreport_assessment')
            ->select('acyear')
            ->distinct()
            ->pluck('acyear');

        $terms = DB::table('tblreport_assessment')
            ->select('term')
            ->distinct()
            ->pluck('term');

        return view('modules.comment.index', [
            'students' => $students,
            'academicYears' => $academicYears,
            'terms' => $terms,
            'selectedAcYear' => $acyear,
            'selectedTerm' => $term
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_no' => 'required|exists:tblstudent,student_no',
            'acyear' => 'required',
            'term' => 'required',
            'ct_remarks' => 'required|string|max:255'
        ]);

        // Get the logged-in teacher's class
        $teacherClass = DB::table('tblclass_teacher')
            ->where('staff_no', Auth::user()->userid)
            ->value('class_code');

        // Verify the student is in the teacher's class
        $studentClass = DB::table('tblstudent')
            ->where('student_no', $validatedData['student_no'])
            ->value('current_class');

        if ($studentClass !== $teacherClass) {
            return back()->with('error', 'You can only comment on students in your assigned class.');
        }

        $transid = uniqid(); // Generate unique transaction ID

        DB::table('tblcomment_ia')->insert([
            'transid' => $transid,
            'school_code' => Auth::user()->school_code,
            'acyear' => $validatedData['acyear'],
            'term' => $validatedData['term'],
            'student_no' => $validatedData['student_no'],
            'ct_remarks' => $validatedData['ct_remarks'],
            'class_code' => $teacherClass,
            'deleted' => '0',
            'createuser' => Auth::user()->userid,
            'createdate' => Carbon::now(),
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    public function update(Request $request, $transid)
    {
        $validatedData = $request->validate([
            'ct_remarks' => 'required|string|max:255'
        ]);

        // Verify the comment belongs to the teacher's class
        $comment = DB::table('tblcomment_ia')
            ->where('transid', $transid)
            ->first();

        if (!$comment) {
            return back()->with('error', 'Comment not found.');
        }

        DB::table('tblcomment_ia')
            ->where('transid', $transid)
            ->update([
                'ct_remarks' => $validatedData['ct_remarks'],
                'modifyuser' => Auth::user()->name,
                'modifydate' => Carbon::now()
            ]);

        return back()->with('success', 'Comment updated successfully.');
    }

    public function destroy($transid)
    {
        // Soft delete by setting deleted flag
        DB::table('tblcomment_ia')
            ->where('transid', $transid)
            ->update([
                'deleted' => '1',
                'modifyuser' => Auth::user()->name,
                'modifydate' => Carbon::now()
            ]);

        return back()->with('success', 'Comment deleted successfully.');
    }
}