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

_Copy your SSH key to the new user (from your local machine)_
_Or from root:_
```
su - deploy && mkdir ~/.ssh && chmod 700 ~/.ssh
```

_Then paste your pub key into ~/.ssh/authorized_keys_

```
ufw allow OpenSSH
ufw allow 80
ufw allow 443
ufw enable
```

_From now on, SSH as deploy@IP instead of root._

# Install Nginx + PHP 8.3 (current stable in 2026)

sudo apt install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

sudo apt install -y nginx php8.3 php8.3-fpm php8.3-cli php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip



