## Pré-requis
- php 8.1
- node v18
- mysql

## Déploiement

La variable d'environnement suivante doit être remplie avec l'URL du webhook présente dans la description du canal `client-poc-deploy-logs`.
```
LOG_SLACK_WEBHOOK_URL=
```

S'assurer de remplir les accès à la base de données
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=demo
DB_USERNAME=
DB_PASSWORD=
```

## Installation
```
composer install
npm install
npm run build
php artisan migrate
```

## Scheduler & queues
Permet d'exécuter des commandes sur des fréquences définies.
Ici, une commande est lancée une fois par minute. Si le webhook Slack est correctement configuré, deux messages doivent être envoyés dans le canal. Un premier signalant le début de la commande, le second pour signalant la bonne exécution du job lancé en queue.

### Scheduler
En local, il suffit de lancer la commande `php artisan schedule:work`. En production, il faut utiliser une tâche cron :
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
``` 
- [Docs Running scheduler](https://laravel.com/docs/10.x/scheduling#running-the-scheduler)

### Queues
Ce système ce démarre via la commande `php artisan queue:work`.
Pour garder cette commande active tout le temps, il faut utiliser un Supervisor qui s'assure de son bon fonctionnement. 

Lors du déploiement, il est important d'exécuter la commande `php artisan queue:restart` pour éviter que le système ne prenne pas en compte les modifications apportées à l'application du fait de sa mise en cache.

- [Docs Running Queue](https://laravel.com/docs/9.x/queues#running-the-queue-worker)
- [Docs Supervisor](https://laravel.com/docs/9.x/queues#supervisor-configuration)

### SSR
Pour les besoins SEO, le rendu de l'application doit se faire en mode SSR. La commande `php artisan inertia:start-ssr` s'occupe de cette partie. Il y a de fortes chances qu'il faille également controller cette commande via un Supervisor pour la maintenir en fonctionnement.

Pour vérifier le bon fonctionnement de celle-ci :
- se rendre sur la home
- afficher le code source de la page (et non pas l'inspecteur)
- rechercher via CMD+F le terme `SEO`.

Si celui-ci apparait, le rendu de la page est bien effectué en SSR.