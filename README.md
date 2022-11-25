# Create project
`docker-compose up -d`

# Migrate database
`docker-compose exec php php bin/console doctrine:migrations:migrate`

# Start messenger
`docker-compose exec php php bin/console messenger:consume -vv`

# Download articles
`docker-compose exec php php bin/console app:download-news`
