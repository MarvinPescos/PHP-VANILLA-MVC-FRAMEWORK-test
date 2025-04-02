<div class="card">
  <div class="card-header">
    <h1><?= $title ?></h1>
  </div>
  <div class="card-body">
    <form method="post" action="/task/<?= $task['id']?>">
    <input type="hidden" name="_method" value="PUT">
      <div class="mb-3">
        <label for="name" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= $task['title'] ?>"  required>
      </div>
      <div class="mb-3">
      <label for="name" class="form-label">status</label>
      <select name="status">
    <option value="pending">Pending</option>
    <option value="completed">Completed</option>
</select>
      </div>
      <button type="submit" class="btn btn-primary">Create Task</button>
      <a href="/index/task" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>