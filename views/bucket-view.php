<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
</head>
<body>
    <form action="<?php echo base_url('image/upload'); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="image">
        <button type="submit">Upload</button>
    </form>
</body>
</html>