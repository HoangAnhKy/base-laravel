<h1> Course </h1>

<a class="btn btn-success" href="<?= BASE_URL ?>course/create"> Add course</a>

<div>
    <form class="row align-items-center" method="GET">
        <div class="offset-7 col-5">
            <div class="input-group">
                <input class="form-control" name="key_search" placeholder="Enter search query">
                <button type="submit" class="btn btn-success">Search</button>
            </div>
        </div>
    </form>

</div>

<div class="mt-2">
    <h2 class="text-center mb-4">Courses List</h2>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Status</th>
            <th scope="col">Created At</th>
            <th scope="col">Updated At</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($list_course)):?>
            <?php foreach ($list_course as $course): ?>
                <tr>
                    <td><?= h($course->id) ?></td>
                    <td><?= h($course->name) ?></td>
                    <td><?= h($course->status) ?></td>
                    <td><?= h($course->created_at) ?></td>
                    <td><?= h($course->updated_at) ?></td>
                    <td>
                        <a href="/course/view/<?= h($course->id) ?>" class="btn btn-sm btn-primary">View</a>
                        <a href="/course/edit/<?= h($course->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/course/delete/<?= h($course->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif;?>
        </tbody>
    </table>
</div>
<div>
    <?= $paginate ?? ""?>
</div>
