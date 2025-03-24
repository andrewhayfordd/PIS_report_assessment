<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Comment;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function index()
    {
        $students = Assessment::join('tblstudent', 'tblreport_assessment.student_no', '=', 'tblstudent.student_no')
            ->select('tblreport_assessment.student_no', 'tblstudent.current_class',
            DB::raw("TRIM(CONCAT(COALESCE(tblstudent.fname, ''), ' ', COALESCE(tblstudent.mname, ''), ' ', COALESCE(tblstudent.lname, ''))) AS student_name"))
            ->distinct()
            ->get();

        return view('modules.comment.index', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_no' => 'required',
            'acyear' => 'required',
            'term' => 'required',
            'ct_remarks' => 'required',
        ]);

        Comment::create($request->all());

        return redirect()->route('comments.index')->with('success', 'Comment added successfully.');
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return view('modules.comment.modals.edit', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ct_remarks' => 'required',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($request->all());

        return redirect()->route('comments.index')->with('success', 'Comment updated successfully.');
    }

    public function destroy($id)
    {
        Comment::where('transid', $id)->update(['deleted' => '1']);
        return redirect()->route('comments.index')->with('success', 'Comment deleted successfully.');
    }
}
