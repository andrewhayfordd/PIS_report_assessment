@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Create New Assessment</h5>
                </div>
                <div class="card-body">
                    <form id="assessment-form">
                        @csrf
                        <input type="hidden" name="school_code" value="{{ Auth::user()->school_code }}">
                        
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="student_no">Select Student:</label>
                                    <select name="student_no" id="student_no" class="form-control select2" required>
                                        <option value="">Select Student</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->student_no }}">
                                                {{ $student->student_no }} - {{ $student->student_name }} ({{ $student->current_class }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="acyear">Academic Year:</label>
                                    <select name="acyear" id="acyear" class="form-control" required>
                                        <option value="">Select Academic Year</option>
                                        @foreach($academicYears as $year)
                                      <option value="{{ $year->acyear_desc }}">{{ $year->acyear_desc }}</option>
                                         @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="term">Term:</label>
                                    <select name="term" id="term" class="form-control" required>
                                        <option value="">Select Term</option>
                                        @foreach($academicYears as $term)
                                            <option value="{{ $term->acterm }}">{{ $term->acterm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="button" id="load-assessment-items" class="btn btn-info">
                                    Load Assessment Items
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div id="assessment-container" class="mt-4" style="display: none;">
                        <div class="student-info mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Student Name:</strong> <span id="student-name"></span></p>
                                            <p><strong>Student No:</strong> <span id="student-no"></span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Class:</strong> <span id="student-class"></span></p>
                                            <p><strong>Grade:</strong> <span id="student-grade"></span></p>
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
                        
                        <form id="save-assessment-form">
                            @csrf
                            <input type="hidden" name="student_no" id="form-student-no">
                            <input type="hidden" name="acyear" id="form-acyear">
                            <input type="hidden" name="term" id="form-term">
                            <input type="hidden" name="school_code" value="{{ Auth::user()->school_code }}">
                            
                            <div id="assessment-items-container">
                                <!-- Assessment items will be loaded here -->
                            </div>
                            
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Save Assessment</button>
                                <a href="{{ route('assessments.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
                            </div>
                        </form>
                    </div>
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
        $('#load-assessment-items').click(function() {
            const studentNo = $('#student_no').val();
            const acyear = $('#acyear').val();
            const term = $('#term').val();
            
            if (!studentNo || !acyear || !term) {
                alert('Please select student, academic year and term.');
                return;
            }
            
            $.ajax({
                url: "{{ route('assessments.getItems') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    student_no: studentNo,
                    acyear: acyear,
                    term: term
                },
                success: function(response) {
                    // Update student info
                    $('#student-name').text(response.student.student_name);
                    $('#student-no').text(response.student.student_no);
                    $('#student-class').text(response.student.current_class);
                    $('#student-grade').text(response.student.current_grade);
                    
                    // Update form hidden fields
                    $('#form-student-no').val(response.student.student_no);
                    $('#form-acyear').val(acyear);
                    $('#form-term').val(term);
                    
                    // Generate assessment items HTML
                    let html = '';
                    
                    response.firstCategories.forEach(function(firstCategory) {
                        html += `
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">${firstCategory.desc}</h5>
                                </div>
                                <div class="card-body">
                        `;
                        
                        firstCategory.second_categories.forEach(function(secondCategory) {
                            html += `
                                <div class="mb-4">
                                    <h6 class="bg-light p-2">${secondCategory.desc}</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="70%">Assessment Item</th>
                                                    <th width="30%">Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                            `;
                            
                            secondCategory.assessment_items.forEach(function(item) {
                                // Check if this item has an existing assessment
                                let existingGrade = '';
                                if (response.existingAssessments[item.mcode]) {
                                    existingGrade = response.existingAssessments[item.mcode].result;
                                }
                                
                                html += `
                                    <tr>
                                        <td>${item.desc}</td>
                                        <td>
                                            <select name="assessments[${item.mcode}][result]" class="form-control" required>
                                                <option value="">Select Grade</option>
                                                <option value="O" ${existingGrade === 'O' ? 'selected' : ''}>Outstanding (O)</option>
                                                <option value="A" ${existingGrade === 'A' ? 'selected' : ''}>Very Good (A)</option>
                                                <option value="B" ${existingGrade === 'B' ? 'selected' : ''}>Good (B)</option>
                                                <option value="C" ${existingGrade === 'C' ? 'selected' : ''}>Fair (C)</option>
                                                <option value="D" ${existingGrade === 'D' ? 'selected' : ''}>Can do better (D)</option>
                                            </select>
                                            <input type="hidden" name="assessments[${item.mcode}][mcode]" value="${item.mcode}">
                                        </td>
                                    </tr>
                                `;
                            });
                            
                            html += `
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            `;
                        });
                        
                        html += `
                                </div>
                            </div>
                        `;
                    });
                    
                    $('#assessment-items-container').html(html);
                    $('#assessment-container').show();
                },
                error: function(xhr) {
                    alert('Error loading assessment items. Please try again.');
                    console.error(xhr.responseText);
                }
            });
        });


        
        // $('#save-assessment-form').submit(function(e) {
        //     e.preventDefault();
            
        //     $.ajax({
        //         url: "{{ route('assessments.store') }}",
        //         type: "POST",
        //         data: $(this).serialize(),
        //         success: function(response) {
        //             if (response.success) {
        //                 alert('Assessment saved successfully!');
        //                 window.location.href = "{{ route('assessments.index') }}";
        //             } else {
        //                 alert('Error saving assessment. Please try again.');
        //             }
        //         },
        //         error: function(xhr) {
        //             alert('Error saving assessment. Please try again.');
        //             console.error(xhr.responseText);
        //         }
        //     });
        // });


        $('#save-assessment-form').submit(function(e) {
    e.preventDefault();

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to save this assessment?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Submit!"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                    text: "Submiting...",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading(); // Show a loading indicator
                        }
                    });
            $.ajax({
                url: "{{ route('assessments.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Saved!",
                            text: "Assessment saved successfully.",
                            icon: "success"
                        }).then(() => {
                            window.location.href = "{{ route('assessments.index') }}";
                        });
                    } else {
                        Swal.fire("Error!", "Error saving assessment. Please try again.", "error");
                    }
                },
                error: function(xhr) {
                    Swal.fire("Error!", "Error saving assessment. Please try again.", "error");
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