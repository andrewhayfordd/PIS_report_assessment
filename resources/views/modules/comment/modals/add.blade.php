<div class="modal fade" id="addCommentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Comment</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label>Student No</label>
                    <input type="text" name="student_no" class="form-control" required>
                    <label>Academic Year</label>
                    <input type="text" name="acyear" class="form-control" required>
                    <label>Term</label>
                    <input type="text" name="term" class="form-control" required>
                    <label>Comment</label>
                    <textarea name="ct_remarks" class="form-control" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
