import paramiko
import json

def seed():
    host = '192.168.0.129'
    user = 'root'
    password = os.environ.get('DEBIAN_SSH_PASSWORD', 'YOUR_DEBIAN_SSH_PASSWORD')
    
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(host, username=user, password=password, timeout=10)
    sftp = ssh.open_sftp()
    
    # 1. Update bots.json
    try:
        with sftp.open('/var/www/html/data/bots.json', 'r') as f:
            raw = f.read().decode('utf-8')
            bots_data = json.loads(raw)
    except Exception as e:
        print(f"Error reading bots.json: {e}", flush=True)
        bots_data = {'bots': []}
        
    bot_list = bots_data.get('bots', []) if isinstance(bots_data, dict) else bots_data
    for b in bot_list:
        bid = b.get('id', '')
        if bid in ['bot_guide_patrimoine', 'bot_guide_principal']:
            b['categories'] = ['patrimoine', 'general']
        elif bid in ['bot_menzels_hotels', 'bot_menzel_hebergement']:
            b['categories'] = ['hebergements', 'gastronomie', 'general']
        elif bid in ['bot_kitesurf_nautique', 'bot_kitesurf_plages']:
            b['categories'] = ['plages', 'excursions', 'general']
        elif 'categories' not in b or not b['categories']:
            b['categories'] = ['all']
            
    with sftp.open('/var/www/html/data/bots.json', 'w') as f:
        f.write(json.dumps({'bots': bot_list} if isinstance(bots_data, dict) else bot_list, indent=4, ensure_ascii=False))
    print("SUCCESS: bots.json updated with categories.", flush=True)
    
    # 2. Update queue.json
    try:
        with sftp.open('/var/www/html/data/queue.json', 'r') as f:
            raw = f.read().decode('utf-8')
            queue_data = json.loads(raw)
    except Exception as e:
        print(f"Error reading queue.json: {e}", flush=True)
        queue_data = {'topics': [], 'images': []}
        
    topic_categories = {
        'Top 5 des Meilleurs Spots Secrets de Kitesurf à la Lagune de Djerba': 'plages',
        "L'Architecture des Menzels et Houchs Traditionnels : Écologie et Climatisation Naturelle": 'hebergements',
        'Immersion dans les Ateliers Troglodytes des Maîtres Potiers de Guellala': 'patrimoine',
        'La Synagogue de la Ghriba : Joyau Millénaire et Mémoire Vivante de Djerba': 'patrimoine',
        'Où Déguster les Meilleurs Poissons Frais et Spécialités Djerbiennes à Houmt Souk ?': 'gastronomie',
        "Escapade en Voilier vers l'Île aux Flamants Roses (Ras Rmel) : Le Guide Complet": 'excursions',
        '7 Conseils Indispensables pour Réussir son Premier Séjour à Djerba en Toute Sérénité': 'vie_pratique'
    }
    
    for t in queue_data.get('topics', []):
        title = t.get('title', '')
        if title in topic_categories:
            t['category'] = topic_categories[title]
        elif 'category' not in t or not t['category']:
            t['category'] = 'general'
            
    for img in queue_data.get('images', []):
        url = img.get('image_url', '').lower()
        if 'kitesurf' in url:
            img['category'] = 'plages'
        elif 'concierge' in url:
            img['category'] = 'vie_pratique'
        elif 'category' not in img or not img['category']:
            img['category'] = 'general'
            
    with sftp.open('/var/www/html/data/queue.json', 'w') as f:
        f.write(json.dumps(queue_data, indent=4, ensure_ascii=False))
    print("SUCCESS: queue.json updated with categories.", flush=True)
    
    sftp.close()
    
    # Permissions
    ssh.exec_command("chown -R www-data:www-data /var/www/html/data && chmod -R 775 /var/www/html/data")
    ssh.close()
    print("Permissions restored.", flush=True)

if __name__ == '__main__':
    seed()
