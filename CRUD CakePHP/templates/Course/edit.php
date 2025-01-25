<form id="add-course-form" class="needs-validation" action="/course/edit/<?= $edit->id ?? 0?>" method="post">
    <div class="mb-3">
        <label for="course-name" class="form-label">Course Name</label>
        <input type="text" id="course-name" name="name" class="form-control" placeholder="Enter course name" value="<?= $edit->name?>">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
