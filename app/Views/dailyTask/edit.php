<div class="card">
  <div class="card-header">
    <h1><?= $title ?></h1>
  </div>
  <div class="card-body">
    <form method="post" action="/dailyTask/<?= $dailyTasks['id']?>">
    <input type="hidden" name="_method" value="PUT">
      <div class="mb-3">
        <label for="name" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= $dailyTasks['title'] ?>"  required>
      </div>
      <div class="mb-3">
      <label for="name" class="form-label">status</label>
      <select name="status">
    <option value="pending">Pending</option>
    <option value="completed">Completed</option>
</select>
<select name="difficulty">
    <option value="easy">easy</option>
    <option value="medium">medium</option>
    <option value="hard">hard</option>
</select>
      </div>
      <button type="submit" class="btn btn-primary">update Task</button>
    </form>
  </div>
</div>