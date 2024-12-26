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
    <h1>Books</h1>
    <a href="/books/create" class="btn btn-primary mb-3">Add Book</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Author</th>
            <th>Published Year</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($books as $book) : ?>
        <tr>
            <td><?= $book['id'] ?></td>
            <td><?= $book['title'] ?></td>
            <td><?= $book['published_year'] ?></td>
            <td><?= $book['author'] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>