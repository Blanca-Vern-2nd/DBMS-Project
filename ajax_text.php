<!DOCTYPE html>
<html>
<head>
    <title>AJAX Example</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#load-data').click(function() {
                $.ajax({
                    url: 'data.txt',
                    success: function(response) {
                        $('#data').text(response);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <button id="load-data">Load Data</button>
    <div id="data"></div>
</body>
</html>