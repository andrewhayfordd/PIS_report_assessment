@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Student Comments</h1>

    {{-- Filter Form --}}
    {{--<form method="GET" action="{{ route('comments.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="acyear" class="form-control">
                    <option value="">Select Academic Year</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year }}" 
                            {{ $selectedAcYear == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="term" class="form-control">
                    <option value="">Select Term</option>
                    @foreach($terms as $termOption)
                        <option value="{{ $termOption }}" 
                            {{ $selectedTerm == $termOption ? 'selected' : '' }}>
                            {{ $termOption }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('comments.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>--}}

    {{-- Search Bar --}}
    <input type="text" id="searchStudent" class="form-control mb-3" placeholder="Search by Student No or Name">

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Students Table --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student No</th>
                <th>Name</th>
                <th>Class</th>
                <th>Current Comment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="studentTable">
            @forelse($students as $student)
                <tr>
                    <td>{{ $student->student_no }}</td>
                    <td>{{ $student->full_name }}</td>
                    <td>{{ $student->current_class }}</td>
                    <td>{{ $student->ct_remarks ?? 'No comment' }}</td>
                    <td>
                        @if($student->comment_id)
                            <button class="btn btn-sm btn-warning" 
                                data-toggle="modal" 
                                data-target="#editCommentModal"
                                data-transid="{{ $student->comment_id }}"
                                data-remarks="{{ $student->ct_remarks }}">
                                Edit
                            </button>
                            <form action="{{ route('comments.destroy', $student->comment_id) }}" method="POST" class="delete-comment-form" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger delete-comment-btn">
                                    Delete
                                </button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-primary" 
                                data-toggle="modal" 
                                data-target="#addCommentModal"
                                data-student-no="{{ $student->student_no }}">
                                Add Comment
                            </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No students found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Include Modals --}}
@include('modules.comment.modals.add')
@include('modules.comment.modals.edit')

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<script>
    // Handle add comment modal
    $('#addCommentModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var studentNo = button.data('student-no');
        var modal = $(this);
        modal.find('#add-student-no').val(studentNo);
        modal.find('#add-acyear').val('{{ $selectedAcYear }}');
        modal.find('#add-term').val('{{ $selectedTerm }}');
    });

    // Handle edit comment modal
    $('#editCommentModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var transid = button.data('transid');
        var remarks = button.data('remarks');
        var modal = $(this);
        modal.find('#edit-transid').val(transid);
        modal.find('#edit-remarks').val(remarks);
    });

    // Swal confirmation for delete
    $('.delete-comment-btn').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('.delete-comment-form');

        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Delete"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit the form if confirmed
            }
        });
    });

    // Search student functionality
    document.getElementById('searchStudent').addEventListener('keyup', function () {
        var searchValue = this.value.toLowerCase();
        var rows = document.querySelectorAll('#studentTable tr');

        rows.forEach(function (row) {
            var studentNo = row.cells[0].innerText.toLowerCase();
            var studentName = row.cells[1].innerText.toLowerCase();

            if (studentNo.includes(searchValue) || studentName.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endpush
