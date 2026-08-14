<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
</head>
<body>
    <h1>Feedback</h1>

    <form method="POST" action="/feedback">
        @csrf
        <label for="message">Message</label>
        <textarea name="message" id="message" cols="30" rows="5"></textarea>
        <br>
        <button type="submit">Send feedback</button>
    </form>

    <form method="POST" action="/feedback/1">
        @csrf
        @method('DELETE')
        <button type="submit">Delete feedback 1</button>
    </form>
</body>
</html>
