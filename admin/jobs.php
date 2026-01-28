<?php
// ------------------- Includes -------------------
include __DIR__ . '/../includes/db_connect.php';
include __DIR__ . '/../includes/head.php';

// ------------------- Handle Add Job -------------------
if(isset($_POST['add_job'])){
    $title = $mysqli->real_escape_string($_POST['title']);
    $description = $mysqli->real_escape_string($_POST['description']);

    if($title && $description){
        $mysqli->query("INSERT INTO jobs (title, description, created_at) VALUES ('$title', '$description', NOW())");
        header("Location: jobs.php");
        exit;
    }
}

// ------------------- Handle Delete Job -------------------
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $mysqli->query("DELETE FROM jobs WHERE id = $id");
    header("Location: jobs.php");
    exit;
}

// ------------------- Fetch Jobs -------------------
$jobsResult = $mysqli->query("SELECT * FROM jobs ORDER BY created_at DESC");
?>

<div class="container mt-5">
    <h2 class="mb-4">Manage Jobs</h2>

    <!-- Add Job Form -->
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-success text-white">Add New Job</div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Job Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter job title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Job Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter job description" required></textarea>
                </div>
                <button type="submit" name="add_job" class="btn btn-success">Add Job</button>
            </form>
        </div>
    </div>

    <!-- Existing Jobs -->
    <h3>Current Openings</h3>
    <table class="table table-bordered shadow-sm">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Job Title</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if($jobsResult->num_rows > 0): ?>
            <?php while($job = $jobsResult->fetch_assoc()): ?>
                <tr>
                    <td><?= $job['id'] ?></td>
                    <td><?= htmlspecialchars($job['title']) ?></td>
                    <td><?= nl2br(htmlspecialchars($job['description'])) ?></td>
                    <td><?= $job['created_at'] ?></td>
                    <td>
                        <a href="?delete=<?= $job['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this job?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center text-muted">No jobs found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<style>
/* Add some shadow and spacing */
.card-header {
    font-weight: bold;
    font-size: 1.1rem;
}
</style>
