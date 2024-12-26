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
    <h1>Add Loan</h1>
    <form action="/loans" method="POST">
        <div class="mb-3">
            <label for="member_id" class="form-label">Member</label>
            <select class="form-control" id="member_id" name="member_id" required>
                <option value="">Select Member</option>
                <?php foreach ($members as $member): ?>
                    <option value="<?= $member['id'] ?>">
                        <?= $member['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="book_id" class="form-label">Book</label>
            <select class="form-control" id="book_id" name="book_id" required>
                <option value="">Select Book</option>
                <?php foreach ($books as $book): ?>
                <option value="<?= $book['id'] ?>">
                    <?= $book['title'] ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
</body>
</html>