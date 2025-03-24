@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Student Assessments</h5>
                        <a href="{{ route('assessments.create') }}" class="btn btn-primary">New Assessment</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="students-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Student No</th>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Grade</th>
                                    <th>Gender</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($studentD as $student)
                                    <tr>
                                        <td>{{ $student->student_no }}</td>
                                        <td>{{ $student->student_name }}</td>
                                        <td>{{ $student->current_class }}</td>
                                        <td>{{ $student->current_grade }}</td>
                                        <td>{{ $student->gender }}</td>
                                        <td>
    
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-{{ $student->student_no }}" data-toggle="dropdown" aria-expanded="false">
                                                    View Reports
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $student->student_no }}">
                                                @foreach ($academicYears as $academicYear)
                                                <a class="dropdown-item" 
                                                  href="{{ route('assessments.view', [
                                                  'student' => $student->student_no, 
                                                  'startYear' => explode('/', $academicYear->academicYear)[0], 
                                                  'endYear' => explode('/', $academicYear->academicYear)[1], 
                                                  'term' => $academicYear->term]) }}">
                                                   {{ $academicYear->academicYear }} - Term {{ $academicYear->term }}
                                                </a>
                                                @endforeach
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#students-table').DataTable({
            "pageLength": 25,
            "order": [[ 1, "asc" ]]
        });
    });
</script>
@endpush
@endsection