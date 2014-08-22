shopt -s extglob
mkdir target
cp -r !(resources|Templates|*.sh|*.jar|target|schema|npp_workspace*) target/
cp .htaccess target/
cd target
#find . -type f -name '*.css' -exec java -jar ../yuicompressor-2.4.8.jar {} -o {} \;
#find . -type f -name '*.js' -exec java -jar ../yuicompressor-2.4.8.jar {} -o {} \;
#find a way to compress php files ...


scp -r * .htaccess server@192.168.1.12:/var/www/
#scp -r * .htaccess jono@animecommandcenter.tk:/opt/wwwor1/


cd ..
rm -rd target