<p>Benvenuto nel gestionale di <?=$settings['site']['name']?>, <?=ucfirst($user->name)?>.<br>Sei collegato dalle <?=$session->entryDate?>.<br>Il tuo ultimo click è stato <?=getElapsedTime( time() -$session->lastActivity )?> fa.<br></p><p>Usa il menù in alto per navigare.</p><?php include_once BO . 'sessions.php'; 