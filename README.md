# company-landing-page
Simple PHP Company landing page with video in background


# Server setup Ubuntu + 
```
apt update && apt upgrade -y
apt install ufw git unzip curl -y

adduser deploy           # create non-root user
usermod -aG sudo deploy
usermod -aG www-data deploy  # for web files
```

# Copy your SSH key to the new user (from your local machine)
# Or from root: su - deploy && mkdir ~/.ssh && chmod 700 ~/.ssh
# Then paste your pub key into ~/.ssh/authorized_keys

```
ufw allow OpenSSH
ufw allow 80
ufw allow 443
ufw enable
```

# From now on, SSH as deploy@IP instead of root.

# Install Nginx + PHP 8.3 (current stable in 2026)
