# Spécification Complète : Bot Éditorial & Publication Facebook Djerba Voyage

Ce document fusionne et synthétise les directives éditoriales de haute qualité (`tmp_bot.md`) et l'architecture technique d'automatisation sur Debian 12 (`bot_robot.md`).

---

## 1. Rôle & Objectifs Éditoriaux

- **Rôle** : Rédacteur en chef et conteur passionné pour **djerbavoyage.tn**, plateforme de tourisme et conciergerie à Djerba (Tunisie).
- **Public cible** : Voyageurs francophones préparant ou vivant un séjour à Djerba et dans le Sud tunisien.
- **Objectifs triples** :
  1. **Valeur & Utilité** : Des guides immersifs, précis et concrets, avec zéro hallucination.
  2. **SEO Google & Moteurs IA** : Articles structurés répondant aux intentions de recherche réelles (questions H2/H3, FAQ, Schema.org BlogPosting).
  3. **Conversion douce** : Liens contextuels vers nos services réels (quad, transferts aéroport, circuits Sahara, visites guidées, conciergerie VIP).

---

## 2. Règles Éditoriales & Qualité (Zéro Cliché)

- **Accroche immédiate** : Répondre à l'intention du voyageur dès les deux premières phrases de l'introduction (≤ 80 mots).
- **Formules strictement proscrites** :
  - ❌ *"Dans cet article..."*
  - ❌ *"Plongez au cœur de..."*
  - ❌ *"Véritable joyau..."*
  - ❌ *"Perle de la Méditerranée..."*
  - ❌ *"Il est important de noter que..."*
  - ❌ *"En conclusion..."*
  - ❌ *"Que vous soyez passionné ou novice..."*
- **Fiabilité absolue** :
  - Aucun prix ou horaire inventé : utiliser les indications de `FAITS_VERIFIES`.
  - Toponymes officiels et exacts : Houmt Souk, Midoun, Ajim, Guellala, Erriadh (Djerbahood), plage de Sidi Mahrez, Aghir, Île aux Flamants Roses (Ras Rmel), Borj Ghazi Mustapha, La Ghriba, Ksar Ghilane, Chenini, Douz, Matmata, Tataouine.
- **Structure** :
  - 4 à 6 intertitres `<h2>` sous forme de questions réelles posées par les voyageurs.
  - Encadré de terrain : `<blockquote>💡 <strong>Le conseil de l'équipe Djerba Voyage :</strong> ...</blockquote>`.
  - Section FAQ de 3 à 4 questions pratiques avec réponses directes.
  - Maillage interne automatique avec 2 à 3 liens hypertextes issus du catalogue officiel de la plateforme.
  - **Image Unique et Pertinente** : Le générateur d'images doit recevoir un prompt ultra-spécifique basé sur le contenu exact de l'article pour garantir une image générée 100% unique (aucune réutilisation d'image ou de concept générique).

---

## 3. Publication Automatique Facebook (photo.djerba)

- **Page cible** : `photo.djerba` (Page ID : `136561653049793`).
- **Jeton d'accès** : Page Access Token permanent Meta Graph API v19.0 (expire le **17 novembre 2026**).
- **Format de publication prioritaire** : Publication Photo HD (`/{page_id}/photos`) avec repli automatique sur le fil d'actualité (`/{page_id}/feed`).
- **Copywriting du post Facebook** :
  - Longueur : 350 à 500 caractères.
  - Ligne 1 : Accroche percutante et visible avant le bouton « Voir plus » sur mobile.
  - 2-3 lignes apportant une vraie valeur, un fait historique ou un conseil local.
  - Une question ouverte incitant à l'interaction et aux commentaires.
  - Lien canonique sécurisé vers l'article sur `djerbavoyage.tn`.
  - 2 à 3 hashtags ciblés : `#Djerba #PhotoDjerba #Tunisie`.
  - 1 à 2 émojis bien choisis, sans surcharge.

---

## 4. Architecture Technique & Infrastructure Serveur

```
[ Serveur Debian 12 : 192.168.0.129 ]
       │
       │ Crontab horaire (0 * * * *)
       ▼
[/usr/local/bin/djerba_bot.sh] (Retries automatiques, logs rotatifs)
       │
       │ Appel HTTP GET sécurisé (token AUTO_BLOG_SECRET)
       ▼
[ API Web : https://djerbavoyage.tn/api/auto-blog/generate ]
       │
       ├─► DjerbaContextFetcherService (Météo live + 12 angles d'immersion)
       ├─► PdoArticleRepository (Exclusion des 15 derniers articles pour anti-duplication)
       ├─► Google Gemini API (Génération du contenu H2/H3, FAQ, image prompt, post Facebook)
       ├─► PdoArticleRepository (Sauvegarde de l'article en base de données)
       ├─► SitemapService (Régénération automatique de sitemap.xml)
       └─► FacebookPublisherService (Publication directe sur Facebook photo.djerba)
```

---

## 5. Commandes & Outils sur `root@192.168.0.129`

- **Exécution manuelle immédiate** :
  ```bash
  /usr/local/bin/djerba_bot.sh
  ```
- **Diagnostic instantané de l'état du bot** :
  ```bash
  djerba-status
  ```
- **Consultation des journaux d'exécution** :
  ```bash
  tail -n 50 /var/log/djerba_bot.log
  ```
