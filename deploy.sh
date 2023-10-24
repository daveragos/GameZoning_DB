#!/bin/bash

HOST="ftp.artseb.studio" # Replace with your cPanel FTP server hostname
USERNAME="gamezone@artseb.studio" # Replace with your cPanel FTP_username
PASSWORD="gamezone_artsebstudio" # Replace with your cPanel FTP password

TARGETDIR="/" # Replace with the target directory on your cPanel account

echo "Deploying code to cPanel..."

lftp -c "open -u $USERNAME,$PASSWORD $HOST; set ssl:verify-certificate no; mirror -R ./ $TARGETDIR --ignore-time --parallel=10 --exclude-glob .git* --exclude .github* --exclude deploy.sh"

echo "Deployment completed Successfully!"
