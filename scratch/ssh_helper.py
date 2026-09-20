import paramiko
import sys
import io

sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8', errors='replace')
sys.stderr = io.TextIOWrapper(sys.stderr.buffer, encoding='utf-8', errors='replace')

def run_ssh(host, user, password, command):
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    try:
        ssh.connect(host, username=user, password=password, timeout=5)
        stdin, stdout, stderr = ssh.exec_command(command)
        out = stdout.read().decode('utf-8', 'replace')
        err = stderr.read().decode('utf-8', 'replace')
        print("STDOUT:", flush=True)
        print(out, flush=True)
        print("STDERR:", flush=True)
        print(err, flush=True)
    except Exception as e:
        print(f"Error: {e}", flush=True)
    finally:
        ssh.close()

if __name__ == '__main__':
    pwd = os.environ.get('DEBIAN_SSH_PASSWORD', 'YOUR_DEBIAN_SSH_PASSWORD')
    run_ssh('192.168.0.129', 'root', pwd, sys.argv[1])
