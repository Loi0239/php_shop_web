<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counter Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</head>
<body>
    <button id="btn">Click me</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#btn').on('click',function(){
            Swal.fire({
                icon: 'success', // Specify the type of icon here
                title: 'abc',
                text: 'hello'
            })
        })
    </script>
</body>
</html>

