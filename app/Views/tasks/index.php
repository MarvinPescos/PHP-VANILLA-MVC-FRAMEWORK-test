<h2>Welcome, User</h2>

<?php if ($userStats): ?>
    <p>Level: <?= $userStats['level'] ?></p>
    <p>XP: <?= $userStats['xp'] ?>/<?= $userStats['level'] * 100 ?></p>
<?php else: ?>
    <p>No stats available.</p>
<?php endif; ?>


<div class="d-flex justify-content-between align-items-center mb-4">
  <h1><?= $title ?></h1>
  <a href="/task/create" class="btn btn-primary">Create New Tasks</a>
</div>

<?php if (empty($tasks)):?>
  <div class="alert alert-info">No task found.</div>
<?php else: ?>
    <ul>
        <?php foreach ($tasks as $task):?>
          
            <li>
                <form action="/task/<?= $task['id']?>/toggle" method="POST">
                <input type="checkbox" onchange="this.form.submit()" 
                           <?= $task['status'] === 'completed' ? 'checked' : '' ?>>
                    <?= $task['title'] ?>
                </form>
            </li>     

        <?php endforeach; ?>
    </ul>
    <?php endif; ?>


