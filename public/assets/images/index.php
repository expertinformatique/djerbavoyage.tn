<?php
// Empêcher l'accès direct et le listing du dossier
http_response_code(403);
exit('Accès interdit.');
