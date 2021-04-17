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

## Usage

Use `docker-compose up --build` to build the project for the first time and run it. To deploy it, steps described in the ApiPlatform https://api-platform.com/docs/deployment/ should be taken.

The following addresses should be used to interact with the shortener:

| verb | address                              | description                                |
|------|--------------------------------------|--------------------------------------------|
| GET  | http://localhost/docs                | API documentation generated with Swagger   |
| POST | http://localhost/api/shorten         | Shorten an URL. Body: {"url":"url-string"} |
| GET  | http://localhost/{id}                | Use shortened URL as a redirect            |
| GET  | http://localhost/api/{id}            | See shortened URL data and a visitor count |
|DELETE| http://localhost/api/{id}            | Remove shortened URL                       |
| GET  | http://localhost/admin               | Use ApiPlatform-provided admin panel       |

