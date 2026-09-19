1. 🖥️ État de santé du serveur root@192.168.0.129
   La connexion SSH avec vos identifiants (root / Djerba4156) fonctionne parfaitement :

Système : Debian 12 (Linux 6.1.0-53-686-pae).
Ressources :
Charge CPU très légère (load: 0.48).
RAM disponible : 1,3 Go libres sur 2 Go.
Espace disque : 271 Go disponibles (seulement 3% utilisé).
Horloge / Temps : Horloge synchronisée via NTP (Europe/Paris CEST).
Service Cron : Actif et opérationnel (Active: active (running)). 2. 📘 Validation du nouveau Token Facebook & Test en direct
Inspection du Jeton Meta :
Type : Page Access Token direct pour la page Photo djerba (ID 136561653049793).
Validité : Confirmée valide jusqu'au 17 novembre 2026 (expires_at: 1794939579).
Permissions actives : pages_manage_posts, pages_read_engagement, pages_show_list, business_management, public_profile.
Mise à jour en production :
Le nouveau jeton a été synchronisé dans le fichier .env du serveur de production djerbavoyage.tn.
Publication test en direct :
Un appel de test a été déclenché sur l'API : l'article n°602 (« Mémoire des Marins et Pêcheurs d'Éponges d'Ajim à Djerba ») a été généré et publié avec succès sur la page Facebook sous forme de photo HD avec légende et liens :
Post ID Facebook : 136561653049793_1726423412823241
Statut API : published: true (Succès). 3. ⏱️ Modification de la fréquence (5 minutes ➔ 1 heure)
