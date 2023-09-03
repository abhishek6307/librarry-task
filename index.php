<?php
require_once('controller/LibraryController.php');

$controller = new LibraryController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $controller->addBook($_POST['title'], $_POST['author'], $_POST['publicationYear'], $_POST['genre']);
    } elseif (isset($_POST['search'])) {
        $books = $controller->searchBook($_POST['searchTitle']);
    } elseif (isset($_POST['delete'])) {
        $controller->deleteBook($_POST['deleteIndex']);
    }
}

$library = $controller->getLibrary();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Personal Library</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .library-container {
            margin-top: 20px;
        }

        .book-card {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container library-container">
        <h1 class="text-center">Personal Library</h1>

        <div class="row">
            <!-- Add Book Form -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Add a Book</div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="author">Author:</label>
                                <input type="text" class="form-control" name="author" required>
                            </div>
                            <div class="form-group">
                                <label for="publicationYear">Publication Year:</label>
                                <input type="number" class="form-control" name="publicationYear" required>
                            </div>
                            <div class="form-group">
                                <label for="genre">Genre:</label>
                                <input type="text" class="form-control" name="genre" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="add">Add</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Search Form -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="searchTitle">Search by Title:</label>
                                <input type="text" class="form-control" name="searchTitle" required>
                            </div>
                            <button type="submit" class="btn btn-info" name="search">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display Library -->
       <h2 class="mt-4">Library</h2>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Publication Year</th>
                <th>Genre</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($library as $index => $book) : ?>
                <tr>
                    <td><?php echo $book['title']; ?></td>
                    <td><?php echo $book['author']; ?></td>
                    <td><?php echo $book['publicationYear']; ?></td>
                    <td><?php echo $book['genre']; ?></td>
                    <td>
                    <form method="post" onsubmit="return confirm('Are you sure you want to delete this book?');">
                            <input type="hidden" name="deleteIndex" value="<?php echo $book['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

        <?php if (isset($books)) : ?>
<div class="modal" id="searchResultsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Search Results</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                <?php if($books) {?>
                    <h6><?php echo count($books); $n=0; ?> Results Found</h6>
                    <?php foreach ($books as $book) : ?>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-9">
                                <h5><span><?php echo ++$n; ?>: </span><?php echo "Name : {$book['title']}"; ?></h5>
                                    <p><strong>Author : <?php echo "{$book['author']}"; ?> </strong></p>
                                    <p><strong>Publication Year:</strong> <?php echo $book['publicationYear']; ?></p>
                                    <p><strong>Genre:</strong> <?php echo $book['genre']; ?></p>
                                </div>
                                <div class="col-md-3 text-right">
                                <form method="post" onsubmit="return confirm('Are you sure you want to delete this book?');">
                            <input type="hidden" name="deleteIndex" value="<?php echo $book['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm" name="delete">Delete</button>
                        </form>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    <?php } else {?>

                        <h3>No Books found</h3>
                        <?php }  ?> 
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#searchResultsModal').modal('show');
                });
            </script>
        <?php endif; ?>
    </div>
</body>
</html>

