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
            color: #e0e0e0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }
        .card {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 14px;
            padding: 40px;
            width: 100%;
            max-width: 600px;
        }
        .logo {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #555;
            margin-bottom: 8px;
        }
        h1 {
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
        }
        .tagline {
            font-size: 13px;
            color: #666;
            margin-bottom: 32px;
            line-height: 1.5;
        }
        .field { margin-bottom: 20px; }
        label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 7px;
        }
        label .fixed-badge {
            font-size: 10px;
            background: #2a2a2a;
            color: #555;
            padding: 1px 6px;
            border-radius: 4px;
            margin-left: 6px;
            text-transform: none;
            letter-spacing: 0;
            font-weight: 400;
        }
        input[readonly], textarea {
            width: 100%;
            padding: 11px 14px;
            border-radius: 8px;
            border: 1px solid #2a2a2a;
            font-size: 14px;
            outline: none;
            font-family: inherit;
        }
        input[readonly] {
            background: #141414;
            color: #444;
            cursor: not-allowed;
        }
        textarea {
            background: #222;
            color: #e0e0e0;
            resize: vertical;
            min-height: 100px;
            transition: border-color .2s;
        }
        textarea:focus { border-color: #444; }
        textarea::placeholder { color: #444; }
        button {
            width: 100%;
            padding: 13px;
            background: #e0e0e0;
            color: #111;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 4px;
            transition: background .2s;
        }
        button:hover { background: #fff; }

        /* Result box */
        .result {
            margin-top: 24px;
            padding: 20px;
            border-radius: 10px;
            font-size: 14px;
            line-height: 1.8;
            border: 1px solid;
        }
        .result.clean   { background: #0a1f0a; border-color: #1a4a1a; color: #6abf6a; }
        .result.blocked { background: #1f0a0a; border-color: #4a1a1a; color: #e07070; }
        .result-title { font-size: 16px; font-weight: 700; margin-bottom: 12px; }
        .badges { display: flex; gap: 10px; flex-wrap: wrap; }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge.yes { background: #4a1a1a; color: #e07070; border: 1px solid #7a2a2a; }
        .badge.no  { background: #0a2a0a; color: #6abf6a; border: 1px solid #1a4a1a; }
        .badge .dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; }

        /* Code block */
        .code-wrap { margin-top: 20px; }
        .code-label { font-size: 11px; color: #555; margin-bottom: 6px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; }
        pre {
            background: #111;
            border: 1px solid #222;
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 12px;
            color: #aaa;
            overflow-x: auto;
            line-height: 1.6;
        }
        .key   { color: #6abf6a; }
        .val-t { color: #e07070; }
        .val-f { color: #6abf6a; }

        /* Footer */
        .footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #222;
            font-size: 12px;
            color: #444;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }
        .footer a { color: #666; text-decoration: none; }
        .footer a:hover { color: #aaa; }

        @media (max-width: 500px) {
            .card { padding: 24px 18px; }
        }
    </style>
</head>
<body>
<?php
require_once __DIR__ . '/src/Filter.php';

use BadwordsIt\Filter;

$filter  = new Filter();
$result  = null;
$name    = 'Mario Rossi';
$email   = 'mario.rossi@gmail.com';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message'] ?? '');
    $result  = $filter->inspect([$name, $message], $email);
}
?>
<div class="card">
    <div class="logo">PHP Library</div>
    <h1>badwords-it</h1>
    <p class="tagline">Italian profanity &amp; spam filter — three-level detection engine.<br>Type anything below to test it live.</p>

    <form method="post">
        <div class="field">
            <label>Name <span class="fixed-badge">fixed</span></label>
            <input type="text" value="<?= htmlspecialchars($name) ?>" readonly>
        </div>
        <div class="field">
            <label>Email <span class="fixed-badge">fixed</span></label>
            <input type="text" value="<?= htmlspecialchars($email) ?>" readonly>
        </div>
        <div class="field">
            <label>Message</label>
            <textarea name="message" placeholder="Try: che cazzo, buy bitcoin, vaffanculo, porco dio..."><?= htmlspecialchars($message) ?></textarea>
        </div>
        <button type="submit">Run filter →</button>
    </form>

    <?php if ($result !== null): ?>
        <?php $blocked = $result['profanity'] || $result['spam']; ?>
        <div class="result <?= $blocked ? 'blocked' : 'clean' ?>">
            <div class="result-title"><?= $blocked ? '⛔ Content blocked' : '✅ Content clean' ?></div>
            <div class="badges">
                <span class="badge <?= $result['profanity'] ? 'yes' : 'no' ?>">
                    <span class="dot"></span>
                    Profanity: <?= $result['profanity'] ? 'DETECTED' : 'NONE' ?>
                </span>
                <span class="badge <?= $result['spam'] ? 'yes' : 'no' ?>">
                    <span class="dot"></span>
                    Spam: <?= $result['spam'] ? 'DETECTED' : 'NONE' ?>
                </span>
            </div>

            <div class="code-wrap">
                <div class="code-label">Filter::inspect() → output</div>
                <pre><?php
                $pVal = $result['profanity'] ? 'true' : 'false';
                $sVal = $result['spam']      ? 'true' : 'false';
                $pClass = $result['profanity'] ? 'val-t' : 'val-f';
                $sClass = $result['spam']      ? 'val-t' : 'val-f';
                echo '[' . "\n";
                echo '  <span class="key">"profanity"</span> => <span class="' . $pClass . '">' . $pVal . '</span>,' . "\n";
                echo '  <span class="key">"spam"</span>      => <span class="' . $sClass . '">' . $sVal . '</span>,' . "\n";
                echo ']';
                ?></pre>
            </div>
        </div>
    <?php endif ?>

    <div class="footer">
        <span>dax-87/badwords-it</span>
        <a href="https://github.com/Dax-87/badwords-it" target="_blank">GitHub →</a>
    </div>
</div>
</body>
</html>
