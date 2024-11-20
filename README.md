### Lluis Puig Test for Sesame HR

## Installation

Hi! These are the steps to follow

1. Download the project from https://github.com/lluis13/Sesame-Test.git
2. init the docker with:
```
make docker-compose-build-up
```
3. once finished, you can execute the tests with:
```
make run-tests
```
4. Execute the http requests from sesame-api/src/doc/sesame_api_test.http [step by step information inside the file]

5. If want to check the database:
```
Host: localhost
Port: 3306
User: app
Password: p@ssw0rd
Schema: app
