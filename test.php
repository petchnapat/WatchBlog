<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap 5 Tabs</title>
    <!-- นำเข้า Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<style>
        /* CSS เพื่อทำให้ footer ติดอยู่ด้านล่าง */
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
        }
        footer {
            background-color: #f8f9fa;
            padding: 1rem 0;
            text-align: center;
        }
    </style>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check" viewBox="0 0 16 16">
    <title>Check</title>
    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"></path>
  </symbol>
</svg>

<div class="container py-3">
    <div class="card ">
        <div class="card-body">
            <h5 class="card-title">Title</h5>
            <p class="card-text">Content</p>
        </div>
    </div>
</div>

<footer class="mt-auto">
    <div class="container">
        <span class="text-muted">© 2024 Your Company. All Rights Reserved.</span>
    </div>
</footer>
    
  

</body>
</html>