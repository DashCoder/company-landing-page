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

```
sudo apt install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

sudo apt install -y nginx php8.3 php8.3-fpm php8.3-cli php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip
```

# Clone your Git repository

cd /var/www
sudo mkdir your-landing
sudo chown deploy:www-data your-landing
cd your-landing

git clone https://github.com/yourusername/your-repo.git .
_or git clone git@github.com:yourusername/your-repo.git .  (if using SSH keys)_

# Configure Nginx
```
sudo nano /etc/nginx/sites-available/your-landing
```

```
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com YOUR_DROPLET_IP;

    root /var/www/your-landing;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }

    # Optional: serve large video files efficiently
    location ~* \.(mp4|webm)$ {
        add_header Accept-Ranges bytes;
        expires 30d;
    }
}
```

#  Enable website
sudo ln -s /etc/nginx/sites-available/your-landing /etc/nginx/sites-enabled/
sudo nginx -t          # check syntax
sudo systemctl reload nginx

# Optional

_Install composer for dependencies in .cfg file_
```
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
cd /var/www/your-landing
composer install --no-dev --optimize-autoloader

```

