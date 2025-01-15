<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card stats-card bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2 text-muted">Total Tasks</h6>
                            <h2 class="card-title mb-0"><?= $taskCounts['all'] ?></h2>
                        </div>
                        <div class="fs-1 text-primary">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card stats-card bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2 text-muted">Pending</h6>
                            <h2 class="card-title mb-0"><?= $taskCounts['pending'] ?></h2>
                        </div>
                        <div class="fs-1 text-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card stats-card bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2 text-muted">Completed</h6>
                            <h2 class="card-title mb-0"><?= $taskCounts['completed'] ?></h2>
                        </div>
                        <div class="fs-1 text-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Bar -->
    <div class="card mb-4 stats-card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <a href="/tasks/new" class="btn btn-primary btn-action">
                        <i class="fas fa-plus me-2"></i>Create New Task
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-md-end w-100 w-md-auto" role="group">
                        <a href="/tasks" class="btn filter-btn <?= !isset($currentStatus) ? 'btn-primary' : 'btn-outline-primary' ?>">
                            <i class="fas fa-list me-2"></i>All 
                            <span class="badge bg-white text-primary ms-2"><?= $taskCounts['all'] ?></span>
                        </a>
                        <a href="/tasks?status=pending" class="btn filter-btn <?= $currentStatus === 'pending' ? 'btn-warning' : 'btn-outline-warning' ?>">
                            <i class="fas fa-clock me-2"></i>Pending 
                            <span class="badge bg-white text-warning ms-2"><?= $taskCounts['pending'] ?></span>
                        </a>
                        <a href="/tasks?status=completed" class="btn filter-btn <?= $currentStatus === 'completed' ? 'btn-success' : 'btn-outline-success' ?>">
                            <i class="fas fa-check me-2"></i>Completed 
                            <span class="badge bg-white text-success ms-2"><?= $taskCounts['completed'] ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Message -->
    <?php if(session()->getFlashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show stats-card" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Tasks Grid -->
    <?php if(empty($tasks)): ?>
        <div class="alert alert-info stats-card">
            <i class="fas fa-info-circle me-2"></i>No tasks found for the selected filter.
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($tasks as $task): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card task-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0"><?= esc($task['title']) ?></h5>
                            <span class="badge status-badge bg-<?= $task['status'] === 'completed' ? 'success' : 'warning' ?>">
                                <i class="fas fa-<?= $task['status'] === 'completed' ? 'check' : 'clock' ?> me-1"></i>
                                <?= ucfirst($task['status']) ?>
                            </span>
                        </div>
                        <p class="card-text text-muted"><?= esc($task['description']) ?></p>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Due: <?= date('M d, Y', strtotime($task['due_date'])) ?>
                            </small>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="/tasks/edit/<?= $task['id'] ?>" class="btn btn-sm btn-outline-primary btn-action">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <form action="/tasks/delete/<?= $task['id'] ?>" method="post" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-action" 
                                        onclick="return confirm('Are you sure you want to delete this task?')">
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>