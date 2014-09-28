#!/bin/bash
# \
# Automatically Upload Website to Testing/Remote Servers
# Also compresses js/css/html files
# 
# usage: ./upload.sh [remote] [compress]
#
# Author: Jonathan Chapple
#
# Note: *auth=password doesn't work in windows (no expect command)
# Recommend using ssh keys (and the option none here) instead (or none and 
# enter password manually
###################################################################################################

### options ###
test_address=server@192.168.1.5
test_path=/var/www
test_auth=none #pem|password|none
test_pem=
test_password=

remote_address=ubuntu@openrobotics.ca
remote_path=/var/www/openrobotics
remote_auth=none #pem|password|none
remote_pem=/c/creds/openrobotics/aws-or1.pem
remote_password=

# will be executed on the server after upload
extra_commands="chmod 777 -R upload_content roster > /dev/null 2>&1"
################

echo "Creating target directory"
shopt -s extglob dotglob
mkdir target
cp -r !(.|..|.git|resources|Templates|*.sh|*.jar|target|schema|npp_workspace*|npp|*.pem|*.sql) target/
cp .htaccess target/
cd target
shopt -u extglob dotglob

#compress for remote server
if [ "$1" == "remote" ]; then
	find . -type f -name '*.css' -size +0 -exec echo "Compressing '{}'" \; \
		-exec java -jar ../yuicompressor-2.4.8.jar {} -o {} \;
	find . -type f -name '*.js' -size +0 -exec echo "Compressing '{}'" \; \
		-exec java -jar ../yuicompressor-2.4.8.jar {} -o {} \;
	find . -type f -name '*.php' -not -path '*Excel*' -not -name '*Excel*' -size +0 -exec echo "Compressing '{}'" \; \
		-exec java -jar ../htmlcompressor-1.5.3.jar {} -o {} --preserve-php \;
	find . -type f -name '*.html' -size +0 -exec echo "Compressing '{}'" \; \
		-exec java -jar ../htmlcompressor-1.5.3.jar {} -o {} \;
fi

cd ..
echo "Compressing target directory"
tar -zcf target.tar.gz target/*

echo "Uploading target directory"

if [ "$1" == "remote" ]; then
	if [ "$remote_auth" == "password" ]; then
		spawn scp target.tar.gz "$remote_address":"$remote_path"
		expect "assword: "
		send "$remote_password\r"
	elif [ "$remote_auth" == "pem" ]; then
		scp -i "$remote_pem" target.tar.gz "$remote_address":"$remote_path"
	else
		scp target.tar.gz "$remote_address":"$remote_path"
	fi
	
else 
	if [ "$test_auth" == "password" ]; then
		spawn scp target.tar.gz "$test_address":"$test_path"
		expect "assword: "
		send "$test_password\r"
	elif [ "$test_auth" == "pem" ]; then
		scp -i "$test_pem" target.tar.gz "$test_address":"$test_path"
	else
		scp target.tar.gz "$test_address":"$test_path"
	fi
fi

echo "Decompress target directory on server"

if [ "$1" == "remote" ]; then
	if [ "$remote_auth" == "password" ]; then
		ssh "$remote_address" "cd $remote_path && tar -xf target.tar.gz && cp -r target/* . && rm -rf target && rm target.tar.gz && $extra_commands"
		expect "assword: "
		send "$remote_password\r"
	elif [ "$remote_auth" == "pem" ]; then
		ssh -i "$remote_pem" "$remote_address" "cd $remote_path && tar -xf target.tar.gz && cp -r target/* . && rm -rf target && rm target.tar.gz && $extra_commands"
	else
		ssh "$remote_address" "cd $remote_path && tar -xf target.tar.gz && cp -r target/* . && rm -rf target && rm target.tar.gz && $extra_commands"
	fi		
else
	if [ "$test_auth" == "password" ]; then
		ssh "$test_address" "cd $test_path && shopt -s dotglob && tar -xf target.tar.gz && cp -r target/* . && rm -rf target && rm target.tar.gz && $extra_commands"
		expect "assword: "
		send "$test_password\r"
	elif [ "$test_auth" == "pem" ]; then
		ssh -i "$test_pem" "$test_address" "cd $test_path && shopt -s dotglob && tar -xf target.tar.gz && cp -r target/* . && rm -rf target && rm target.tar.gz && $extra_commands"
	else
		ssh "$test_address" "cd $test_path && shopt -s dotglob && tar -xf target.tar.gz && cp -r target/* . && rm -rf target && rm target.tar.gz && $extra_commands"
	fi
fi

echo "Clean up"
rm target.tar.gz
rm -rd target
