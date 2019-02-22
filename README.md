## Quickstart guide

##### 1) Clone the repository

    git clone https://github.com/MariusLab/Less-Real.git
    
##### 2) CD into root folder and pull laradock:
    
    cd <path/to/project>
    git submodule init
    git submodule update
     
##### 3) Overwrite laradock default config

    cp -R config/laradock/ .
    
##### 4) Run laradock:
  
    cd laradock
    docker-compose up -d apache2 mysql workspace

##### 5) To enter containers use:
    
    docker exec -ti --user=laradock laradock_workspace_1 /bin/bash
    docker exec -ti laradock_mysql_1 /bin/bash
    
##### 6) Once you entered the workspace container:

    composer install
    npm install
    yarn encore dev
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    php bin/console doctrine:database:create --env=test
    php bin/console doctrine:migrations:migrate --env=test    
    
##### 7) Now open localhost on your browser and get to work!
   
   
## Cheatsheet

   Publish dev assets to public

    yarn encore dev

   
   Publish dev assets to public as soon as they change
   
    yarn encore dev --watch
         
    
      
    
