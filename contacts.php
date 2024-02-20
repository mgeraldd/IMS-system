
<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
        .contact-section {
            margin-top: 100px;
        }
        
        .contact-section .row {
            align-items: flex-start;
        }
        
        .contact-form {
            margin-right: 30px;
        }
        
        .map-sidebar {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }
        
        .map-sidebar h3 {
            margin-bottom: 20px;
        }
        
        .map-sidebar img {
            width: 100%;
            max-width: 300px;
            height: auto;
        }
    </style>
</head>
<body>
    <?php include_once "top-nav.php"; ?>
    
    <div class="container contact-section">
        <div class="row">
            <div class="col-md-8 contact-form">
                <h1>Contact Us</h1>
                <form action="submit.php" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
