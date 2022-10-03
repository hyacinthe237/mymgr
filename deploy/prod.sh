npm run prod-backend
npm run prod

rsync -rav --delete --exclude-from=.excludes ./ root@yummooh:/var/www/yummooh && ssh root@yummooh "cd /var/www/yummooh && sh ./post-deploy.sh"
