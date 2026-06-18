<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Form</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5;">

<h2 style="margin-top:0;">New Contact Message</h2>

<p><strong>Name:</strong> {{ $name ?? '' }}</p>
<p><strong>Email:</strong> {{ $email ?? '' }}</p>
<p><strong>Subject:</strong> {{ $subject ?? '' }}</p>

<hr>

<p style="white-space: pre-wrap;">{{ $message ?? '' }}</p>

</body>
</html>

