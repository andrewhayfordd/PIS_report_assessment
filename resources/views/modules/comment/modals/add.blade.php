<div class="modal fade" id="addCommentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Student Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-comment-form" method="POST" action="{{ route('comments.store') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="add-student-no" name="student_no" required>
                    <input type="hidden" id="add-acyear" name="acyear" required>
                    <input type="hidden" id="add-term" name="term" required>

                    <div class="form-group">
                        <label for="ct_remarks">Comment</label>
                        <textarea class="form-control" id="ct_remarks" name="ct_remarks" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Comment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<script>
    $('#add-comment-form').submit(function(e) {
        e.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to save this comment?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Submit"
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Submit the form after confirmation
            }
        });
    });
</script>
