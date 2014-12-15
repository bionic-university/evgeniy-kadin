php composer.phar install
chmod 777 cache
rm -rf cache/*
cd bin;
./console orm:schema-tool:update --force
 php fixture.php
