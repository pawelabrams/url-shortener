# Url shortener

## Requirements

1. Ability to create, read and delete shortened URLs,
2. Written in PHP and Symfony,
3. API endpoints should be located under /api.
4. Redirection should take place with the simplest URL possible (/{id})
5. Code should be accompanied by a reasonable test suite.
6. Code and interfaces are well-documented.
7. *(optional)* Redirections should be counted and the visitor count should be available through API.
8. *(optional)* Make filters available in collection endpoint.
9. *(optional)* Authorization and authentication may be left unaddressed in the project.

## Design decisions

1. Shortened url should consist only of numbers and consonants to avoid meaningful and offending phrases.
2. Chosen name for the url shortening objects' class is "Shorten". This allows the creation endpoint to be most straightforward (POST /shorten) and serves as a nice and short nickname 
3. API endpoints are named after singular form of the entities they represent – this is a personal preference of the author.
4. ApiPlatform was used as a developer-friendly way of achieving the high documentation expectations and ease of adding new features.
5. Unnecessary features were removed from the basic distribution of ApiPlatform to minimise the potential attack surface of the system.
6. Sequential URLs were used.

## Usage

Use `docker-compose up --build` to build the project for the first time and run it. To deploy it, steps described in the ApiPlatform https://api-platform.com/docs/deployment/ should be taken.

When accessing the application for the first time in dev mode, there will be an error regarding a self-signed certificate. In prod, a bought certificate or a free (eg. Let's Encrypt) one should be used.

The following addresses should be used to interact with the shortener:

| verb | address                              | description                                |
|------|--------------------------------------|--------------------------------------------|
| GET  | http://localhost/docs                | API documentation generated with Swagger   |
| POST | http://localhost/api/shorten         | Shorten an URL. Body: {"url":"url-string"} |
| GET  | http://localhost/{id}                | Use shortened URL as a redirect            |
| GET  | http://localhost/api/{id}            | See shortened URL data and a visitor count |
|DELETE| http://localhost/api/{id}            | Remove shortened URL                       |
| GET  | http://localhost/admin               | Use ApiPlatform-provided admin panel       |
| GET  | http://localhost/                    | A test webpage using the url shortener     |

Use `docker-compose exec php bin/test` to run the test suite on a running container. A separate MongoDB collection, `url-shortener-test` will be used.
In case there is a problem similar to "`composer install` required", clear Symfony-PHPUnit bridge's cache using `rm -rd bin/.phpunit` while in `api` directory on the container or host machine (whichever is applicable).

## Ways to improve

1. Generate only one shortened URL for every URL in the database – if there already is a shorten for a given URL, return it instead.
2. Add an option to make URLs random.
3. Add an option to make URLs generate upwards of a given value, so that there aren't any inconsistencies in the URL's length (with sequential IDs, the length is padded to at least 6 characters).
4. If the app was a part of a larger structure, hexagonal architecture might be more beneficial than a slim directory structure.
