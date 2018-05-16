# Tasks for make - build automation tool.

__start__:
	@echo 'Project Cards'

fixtures:
	bin/console doctrine:fixtures:load -n
