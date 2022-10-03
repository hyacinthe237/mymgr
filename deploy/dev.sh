npm run prod-backend
npm run prod

rsync -rav --delete --exclude-from=.excludes ./ root@digital:/var/www/mymgr && ssh root@digital "cd /var/www/mgr && sh ./post-deploy.sh"
