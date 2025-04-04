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




    <div style="padding: 20px; font-family: Arial, sans-serif; line-height: 1.6;" id="printSection">
    <h3 style="text-align: center; color: #007bff; font-weight: bold;">PIS – MODEL MONTESSORI SCHOOL</h3>
    <h5 style="text-align: center; font-weight: bold;">CAMBRIDGE ASSESSMENT INTERNATIONAL EDUCATION</h5>
    <h6 style="text-align: center; font-weight: bold;">TERM {{ $term }}, {{ $academicYear }} ACADEMIC YEAR</h6>
    <h4 style="text-align: center; margin-top: 20px; font-weight: bold; text-decoration: underline;">FINAL ASSESSMENT REPORT</h4>
    
    <div style="border: 2px solid #000; padding: 15px; margin-bottom: 20px; background-color: #f8f9fa;">
        <div style="display: flex; justify-content: space-between;">

            <div>
                <p><strong>Student No:</strong> {{ $student->student_no }}</p>
            </div>
            <div>
            <p><strong>Student Name:</strong> {{ $student->student_name }}</p>
            </div>

        </div>

        
            <div style="display: flex; justify-content: space-between;">
                <div>
                <p><strong>Class:</strong> {{ $student->current_class }}</p>
                </div>
                <div>
                <p><strong>Grade:</strong> {{ $student->current_grade }}</p>
                </div>
                <div>
                <p><strong>Academic Year:</strong> {{ $academicYear }} - Term {{ $term }}</p>
                </div>
            </div>

        </div>
    
        
        <div style="display: flex; width: full; justify-content: space-between; gap: 2rem">
        <div style="border: 2px solid #000; padding: 15px; margin-bottom: 20px; background-color: #fff; width: 30%">
        <h6 style="font-weight: bold; text-decoration: underline;">Attendance</h6>
        <table style="width: 100%; border-collapse: collapse; border: 2px solid #000;">
            <thead>
                <tr style="background: #ddd;">
                    <th style="border: 2px solid #000; padding: 8px;">Status</th>
                    <th style="border: 2px solid #000; padding: 8px;">Term</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 2px solid #000; padding: 8px; text-align: left;">Present</td>
                    <td style="border: 2px solid #000; padding: 8px;"> </td>
                </tr>
                <tr>
                    <td style="border: 2px solid #000; padding: 8px; text-align: left;">Absent</td>
                    <td style="border: 2px solid #000; padding: 8px;"></td>
                </tr>
                <tr>
                    <td style="border: 2px solid #000; padding: 8px; text-align: left;">Total</td>
                    <td style="border: 2px solid #000; padding: 8px;"></td>
                </tr>
                <tr>
                    <td style="border: 2px solid #000; padding: 8px; text-align: left;">.</td>
                    <td style="border: 2px solid #000; padding: 8px;">.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="border: 2px solid #000; padding: 15px; margin-bottom: 20px; background-color: #fff; width:70%;">
        <h6 style="font-weight: bold; text-decoration: underline;">Marking Key</h6>
        <table style="width: 100%; border-collapse: collapse; border: 2px solid #000;">
            <thead>
                <tr style="background: #ddd;">
                    <th style="border: 2px solid #000; padding: 8px;">Grade</th>
                    <th style="border: 2px solid #000; padding: 8px;">Grade</th>
                    <th style="border: 2px solid #000; padding: 8px;">Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 2px solid #000; padding: 4px; text-align: left; font-size: 14px;"><strong>Outstanding</strong></td>
                    <td style="border: 2px solid #000; padding: 4px; text-align: left; font-size: 14px;"><strong>O</strong></td>
                    <td style="border: 2px solid #000; padding: 4px; font-size: 14px;">Displays strong performance</td>
                </tr>
                <tr>
                    <td style="border: 2px solid #000; padding: 4px; text-align: left; font-size: 14px;"><strong>Very Good</strong></td>
                    <td style="border: 2px solid #000; padding: 4px; text-align: left; font-size: 14px;"><strong>A</strong></td>
                    <td style="border: 2px solid #000; padding: 8px; font-size: 14px;">Demonstrates appropriate performance</td>
                </tr>
                <tr>
                    <td style="border: 2px solid #000; padding: 4px; text-align: left; font-size: 14px;"><strong>Good </strong></td>
                    <td style="border: 2px solid #000; padding: 4px; text-align: left; font-size: 14px;"><strong>B</strong></td>
                    <td style="border: 2px solid #000; padding: 4px; font-size: 14px;">Needs occasional support/strengthening</td>
                </tr>
                <tr>
                    <td style="border: 2px solid #000; padding: 4px; text-align: left; font-size: 14px;"><strong>Fair</strong></td>
                    <td style="border: 2px solid #000; padding: 4px; text-align: left; font-size: 14px;"><strong>C</strong></td>
                    <td style="border: 2px solid #000; padding: 4px; font-size: 14px;">Needs consistent support/strengthening</td>
                </tr>
                <tr>
                    <td style="border: 2px solid #000; padding: 4px; text-align: left; font-size: 14px;"><strong>Can do better</strong></td>
                    <td style="border: 2px solid #000; padding: 4px; text-align: left; font-size: 14px;"><strong>D</strong></td>
                    <td style="border: 2px solid #000; padding: 4px; font-size: 14px;">Needs to work harder and improve</td>
                </tr>
            </tbody>
        </table>
    </div>

        </div>

    
    @if(count($assessmentItems) > 0)
        @foreach($assessmentItems as $categoryCode => $category)
            <div style="border: 2px solid #000; padding: 15px; margin-bottom: 20px;">
                <h5 style="font-weight: bold;">{{ $category['name'] }}</h5>
                @foreach($category['subcategories'] as $subcategoryCode => $subcategory)
                    <h6 style="background: #f8f9fa; padding: 10px; font-weight: bold;">{{ $subcategory['name'] }}</h6>
                    <table style="width: 100%; border-collapse: collapse; border: 2px solid #000;">
                        <thead>
                            <tr style="background: #ddd;">
                                <th style="border: 2px solid #000; padding: 8px;">Assessment Item</th>
                                <th style="border: 2px solid #000; padding: 8px;">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subcategory['items'] as $item)
                                <tr>
                                    <td style="border: 2px solid #000; padding: 4px; font-size:14px;">{{ $item['desc'] }}</td>
                                    <td style="border: 2px solid #000; padding: 4px 7px; text-align: center;">
                                        {{ $item['result'] }}
                                        @if($item['result'] == 'O') 
                                        @elseif($item['result'] == 'A')
                                        @elseif($item['result'] == 'B')
                                        @elseif($item['result'] == 'C')
                                        @elseif($item['result'] == 'D')
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        @endforeach
    @else
        <div style="border: 2px solid #000; padding: 15px; background: #f8d7da; color: #721c24;">
            <h5>No Assessment Data</h5>
            <p>There are no assessment records for this student in {{ $academicYear }} - Term {{ $term }}.</p>
        </div>
    @endif
    

    <br/>
    <br/>
    @if(count($assessmentItems) > 0)
        <div style="border: 2px solid #000; padding: 15px; margin-top: 20px;">
            <h5 style="font-weight: bold;">Assessment Summary</h5>
            <p><strong>Teacher's Comments:</strong> {{ isset($teacherComment) && !empty($teacherComment) ? $teacherComment : 'No comments available.' }}</p>
        </div>
    @endif
    
    <br/>
    <br/>
    <br/>
    <div style="margin-top: 20px; display: flex; justify-content: space-between;">
        <div>
            <p><strong>Sign:</strong> ____________________</p>
            <p>Class Teacher</p>
        </div>
        <div>
            <p><strong>Sign:</strong> ____________________</p>
            <p>Academic Coordinator</p>
        </div>
    </div>
</div>
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