@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Assessment</h5>
                        @php
                        [$startYear, $endYear] = explode('/', $academicYear);
                        @endphp
                        <a href="{{ route('assessments.view', ['student' => $student->student_no, 'startYear' => $startYear, 'endYear' => $endYear, 'term' => $term]) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancel & Return to View
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="student-info mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Student Name:</strong> {{ $studentName->student_name }}</p>
                                        <p><strong>Student No:</strong> {{ $student->student_no }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Class:</strong> {{ $student->current_class }}</p>
                                        <p><strong>Grade:</strong> {{ $student->current_grade }}</p>
                                        <p><strong>Academic Year:</strong> {{ $academicYear }} - Term {{ $term }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="marking-key mb-4">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0">Marking Key</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p><strong>O</strong> - Outstanding (Displays strong performance)</p>
                                        <p><strong>A</strong> - Very Good (Demonstrates appropriate performance)</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>B</strong> - Good (Needs occasional support/strengthening)</p>
                                        <p><strong>C</strong> - Fair (Needs consistent support/strengthening)</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><strong>D</strong> - Can do better (Needs to work harder and improve)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form id="update-assessment-form">
                        @csrf
                        <input type="hidden" name="student_no" value="{{ $student->student_no }}">
                        <input type="hidden" name="acyear" value="{{ $academicYear }}">
                        <input type="hidden" name="term" value="{{ $term }}">
                        <input type="hidden" name="school_code" value="{{ Auth::user()->school_code }}">
                        
                        <div class="assessment-items">
                            @if(count($assessmentItems) > 0)
                                @foreach($assessmentItems as $categoryCode => $category)
                                    <div class="card mb-4">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0">{{ $category['name'] }}</h5>
                                        </div>
                                        <div class="card-body">
                                            @foreach($category['subcategories'] as $subcategoryCode => $subcategory)
                                                <div class="mb-4">
                                                    <h6 class="bg-light p-2">{{ $subcategory['name'] }}</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th width="70%">Assessment Item</th>
                                                                    <th width="30%">Grade</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($subcategory['items'] as $item)
                                                                    <tr>
                                                                        <td>{{ $item['desc'] }}</td>
                                                                        <td>
                                                                            <select name="assessments[{{ $item['mcode'] }}][result]" class="form-control" required>
                                                                                <option value="">Select Grade</option>
                                                                                <option value="O" {{ $item['result'] === 'O' ? 'selected' : '' }}>Outstanding (O)</option>
                                                                                <option value="A" {{ $item['result'] === 'A' ? 'selected' : '' }}>Very Good (A)</option>
                                                                                <option value="B" {{ $item['result'] === 'B' ? 'selected' : '' }}>Good (B)</option>
                                                                                <option value="C" {{ $item['result'] === 'C' ? 'selected' : '' }}>Fair (C)</option>
                                                                                <option value="D" {{ $item['result'] === 'D' ? 'selected' : '' }}>Can do better (D)</option>
                                                                            </select>
                                                                            <input type="hidden" name="assessments[{{ $item['mcode'] }}][mcode]" value="{{ $item['mcode'] }}">
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning">
                                    <h5 class="alert-heading">No Assessment Records Found</h5>
                                    <p>There are no existing assessment records for this student in {{ $academicYear }} - Term {{ $term }}.</p>
                                    <hr>
                                    <p class="mb-0">Please go back and create a new assessment instead.</p>
                                </div>
                            @endif
                        </div>
                        
                        @if(count($assessmentItems) > 0)
                            <div class="form-group mt-4">
                                <label for="teacher_comments"><strong>Teacher's Comments:</strong></label>
                                <textarea name="teacher_comments" id="teacher_comments" class="form-control" rows="4">{{ $teacherComments ?? '' }}</textarea>
                            </div>
                            
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Update Assessment</button>
                                <a href="{{ route('assessments.view', ['student' => $student->student_no, 'startYear' => $startYear, 'endYear' => $endYear, 'term' => $term]) }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Cancel
</a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // $('#update-assessment-form').submit(function(e) {
        //     e.preventDefault();
            
        //     $.ajax({
        //         url: "{{ route('assessments.update', ['student' => $student->student_no, 'startYear' => $startYear, 'endYear' => $endYear, 'term' => $term]) }}",
        //         type: "POST",
        //         data: $(this).serialize(),
        //         success: function(response) {
        //             if (response.success) {
        //                 alert('Assessment updated successfully!');
        //                 window.location.href = "{{ route('assessments.view', ['student' => $student->student_no, 'startYear' => $startYear, 'endYear' => $endYear, 'term' => $term]) }}";
        //             } else {
        //                 alert('Error updating assessment. Please try again.');
        //             }
        //         },
        //         error: function(xhr) {
        //             alert('Error updating assessment. Please try again.');
        //             console.error(xhr.responseText);
        //         }
        //     });
        // });


        $('#update-assessment-form').submit(function(e) {
    e.preventDefault();

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to update this assessment?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Update!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('assessments.update', ['student' => $student->student_no, 'startYear' => $startYear, 'endYear' => $endYear, 'term' => $term]) }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Updated!",
                            text: "Assessment updated successfully.",
                            icon: "success"
                        }).then(() => {
                            window.location.href = "{{ route('assessments.view', ['student' => $student->student_no, 'startYear' => $startYear, 'endYear' => $endYear, 'term' => $term]) }}";
                        });
                    } else {
                        Swal.fire("Error!", "Error updating assessment. Please try again.", "error");
                    }
                },
                error: function(xhr) {
                    Swal.fire("Error!", "Error updating assessment. Please try again.", "error");
                    console.error(xhr.responseText);
                }
            });
        }
    });
});


    });
</script>
@endpush
@endsection