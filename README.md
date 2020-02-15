# videoslots-coding-challenge
Coding challenge - Create a game

## ** Test specification ** 
[Link to the test specification](https://github.com/felipedecampos/videoslots-coding-challenge/tree/master/docs/backend-developer-assessment.pdf)

## ** What has been done **

First, you will need to install the application environment with docker-compose

[Go to "How to install the project environment"](https://github.com/felipedecampos/videoslots-coding-challenge#how-to-install-the-project-environment)

Then you will need enter into **videoslots-php-fpm** container to run the command to play the game.

Enter into your **Linux** console and run:

```shell
$ docker exec -it videoslots-php-fpm /bin/bash
```

Into the container you can run the command to play the game:

```shell
$ php artisan videoslots:game
```

You will see a json response with the result of the game played.

Examples: 

```json
{"board":["monkey","dog","10","9","bird","cat","monkey","monkey","10","bird","9","Q","monkey","bird","Q"],"paylines":[{"0 4 8 10 12":3}],"bet_amount":100,"total_win":20}
```

```json
{"board":["9","bird","J","monkey","Q","monkey","Q","bird","10","cat","monkey","Q","K","Q","Q"],"paylines":[],"bet_amount":100,"total_win":0}
```
## ** PHP Standards Recommendations **

To validate the code for consistency with a coding standard go to the **project folder** and run the commands:

**PSR-1**
```shell
$ vendor/bin/phpcs --standard=PSR1 --extensions=php --ignore=*/database/*,*/resources/*,*/storage/*,*/vendor/*,*/public/index.php,*/tests/bootstrap.php,*/bootstrap/cache/* .
```

**PSR-2**

```shell
$ vendor/bin/phpcs --standard=PSR2 --extensions=php --ignore=*/database/*,*/resources/*,*/storage/*,*/vendor/*,*/public/index.php,*/tests/bootstrap.php,*/bootstrap/cache/* .
```

**PSR-12**

```shell
$ vendor/bin/phpcs --standard=PSR12 --extensions=php --ignore=*/database/*,*/resources/*,*/storage/*,*/vendor/*,*/public/index.php,*/tests/bootstrap.php,*/bootstrap/cache/* .
```

#### How to install the project environment

#### requirements:

- **docker** version >**17.05.0-ce**
- **docker-compose** version >**1.19.0**
- **git** version >**2.7.4**

To know your docker version run:

```shell
$ docker -v
```

To know your docker-composer version run:

```shell
$ docker-compose -v
```

To know your git version run:

```shell
$ git --version
```

**To install the environment, follow the steps below:**

Open your **Linux** console and enter into the workspace you want to clone the project.

Now you need to clone the **project**:

```shell
$ git clone https://github.com/felipedecampos/videoslots-coding-challenge.git
```

Then you need to enter into the project folder **videoslots-coding-challenge**:

```shell
$ cd videoslots-coding-challenge
```

Now we need to create the **.env** file:

```shell
$ cp .env.example .env
```

**Note: Please, make sure you are not using the same IP and PORT (PHP and NGINX) mentioned into the .env file # Docker block**

If you are already using the IP or PORT, please, replace for another one.

The next thing you should do is set your application key to a random string. Typically, this string should be 32 characters long. The key can be set in the **.env** file.

After that, lets install the environment with **docker-compose**:

**Note: Please, make sure you have docker and docker-compose already installed in your computer**

```shell
$ docker-compose up -d
```

When the containers is already running, you will need to install composer:

```shell
$ docker exec videoslots-php-fpm /bin/bash -c "composer install"
```

Now, you just need to set your host with the IP and hostname of your api:

**Note: Please, make sure if you changed the IP in your .env file you need to change the command bellow to match with your modificaton**

```shell
$ sudo -- sh -c -e "echo '193.168.111.2\tapi.videoslots.local' >> /etc/hosts";
```
