<?php

return [

    // Level 1 — regex word-boundary (isolated words)
    'regex' => '/\b(bastard[oaie]|bastardi|bernarda|bischero|bocchino|bordello|cacare|cagare|caghetta|cagone|cazzata|cazzo|cazzon[ei]?|cesso|ciucciata|coglion[ae]|cretino|cretina|culattone|culo|culon[ae]?|deficiente|figa|fottut[oa]|frocio|frocione|frocett[oa]|gesu|ges[uù]|imbecill[ei]|incazzar[ei]|incazzat[oi]|madonna|maronna|merda|merdina|merdona|merdaccia|mignotta|mignottone|mignottona|mortacci|negro|negra|pall[ae]|pippa|pippone|pippona|pippaccia|pirla|pompino|porco|porca|puttana|puttanone|puttanona|puttaniere|puttanate|rompiballe|rompipalle|rompicoglioni|scazzi|scemo|scema|scopare|scopata|stronzata|stronzo|stronzone|succhi[ao]|troia|troione|trombata|vaffanculo|zoccola|zoccolona|minchia|minkia|sfigato|sfigata|maiale|cornuto|cornuta|fanculo|affanculo)\b/i',

    // Level 2 — substring (catches concatenations like "cazzomerda", "madonnaputtana")
    'substrings' => [
        'puttana', 'merda', 'cazzo', 'figa', 'stronz', 'coglion',
        'vaffan', 'minchia', 'minkia', 'succhia', 'porcodio', 'porcoddio',
    ],

    // Level 3 — compound phrases
    'phrases' => [
        'porco dio', 'porca miseria', 'figlio di puttana', 'testa di cazzo',
        'dio cane', 'dio ladro', 'dio porco', 'dio bono', 'porca vacca',
        'va fanculo', 'delle palle', 'le palle', 'che palle',
    ],

    // Email — pure substring on local part + domain name (no word boundary)
    'email_substrings' => [
        'puttana', 'merda', 'cazzo', 'cazz', 'figa', 'stronz', 'coglion',
        'vaffan', 'minchia', 'minkia', 'succhia', 'porcodio', 'porcoddio',
        'culo', 'palle', 'porco', 'porca', 'cornuto', 'cornuta', 'sfigato',
        'maiale', 'dio', 'negr', 'scemo', 'scema', 'deficiente', 'cretino',
        'cretina', 'imbecille', 'zoccol', 'mignott', 'bocchino', 'pompino',
        'frocio', 'scopar', 'pippa', 'pirla', 'bordello', 'gesu',
    ],

];
