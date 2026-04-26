<?php

return [

    // Keywords that typically indicate spam or injection attempts
    'keywords' => [
        'bitcoin', 'crypto', 'cryptocurrency', 'forex', 'trading',
        '.ru', '.cn', '.tk', '.top', '.xyz',
        'select', 'union', 'drop', 'insert', 'delete', 'update',
        '<script', 'javascript:', 'onclick', 'onerror', 'onload',
        'phishing', 'spam', 'click here', 'buy now', 'free money',
        'make money', 'work from home', 'lose weight', 'casino',
        'viagra', 'cialis', 'pharmacy', 'pills', 'drugs',
        'href=', 'src=', 'eval(', 'base64',
    ],

];
