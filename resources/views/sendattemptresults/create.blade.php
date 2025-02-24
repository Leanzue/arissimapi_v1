<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Send Attempt Result</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<h1>Create New Send Attempt Result</h1>

<form action="{{ route('sendattemptresults.store') }}" method="POST">
    @method('post')
    @csrf
    <div>
        <label for="date_of_sending_results">Date of Sending Results:</label>
        <input type="date" name="date_of_sending_results" id="date_of_sending_results" required>
    </div>
    <div>
        <label for="details">Details:</label>
        <textarea name="details" id="details" required></textarea>
    </div>
    <div>
        <label for="error_code">Error Code:</label>
        <input type="text" name="error_code" id="error_code">
    </div>
    <div>
        <label for="number_of_attempts">Number of Attempts:</label>
        <input type="number" name="number_of_attempts" id="number_of_attempts" required>
    </div>
    <button type="submit">Create OK</button>
</form>
</body>
</html>
