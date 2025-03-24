<div class="modal fade" id="editCommentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Student Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('comments.update', ['transid' => '__TRANSID__']) }}" id="edit-comment-form">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-transid" name="transid" required>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-remarks">Comment</label>
                        <textarea class="form-control" id="edit-remarks" name="ct_remarks" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Comment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<script>
    // Update form action dynamically
    $('#editCommentModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var transid = button.data('transid');
        var remarks = button.data('remarks');
        var modal = $(this);
        
        // Update form action with the correct transid
        var form = modal.find('#edit-comment-form');
        form.attr('action', form.attr('action').replace('__TRANSID__', transid));
        
        modal.find('#edit-transid').val(transid);
        modal.find('#edit-remarks').val(remarks);
    });

    // Add Swal confirmation before submitting the edit form
    $('#edit-comment-form').submit(function(e) {
        e.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to update this comment?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Update"
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Submit the form if confirmed
            }
        });
    });
</script>
