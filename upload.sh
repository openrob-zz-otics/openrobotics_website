echo "Creating target directory"
shopt -s extglob
mkdir target
cp -r !(resources|Templates|*.sh|*.jar|target|schema|npp_workspace*|npp_project*) target/
cp .htaccess target/
cd target
find . -type f -name '*.css' -size +0 -exec java -jar ../yuicompressor-2.4.8.jar {} -o {} \; -exec echo "Compressing '{}'" \;
find . -type f -name '*.js' -size +0 -exec java -jar ../yuicompressor-2.4.8.jar {} -o {} \; -exec echo "Compressing '{}'" \;
#find a way to compress php files ...
find . -type f -name '*.php' -size +0 -exec java -jar ../htmlcompressor-1.5.3.jar {} -o {} --preserve-php \; -exec echo "Compressing '{}'" \;

cd ..
echo "Compressing target directory"
tar -zcf target.tar.gz target/*

echo "Uploading target directory"
scp target.tar.gz server@192.168.1.5:/var/www
echo "Decompress target directory on server"
ssh server@192.168.1.5 'cd /var/www && tar -xf target.tar.gz && cp -r target/* . && rm -rf target && rm target.tar.gz'

#scp target.tar.gz jono@animecommandcenter.tk:/opt/wwwor1
#ssh jono@animecommandcenter.tk 'cd /opt/wwwor1 && tar -xf target.tar.gz && cp -r target/* . && rm -rf target && rm target.tar.gz'

echo "Clean up"
rm target.tar.gz
rm -rd target
