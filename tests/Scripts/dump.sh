#!/bin/bash
# This script will send line per line the output of "php artisan" command to a markdown file.

sudo rm -rf /var/www/Learn-Symfony/temp.txt
sudo rm -rf /var/www/Learn-Symfony/symfony.md

artisan_dump=sudo php /var/www/Learn-Symfony/bin/console > /var/www/Learn-Symfony/temp.txt

while read line
do

case "${line}" in
    "Available commands:")
	echo "##**${line}**\n" | tee -a "/var/www/Learn-Symfony/symfony.md"
	;;
    *" "*)
	echo "${line}\n" | tee -a "/var/www/Learn-Symfony/symfony.md"
	;;
    *)
	if [ ${#var} -lt 4 ];
	then
	echo "----\n" | tee -a "/var/www/Learn-Symfony/symfony.md"
	else
	echo "##**${line}**\n" | tee -a "/var/www/Learn-Symfony/symfony.md"
        fi
	;;
esac

#   if [ ${line} -eq *" "* ]
#   then
#	echo "**${line}**\n" | tee -a "/var/www/main/artisan.md"
#   else
#	echo "${line}\n" | tee -a "/var/www/main/artisan.md"
#   fi

done < /var/www/Learn-Symfony/temp.txt

sudo rm /var/www/Learn-Symfony/temp.txt
