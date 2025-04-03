<div class="card">
  <div class="card-header">
    <h1><?= $title ?></h1>
  </div>
  <div class="card-body">
    <form method="post" action="/dailyTask">
      <div class="mb-3">
        <label for="name" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
      </div>
      <div class="mb-3">
      <label for="name" class="form-label">status</label>
      <select name="status">
    <option value="pending">Pending</option>
    <option value="completed">Completed</option>
      </select>
      <select name = "difficulty">
        <option value="easy" selected >Easy</option>
        <option value="medium">Medium</option>
        <option value="hard">Hard</option>
      </select>
      </div>
      <button type="submit" class="btn btn-primary">Create Task</button>
      <a href="/dailyTask/index" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>