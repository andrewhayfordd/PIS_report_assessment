@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Assessment Report</h5>
                        <div>
                        @php
    $years = explode('/', $academicYear);
    $startYear = $years[0] ?? null;
    $endYear = $years[1] ?? null;
@endphp
<a href="{{ route('assessments.edit', [
    'student' => $student->student_no ?? 'unknown',
    'startYear' => $startYear ?? '0000',
    'endYear' => $endYear ?? '0000',
    'term' => $term ?? '1'
]) }}" class="btn btn-warning">
    <i class="fas fa-edit"></i> Edit Assessment
</a>
                            {{--<a href="{{ route('assessments.pdf', ['student' => $student->student_no, 'academicYear' => $academicYear, 'term' => $term]) }}" class="btn btn-success">
                                <i class="fas fa-file-pdf"></i> Download PDF
                            </a>--}}
                            <button class="btn btn-success" onclick="printReport()"><i class="fas fa-print"></i>Print</button>
                            <button class="btn btn-danger" onclick="downloadPDF()"><i class="fas fa-file-pdf"></i>Download PDF</button>
                            <a href="{{ route('assessments.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body" id="printSection">
                    <div class="student-info mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Student Name:</strong> {{ $student->student_name }}</p>
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
                    
                    <div class="assessment-results">
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
                                                                        <span class="badge 
                                                                            @if($item['result'] == 'O') badge-success
                                                                            @elseif($item['result'] == 'A') badge-primary
                                                                            @elseif($item['result'] == 'B') badge-info
                                                                            @elseif($item['result'] == 'C') badge-warning
                                                                            @elseif($item['result'] == 'D') badge-danger
                                                                            @endif
                                                                            p-2">
                                                                            {{ $item['result'] }}
                                                                        </span>
                                                                        @if($item['result'] == 'O')
                                                                            - Outstanding
                                                                        @elseif($item['result'] == 'A')
                                                                            - Very Good
                                                                        @elseif($item['result'] == 'B')
                                                                            - Good
                                                                        @elseif($item['result'] == 'C')
                                                                            - Fair
                                                                        @elseif($item['result'] == 'D')
                                                                            - Can do better
                                                                        @endif
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
                            <div class="alert alert-info">
                                <h5 class="alert-heading">No Assessment Data</h5>
                                <p>There are no assessment records for this student in {{ $academicYear }} - Term {{ $term }}.</p>
                                <hr>
                                <p class="mb-0">
                                    <a href="{{ route('assessments.create') }}" class="btn btn-primary">Create New Assessment</a>
                                </p>
                            </div>
                        @endif
                    </div>
                    
                    @if(count($assessmentItems) > 0)
                        <div class="card mt-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Assessment Summary</h5>
                            </div>
                            <div class="card-body">
                                @php
                                    $totalItems = 0;
                                    $gradeCount = [
                                        'O' => 0,
                                        'A' => 0,
                                        'B' => 0,
                                        'C' => 0,
                                        'D' => 0
                                    ];
                                    
                                    foreach($assessmentItems as $category) {
                                        foreach($category['subcategories'] as $subcategory) {
                                            foreach($subcategory['items'] as $item) {
                                                $totalItems++;
                                                $gradeCount[$item['result']]++;
                                            }
                                        }
                                    }
                                @endphp
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Distribution of Grades</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Grade</th>
                                                        <th>Count</th>
                                                        <th>Percentage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($gradeCount as $grade => $count)
                                                        <tr>
                                                            <td>
                                                                <span class="badge 
                                                                    @if($grade == 'O') badge-success
                                                                    @elseif($grade == 'A') badge-primary
                                                                    @elseif($grade == 'B') badge-info
                                                                    @elseif($grade == 'C') badge-warning
                                                                    @elseif($grade == 'D') badge-danger
                                                                    @endif
                                                                    p-2">
                                                                    {{ $grade }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $count }}</td>
                                                            <td>{{ $totalItems > 0 ? round(($count / $totalItems) * 100, 1) : 0 }}%</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th>{{ $totalItems }}</th>
                                                        <th>100%</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Overall Performance</h6>
                                        @php
                                            $weightedScore = 0;
                                            $weights = [
                                                'O' => 5,
                                                'A' => 4,
                                                'B' => 3,
                                                'C' => 2,
                                                'D' => 1
                                            ];
                                            
                                            foreach($gradeCount as $grade => $count) {
                                                $weightedScore += $weights[$grade] * $count;
                                            }
                                            
                                            $averageScore = $totalItems > 0 ? $weightedScore / $totalItems : 0;
                                            $performanceLevel = '';
                                            
                                            if ($averageScore >= 4.5) {
                                                $performanceLevel = 'Outstanding';
                                                $performanceClass = 'success';
                                            } elseif ($averageScore >= 3.5) {
                                                $performanceLevel = 'Very Good';
                                                $performanceClass = 'primary';
                                            } elseif ($averageScore >= 2.5) {
                                                $performanceLevel = 'Good';
                                                $performanceClass = 'info';
                                            } elseif ($averageScore >= 1.5) {
                                                $performanceLevel = 'Fair';
                                                $performanceClass = 'warning';
                                            } else {
                                                $performanceLevel = 'Needs Improvement';
                                                $performanceClass = 'danger';
                                            }
                                        @endphp
                                        
                                        <div class="alert alert-{{ $performanceClass }} text-center">
                                            <h4>{{ $performanceLevel }}</h4>
                                            <p>Average Score: {{ number_format($averageScore, 1) }} / 5.0</p>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <label><strong>Teacher's Comments:</strong></label>
                                            <p class="border p-3">
                                                @if(isset($teacherComments))
                                                    {{ $teacherComments }}
                                                @else
                                                    No comments available for this assessment period.
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printReport() {
                let printContent = document.getElementById('printSection').innerHTML;
                let printWindow = window.open('', '_blank');

                // Construct the full HTML with Bootstrap styling
                printWindow.document.write(`
        <html>
        <head>
            <title>Print Report</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <style>
                body { padding: 20px; }
            </style>
        </head>
        <body>
            ${printContent}
        </body>
        </html>
    `);

                printWindow.document.close();

                // Ensure styles are fully loaded before printing
                printWindow.onload = function() {
                    printWindow.print();
                    printWindow.close();
                };
            }

            function downloadPDF() {
                // Ensure jsPDF and html2canvas are available
                const {
                    jsPDF
                } = window.jspdf;

                if (typeof html2canvas === 'undefined') {
                    console.error("html2canvas is not loaded!");
                    return;
                }

                let cardElement = document.getElementById('printSection'); // Get the report card
                let teacherComment = document.getElementById('teacherComment')?.value || 'No comments';

                html2canvas(cardElement, {
                    scale: 3,
                    useCORS: true
                }).then(canvas => {
                    let imgData = canvas.toDataURL('image/png');
                    let pdf = new jsPDF('p', 'mm', 'a4');

                    // Scale Image for PDF
                    let imgWidth = 190; // Max width for A4
                    let imgHeight = (canvas.height * imgWidth) / canvas.width; // Maintain aspect ratio
                    if (imgHeight > 250) imgHeight = 250; // Limit height if too big

                    pdf.addImage(imgData, 'PNG', 10, 30, imgWidth, imgHeight);

                    // Save PDF
                    pdf.save("Assessment_Report.pdf");
                }).catch(error => console.error("Error generating PDF:", error));
            }
</script>
@endsection