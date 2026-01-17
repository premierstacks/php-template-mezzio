# Default shell
SHELL := /bin/bash

# Default goal
.DEFAULT_GOAL := never

# Goals
.PHONY: commit
commit: distclean update fix check

.PHONY: fix
fix: fix_eslint fix_prettier fix_php_cs_fixer fix_yaml

.PHONY: check
check: lint stan test audit

.PHONY: lint
lint: lint_eslint lint_prettier lint_php_cs_fixer

.PHONY: stan
stan: stan_phpstan

.PHONY: test
test: test_phpunit

.PHONY: coverage
coverage: ./.phpunit.coverage/html
	php -S 0.0.0.0:8000 -t ./.phpunit.coverage/html

.PHONY: audit
audit: audit_npm audit_composer

.PHONY: install
install: install_npm install_composer

.PHONY: update
update: update_npm update_composer

.PHONY: clean
clean:
	rm -rf ./.php-cs-fixer.cache
	rm -rf ./.phpunit.cache
	rm -rf ./.phpunit.coverage
	rm -rf ./.phpunit.result.cache
	rm -rf ./node_modules
	rm -rf ./vendor

.PHONY: distclean
distclean: clean
	git clean -Xfd

.PHONY: fix_eslint
fix_eslint: ./node_modules ./eslint.config.js
	npm exec -- eslint --fix .

.PHONY: fix_prettier
fix_prettier: ./node_modules ./prettier.config.js
	npm exec -- prettier -w .

.PHONY: fix_php_cs_fixer
fix_php_cs_fixer: ./vendor ./.php-cs-fixer.php
	composer exec -- php-cs-fixer fix

.PHONY: fix_yaml
fix_yaml:
	find . -type f -name "*.yml" -exec yq -i 'sort_keys(..)' {} \;

.PHONY: lint_eslint
lint_eslint: ./node_modules ./eslint.config.js
	npm exec -- eslint .

.PHONY: lint_prettier
lint_prettier: ./node_modules ./prettier.config.js
	npm exec -- prettier -c .

.PHONY: lint_php_cs_fixer
lint_php_cs_fixer: ./vendor ./.php-cs-fixer.php
	composer exec -- php-cs-fixer check

.PHONY: stan_phpstan
stan_phpstan: ./vendor ./phpstan.neon
	composer exec -- phpstan analyse

.PHONY: test_phpunit
test_phpunit: ./vendor ./phpunit.xml
	composer exec -- phpunit

.PHONY: audit_npm
audit_npm: ./node_modules ./package.json ./package-lock.json
	npm audit --audit-level info --install-links --include prod --include dev --include peer --include optional

.PHONY: audit_composer
audit_composer: ./vendor ./composer.json ./composer.lock
	composer audit
	composer check-platform-reqs
	composer validate --strict --with-dependencies --check-lock
	composer dump-autoload --optimize --strict-psr --strict-ambiguous

.PHONY: install_npm
install_npm: ./package.json ./package-lock.json
	npm ci --install-links --include prod --include dev --include peer --include optional --ignore-scripts

.PHONY: install_composer
install_composer: ./composer.json ./composer.lock
	composer install --no-autoloader
	composer dump-autoload --optimize --strict-psr --strict-ambiguous

.PHONY: update_npm
update_npm: ./package.json
	rm -rf ./node_modules
	rm -rf ./package-lock.json
	npm update --install-links --include prod --include dev --include peer --include optional --ignore-scripts

.PHONY: update_composer
update_composer: ./composer.json
	rm -rf ./vendor
	rm -rf ./composer.lock
	composer update --no-autoloader --with-all-dependencies
	composer dump-autoload --optimize --strict-psr --strict-ambiguous

.PHONY: postcreate
postcreate: install migrate

.PHONY: start serve server dev
start serve server dev: ./vendor ./index.php ./composer.json ./composer.lock
	php -S 0.0.0.0:8000 ./index.php

.PHONY: migrate
migrate: ./vendor ./bin/migrate_up.php ./composer.json ./composer.lock
	php ./bin/migrate_up.php

.PHONY: prune
prune:
	docker container prune -f
	docker image prune --all -f
	docker network prune -f
	docker volume prune --all -f
	docker builder prune --all -f
	docker buildx prune --all -f
	docker system prune --all --volumes -f

.PHONY: image
image:
	docker compose -f ./docker-compose.yml -f ./docker-compose-swarm.yml build --pull --push

.PHONY: deploy
deploy:
	docker stack deploy -c ./docker-compose.yml -c ./docker-compose-swarm.yml --with-registry-auth --prune --detach=false --resolve-image=always ${CI_PROJECT_PATH_SLUG:-php-template-mezzio}

.PHONY: up
up:
	docker compose -f ./docker-compose.yml up --build --remove-orphans --always-recreate-deps --force-recreate --pull=always --renew-anon-volumes

.PHONY: down
down:
	docker compose down -v --remove-orphans --rmi=local

.PHONY: password
password:
	@tr -dc 'a-zA-Z0-9' < /dev/urandom | head -c 32

.PHONY: secret
secret:
	@tr -dc 'a-zA-Z0-9' < /dev/urandom | head -c 64

# Dependencies
./.phpunit.coverage/html:
	${MAKE} test_phpunit

./composer.lock ./vendor: ./composer.json
	${MAKE} update_composer

./package-lock.json ./node_modules: ./package.json
	${MAKE} update_npm
