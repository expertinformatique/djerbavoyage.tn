import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
password = os.environ.get('DEBIAN_SSH_PASSWORD', 'YOUR_DEBIAN_SSH_PASSWORD')
ssh.connect('192.168.0.129', username='root', password=password)
stdin, stdout, stderr = ssh.exec_command("find /var/www /root -name '.env*' 2>/dev/null")
print("Found env files:\n", stdout.read().decode())
ssh.close()
