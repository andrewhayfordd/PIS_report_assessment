@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Comments</h2>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addCommentModal">Add Comment</button>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Student No</th>
                <th>Name</th>
                <th>Class</th>
                <th>Comment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->student_no }}</td>
                    <td>{{ $student->student_name }}</td>
                    <td>{{ $student->current_class }}</td>
                    <td>{{ $student->ct_remarks ?? 'No comment' }}</td>
                    <td>
                        {{--<button class="btn btn-warning" data-toggle="modal" data-target="#editCommentModal" data-id="{{ $student->student_no }}">Edit</button>--}}
                        <button class="btn btn-warning" data-toggle="modal" data-target="#editCommentModal" data-id="{{ $student->transid }}">Edit</button>
                        <form action="{{ route('comments.destroy', $student->student_no) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('modules.comment.modals.add')
@include('modules.comment.modals.edit')

<script>
$('#editCommentModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id'); // Get comment ID
    var modal = $(this);
    var form = modal.find('#editCommentForm');

    // Set form action dynamically
    form.attr('action', '/comments/update/' + id);
});
</script>
@endsection