import paramiko
import os
import sys

def deploy():
    host = '192.168.0.129'
    user = 'root'
    password = os.environ.get('DEBIAN_SSH_PASSWORD', 'YOUR_DEBIAN_SSH_PASSWORD')
    
    print(f"Connecting to {host}...", flush=True)
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    
    try:
        ssh.connect(host, username=user, password=password, timeout=10)
        sftp = ssh.open_sftp()
        
        base_dir = os.path.dirname(__file__)
        dashboard_dir = os.path.join(base_dir, 'debian_dashboard')
        
        # 1. Upload runner script to /usr/local/bin
        runner_local = os.path.join(base_dir, 'djerba_multi_bot.sh')
        runner_remote = '/usr/local/bin/djerba_multi_bot.sh'
        print(f"Uploading runner: {runner_local} -> {runner_remote}...", flush=True)
        sftp.put(runner_local, runner_remote)
        
        # 2. Upload Web files & Environment config
        for fname in ['index.php', 'api.php']:
            local_path = os.path.join(dashboard_dir, fname)
            remote_path = f"/var/www/html/{fname}"
            print(f"Uploading web file: {fname}...", flush=True)
            sftp.put(local_path, remote_path)
            
        env_local = os.path.join(os.path.dirname(base_dir), '.env')
        if os.path.exists(env_local):
            print("Uploading .env configuration to /var/www/html/.env...", flush=True)
            sftp.put(env_local, '/var/www/html/.env')
            
        sftp.close()
        
        # 3. Server Configuration Commands
        print("Configuring Debian server permissions & sudoers...", flush=True)
        commands = [
            "chmod +x /usr/local/bin/djerba_multi_bot.sh",
            "mkdir -p /var/www/html/data /var/www/html/uploads/images",
            "chown -R www-data:www-data /var/www/html",
            "chmod -R 775 /var/www/html/data /var/www/html/uploads",
            "echo 'www-data ALL=(ALL) NOPASSWD: /usr/local/bin/djerba_multi_bot.sh, /usr/local/bin/djerba_bot.sh, /usr/bin/crontab, /usr/bin/systemctl' > /etc/sudoers.d/www-data",
            "chmod 440 /etc/sudoers.d/www-data",
            "touch /var/log/djerba_bot.log && chmod 666 /var/log/djerba_bot.log",
            "ls -la /var/www/html && ls -la /usr/local/bin/djerba_multi_bot.sh"
        ]
        
        for cmd in commands:
            stdin, stdout, stderr = ssh.exec_command(cmd)
            out = stdout.read().decode('utf-8', 'replace')
            err = stderr.read().decode('utf-8', 'replace')
            if out:
                print(f"[{cmd}] OUT:\n{out}", flush=True)
            if err:
                print(f"[{cmd}] ERR:\n{err}", flush=True)
                
        print("Deployment and Configuration completed successfully!", flush=True)
    except Exception as e:
        print(f"Deployment error: {e}", flush=True)
        sys.exit(1)
    finally:
        ssh.close()

if __name__ == '__main__':
    deploy()
