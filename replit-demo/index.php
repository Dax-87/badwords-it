<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>badwords-it — live demo</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            background: #0f0f0f;
            color: #e8e8e8;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 16px;
        }
        header {
            text-align: center;
            margin-bottom: 36px;
        }
        header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #fff;
        }
        header p {
            margin-top: 8px;
            color: #888;
            font-size: 0.95rem;
        }
        header a {
            color: #6c9cf8;
            text-decoration: none;
        }
        header a:hover { text-decoration: underline; }

        .card {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            padding: 28px;
            width: 100%;
            max-width: 560px;
        }

        label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #999;
            margin-bottom: 6px;
        }
        input[type=text], input[type=email] {
            width: 100%;
            padding: 10px 14px;
            background: #111;
            border: 1px solid #333;
            border-radius: 8px;
            color: #e8e8e8;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.15s;
            margin-bottom: 18px;
        }
        input[type=text]:focus, input[type=email]:focus {
            border-color: #6c9cf8;
        }

        button {
            width: 100%;
            padding: 11px;
            background: #6c9cf8;
            color: #000;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s;
        }
        button:hover { background: #8ab4fa; }

        .results {
            margin-top: 24px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .result-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-radius: 8px;
            background: #111;
            border: 1px solid #222;
        }
        .result-label { font-size: 0.9rem; color: #bbb; }
        .badge {
            font-size: 0.8rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .badge-ok    { background: #1a3a1a; color: #4caf50; border: 1px solid #2a5a2a; }
        .badge-flagged { background: #3a1a1a; color: #f44336; border: 1px solid #5a2a2a; }

        footer {
            margin-top: 32px;
            font-size: 0.8rem;
            color: #555;
            text-align: center;
        }
        footer a { color: #6c9cf8; text-decoration: none; }
        footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<header>
    <h1>badwords-it</h1>
    <p>Italian profanity &amp; spam filter for PHP &mdash;
       <a href="https://github.com/Dax-87/badwords-it" target="_blank">view on GitHub</a>
    </p>
</header>

<div class="card">
    <form method="post" action="">
        <label for="text">Text to check</label>
        <input type="text" id="text" name="text"
               placeholder="Scrivi qualcosa in italiano..."
               value="<?= htmlspecialchars($_POST['text'] ?? '') ?>">

        <label for="email">Email to check</label>
        <input type="email" id="email" name="email"
               placeholder="esempio@dominio.it"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

        <button type="submit">Check</button>
    </form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/src/Filter.php';

    $filter = new \BadwordsIt\Filter(
        __DIR__ . '/data/profanity.php',
        __DIR__ . '/data/spam.php'
    );

    $text  = trim($_POST['text']  ?? '');
    $email = trim($_POST['email'] ?? '');

    $textProvided  = $text  !== '';
    $emailProvided = $email !== '';

    $profanityText  = $textProvided  ? $filter->hasProfanity($text)       : null;
    $profanityEmail = $emailProvided ? $filter->hasProfanityEmail($email)  : null;
    $spam           = $textProvided  ? $filter->hasSpam($text)             : null;

    function badge(bool $flagged): string {
        return $flagged
            ? '<span class="badge badge-flagged">Flagged</span>'
            : '<span class="badge badge-ok">Clean</span>';
    }

    echo '<div class="results">';

    if ($textProvided) {
        echo '<div class="result-row">';
        echo '<span class="result-label">Profanity in text</span>';
        echo badge($profanityText);
        echo '</div>';

        echo '<div class="result-row">';
        echo '<span class="result-label">Spam in text</span>';
        echo badge($spam);
        echo '</div>';
    }

    if ($emailProvided) {
        echo '<div class="result-row">';
        echo '<span class="result-label">Profanity in email</span>';
        echo badge($profanityEmail);
        echo '</div>';
    }

    echo '</div>';
}
?>

</div>

<footer>
    <a href="https://github.com/Dax-87/badwords-it" target="_blank">Dax-87/badwords-it</a>
    &mdash; MIT License
</footer>

</body>
</html>
