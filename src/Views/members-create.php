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
    <h1>Add Member</h1>
    <form action="/members" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control " id="name" name="name" value="" required="">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control " id="email" name="email" value="" required="">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="number" class="form-control " id="phone" name="phone" value="" required="">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
</body>
</html>