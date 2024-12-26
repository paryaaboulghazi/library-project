<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body data-new-gr-c-s-check-loaded="14.1215.0" data-gr-ext-installed="">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/">Library</a>
        <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="/members">Members</a></li>
            <li class="nav-item"><a class="nav-link" href="/books">Books</a></li>
            <li class="nav-item"><a class="nav-link" href="/loans">Loans</a></li>
        </ul>
    </div>
</nav>
<div class="container mt-4">
    <h1>Loans</h1>
    <a href="/loans/create" class="btn btn-primary mb-3">Add Loan</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Member</th>
            <th>Book</th>
            <th>Borrowed At</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($loans as $loan) : ?>
        <tr>
            <td><?= $loan['id'] ?></td>
            <td><?= $loan['member_name'] ?></td>
            <td><?= $loan['book_title'] ?></td>
            <td><?= $loan['created_at'] ?></td>
            <td><?= $loan['is_returned'] ? "Returned" : 'Not Returned' ?></td>
            <td>
                <?php if (!$loan['is_returned']): ?>
                    <form action="/loans/<?php echo $loan['id']; ?>/return" method="POST" style="display:inline;">
                        <button type="submit" class="btn btn-success">Mark as Returned</button>
                    </form>
                <?php else: ?>
                    Already Returned
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>