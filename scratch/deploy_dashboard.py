import paramiko
import os
import sys

def upload_dashboard():
    host = '192.168.0.129'
    user = 'root'
    password = os.environ.get('DEBIAN_SSH_PASSWORD', 'YOUR_DEBIAN_SSH_PASSWORD')
    
    print(f"Connecting to {host}...", flush=True)
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    
    try:
        ssh.connect(host, username=user, password=password, timeout=5)
        print("Connected via SSH. Opening SFTP...", flush=True)
        sftp = ssh.open_sftp()
        
        local_dir = os.path.join(os.path.dirname(__file__), 'debian_dashboard')
        remote_dir = '/var/www/html'
        
        files = ['index.php', 'api.php']
        for fname in files:
            local_path = os.path.join(local_dir, fname)
            remote_path = f"{remote_dir}/{fname}"
            print(f"Uploading {local_path} -> {remote_path}...", flush=True)
            sftp.put(local_path, remote_path)
            print(f"Uploaded {fname} successfully.", flush=True)
            
        sftp.close()
        
        print("Setting permissions on Debian server...", flush=True)
        commands = [
            "chown -R www-data:www-data /var/www/html",
            "chmod -R 755 /var/www/html",
            "chmod 666 /var/log/djerba_bot.log",
            "ls -la /var/www/html"
        ]
        for cmd in commands:
            stdin, stdout, stderr = ssh.exec_command(cmd)
            out = stdout.read().decode('utf-8', 'replace')
            err = stderr.read().decode('utf-8', 'replace')
            if out:
                print(f"[{cmd}] OUT:\n{out}", flush=True)
            if err:
                print(f"[{cmd}] ERR:\n{err}", flush=True)
                
        print("Deployment completed successfully!", flush=True)
    except Exception as e:
        print(f"Deployment error: {e}", flush=True)
        sys.exit(1)
    finally:
        ssh.close()

if __name__ == '__main__':
    upload_dashboard()
